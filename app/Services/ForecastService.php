<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;

class ForecastService
{
    /** @var Carbon 基準日 ※CarbonはPHPの日付操作を便利にする拡張ライブラリ*/
    private Carbon $today;  /**内部でしか使わないのでprivate*/

    public function __construct()
    {
        $this->today = Carbon::parse(env('FORECAST_BASE_DATE', now()->toDateString()))  /**（.env の FORECAST_BASE_DATE があればそれ、無ければ今日）*/
                            ->startOfDay();
    }

    /**
     * 直近N日間の出庫量（OUT）をもとに、1日あたりの平均出庫量を返す。
     *
     * @param Product $product 対象の商品
     * @param int     $windowDays 平均を算出する日数（デフォルト14日）
     * @return array{avg_daily: float} 日平均の出庫量
     */
    public function forecastDailyDemand(Product $product, int $windowDays = 14): array
    {
        // 期間：基準日を含む過去 N-1 日間
        // copy() する理由：元の日付を壊さないため
        $to   = $this->today->copy();                               // 2025-11-15
        $from = $this->today->copy()->subDays($windowDays - 1);     // 2025-11-15 - (14 - 1)日 = 2025-11-02
        
        // 出庫を集計するクエリ
        $totalOut = (int) StockTransaction::query()
            ->where('product_id', $product->id)                     // 特定の商品の
            ->where('type', 'OUT')                                  // 出庫だけを
            ->whereBetween('transaction_date', [                    // from toの期間で
                $from->toDateString(), $to->toDateString()
            ])
            ->sum('quantity');                                      // 集計
        
        // 1日あたりの平均出庫量を計算
        $avgDaily = round($totalOut / max(1, $windowDays), 3);

        return ['avg_daily' => max(0.0, $avgDaily)];                // 0.0はマイナスが出た場合の防御
    }

    /**
     * 現在庫・平均出庫量・安全在庫・リードタイムをもとに、在庫切れ予測日と発注推奨日を算出
     * 
     * @param Product $product 対象の商品
     * @param float   $avgDaily 1日あたりの平均出庫量
     * @return array{
     *      stockout_date: ?string,
     *      reorder_date: ?string,
     *      days_to_stockout: ?int
     */
    public function simulateStockout(Product $product, float $avgDaily): array
    {
        // Product が持つ現在庫を取得（null の可能性あり）
        $currentStock = $product->current_stock;

        // null のときは 0、それ以外は整数に変換
        if ($currentStock === null) {
            $current = 0;
        } else {
            $current = (int) $currentStock;
        }

        // 1日あたりの平均出庫量が0以下ならnullを返す
        if ($avgDaily <= 0) {
            return ['stockout_date' => null, 'reorder_date' => null, 'days_to_stockout' => null];
        }

        // 安全在庫に到達するまでの日数
        // （現在庫 − 安全在庫）を1日平均の出庫量で割った値。
        // 0未満にならないように補正したうえで、小数点以下は切り捨て。
        $daysToSafety = (int) floor(max(0, $current - (int) $product->safety_stock) / $avgDaily);

        // 完全に在庫が尽きるまでの日数
        // 現在庫を1日平均の出庫量で割った値。
        // こちらも0未満にならないよう補正し、小数点以下は切り捨て。
        $daysToZero   = (int) floor(max(0, $current) / $avgDaily);

        $today = $this->today->copy();      
        
        // 現在庫がゼロになる日を計算
        // 基準日（today）に「在庫が持つ日数（daysToZero）」を足した日付を在庫切れ日とする
        $stockoutDate = $today->copy()->addDays($daysToZero)->toDateString();       //toDateString():日付けとして扱う

        // --- 在庫切れ日・安全在庫・リードタイムをもとに、適切な発注推奨日を計算 --- 
        // $reorderBaseDays:リードタイムを考慮した「発注すべき最遅日」を計算
        // $reorderDays:安全在庫を割らないようにその日より前にずらす
        // $reorderDate:基準日からその日数分を足し、具体的な日付に変換
        $reorderBaseDays = max(0, $daysToZero - (int) $product->lead_time_days);
        $reorderDays     = min($reorderBaseDays, $daysToSafety);
        $reorderDate     = $today->copy()->addDays($reorderDays)->toDateString();

        return [
            'stockout_date'    => $stockoutDate,
            'reorder_date'     => $reorderDate,
            'days_to_stockout' => $daysToZero,
        ];
    }
}
