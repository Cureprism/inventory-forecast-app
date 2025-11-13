<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockTransaction;
use App\Services\ForecastService;

class ForecastController extends Controller
{
    public function show(Product $product, ForecastService $svc)
    {
        // ① 現在庫をここで計算（一覧と同じロジック）
        $in  = (int) StockTransaction::where('product_id', $product->id)
                ->where('type', 'IN')->sum('quantity');
        $out = (int) StockTransaction::where('product_id', $product->id)
                ->where('type', 'OUT')->sum('quantity');
        $product->current_stock = $in - $out;

        // ② 予測（SMA=14）
        $f   = $svc->forecastDailyDemand($product, 14);        // ['avg_daily'=>...]
        $sim = $svc->simulateStockout($product, $f['avg_daily']);

        return view('forecasts.show', [
            'product'  => $product,
            'avgDaily' => $f['avg_daily'],
            'stockout' => $sim['stockout_date'],
            'reorder'  => $sim['reorder_date'],
            'daysLeft' => $sim['days_to_stockout'],
        ]);
    }
}
