<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\StockTransaction;
use Carbon\Carbon;

class ForecastDemoSeeder extends Seeder
{
    public function run(): void
    {
        mt_srand(1234); // デモ用に乱数を固定（本番環境ではrandom_int()が使われる）
        
        $base = Carbon::parse(env('FORECAST_BASE_DATE', '2025-11-15')); // 基準日

        $p = Product::create([
            'name'           => 'シャープペン替芯 HB',
            'product_code'   => 'LEAD-HB',
            'price'          => 200,
            'safety_stock'   => 10,
            'lead_time_days' => 3,
        ]);

        // 初回入庫：11/01
        StockTransaction::create([
            'product_id'       => $p->id,
            'type'             => 'IN',
            'quantity'         => 100,
            'transaction_date' => '2025-11-01',
            'remarks'          => '初回入庫',
        ]);

        // 直近14日：11/02〜11/15 毎日 OUT=5
        // （基準日 11/15 を含む14日間）
        for ($d = 13; $d >= 0; $d--) {
            $day = $base->copy()->subDays($d)->toDateString(); // 11/02..11/15
            StockTransaction::create([
                'product_id'       => $p->id,
                'type'             => 'OUT',
                'quantity'         => 5,
                'transaction_date' => $day,
                'remarks'          => '販売',
            ]);
        }

        // ====== 残り14件：サンプル（基準日は同一／入出庫はランダム） ======
        // 再現性が欲しければシード固定も可（mt_srand(1234);）
        $names = [
            'ノート A5', 'ノート B5', 'ボールペン 黒', 'ボールペン 赤', '消しゴム',
            '定規 15cm', '付箋 75mm', 'クリアファイル', 'メモパッド', 'マーカー セット',
            '封筒 長形3号', 'ホッチキス', '替針', 'テープのり'
        ];

        for ($i = 0; $i < 14; $i++) {
            $name = $names[$i] ?? ('デモ商品' . ($i + 2));
            $code = 'DEMO-' . str_pad((string)($i + 2), 2, '0', STR_PAD_LEFT);

            $product = Product::create([
                'name'           => $name,
                'product_code'   => $code,
                'price'          => mt_rand(100, 5000),
                'safety_stock'   => mt_rand(5, 30),
                'lead_time_days' => mt_rand(1, 7),
            ]);

            // 初回入庫（11/01固定、数量はランダム）
            StockTransaction::create([
                'product_id'       => $product->id,
                'type'             => 'IN',
                'quantity'         => mt_rand(50, 200),
                'transaction_date' => $base->copy()->subDays(14)->toDateString(), // 2025-11-01
                'remarks'          => '初回入庫',
            ]);

            // 11/02〜11/15：日次のランダム出庫（0〜8個、2割の確率で0＝売れない日）
            for ($d = 13; $d >= 0; $d--) {
                $day = $base->copy()->subDays($d)->toDateString();
                $sold = (mt_rand(1, 100) <= 20) ? 0 : mt_rand(1, 8);
                if ($sold > 0) {
                    StockTransaction::create([
                        'product_id'       => $product->id,
                        'type'             => 'OUT',
                        'quantity'         => $sold,
                        'transaction_date' => $day,
                        'remarks'          => '販売',
                    ]);
                }
            }

            // 期間中にランダム補充入庫を0〜2回入れる
            $restockTimes = mt_rand(0, 2);
            $restockDays = [];
            while (count($restockDays) < $restockTimes) {
                $offset = mt_rand(0, 13); // 11/02..11/15 のどこか
                $restockDays[$offset] = true; // 重複防止
            }
            foreach (array_keys($restockDays) as $d) {
                $day = $base->copy()->subDays($d)->toDateString();
                StockTransaction::create([
                    'product_id'       => $product->id,
                    'type'             => 'IN',
                    'quantity'         => mt_rand(20, 120),
                    'transaction_date' => $day,
                    'remarks'          => '補充入庫',
                ]);
            }
        }
    }
}