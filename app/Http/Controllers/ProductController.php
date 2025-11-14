<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction; 
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ForecastService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ForecastService $svc)
    {
        $products = Product::withSum([
        'transactions as stock_in'  => fn($q) => $q->where('type', 'IN'),
        'transactions as stock_out' => fn($q) => $q->where('type', 'OUT'),
        ], 'quantity')
        ->orderBy('id','desc')
        ->paginate(10);

        // 現在庫を算出してビューへ
        foreach ($products as $p) {
        $p->current_stock = ($p->stock_in ?? 0) - ($p->stock_out ?? 0);
        }

        // ForecastServiceで発注推奨日を算出（新規追加）
        foreach ($products as $p) {
        $f   = $svc->forecastDailyDemand($p, 14);
        $sim = $svc->simulateStockout($p, $f['avg_daily']);
        $p->reorder_date = $sim['reorder_date'];
        }

        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());
        return redirect()->route('products.index')->with('success', '商品を登録しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return redirect()->route('products.index')->with('success', '商品を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->transactions()->exists()) {
        return redirect()->route('products.index')->withErrors('入出庫履歴があるため削除できません。先に履歴を削除するか、アーカイブしてください。');
    }
        $product->delete();
        return redirect()->route('products.index')->with('success', '商品を削除しました');
    }
}
