<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;

class ForecastService
{
    /** @var Carbon 基準日（.env の FORECAST_BASE_DATE があればそれ、無ければ今日） */
    private Carbon $today;

    public function __construct()
    {
        $this->today = Carbon::parse(env('FORECAST_BASE_DATE', now()->toDateString()))
                            ->startOfDay();
    }

    /**
     * 直近N日（既定14日）の OUT 平均を返す
     * @return array{avg_daily: float}
     */
    public function forecastDailyDemand(Product $product, int $windowDays = 14): array
    {
        // 期間：基準日を含む過去 N-1 日間
        $to   = $this->today->copy();
        $from = $this->today->copy()->subDays($windowDays - 1);

        $totalOut = (int) StockTransaction::query()
            ->where('product_id', $product->id)
            ->where('type', 'OUT')
            ->whereBetween('transaction_date', [
                $from->toDateString(), $to->toDateString()
            ])
            ->sum('quantity');

        $avgDaily = round($totalOut / max(1, $windowDays), 3);

        return ['avg_daily' => max(0.0, $avgDaily)];
    }

    /**
     * 在庫切れ日と発注推奨日を推定
     * @return array{stockout_date:?string, reorder_date:?string, days_to_stockout:?int}
     */
    public function simulateStockout(Product $product, float $avgDaily): array
    {
        $current = (int) ($product->current_stock ?? 0);

        if ($avgDaily <= 0) {
            return ['stockout_date' => null, 'reorder_date' => null, 'days_to_stockout' => null];
        }

        // 何日持つか（安全在庫到達 / 完全枯渇）
        $daysToSafety = (int) floor(max(0, $current - (int) $product->safety_stock) / $avgDaily);
        $daysToZero   = (int) floor(max(0, $current) / $avgDaily);

        $today = $this->today->copy();

        $stockoutDate = $today->copy()->addDays($daysToZero)->toDateString();

        // リードタイム分を前倒し、かつ安全在庫割れ前を優先
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
