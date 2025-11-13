<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockTransaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;

class TransactionController extends Controller
{
    // 履歴一覧（新しい順）
    public function index()
    {   //外部キー product_id に対応する products テーブルを結合して、取引と商品情報を一度に取得
        $transactions = StockTransaction::with('product')
            ->orderBy('transaction_date','desc')
            ->orderBy('id','desc')
            ->paginate(15);

        return view('transactions.index', compact('transactions'));
    }

    // 入出庫登録フォーム
    public function create()
    {
        // 登録フォームで選択できる商品プルダウン用データを取得
        $products = Product::orderBy('name')->get(['id','name','product_code']);
        return view('transactions.create', compact('products'));
    }

    // 入出庫データを登録
    public function store(StoreTransactionRequest $request)
    {
        StockTransaction::create($request->validated());
        return redirect()->route('transactions.index')->with('success', '入出庫を登録しました');
    }

    // 入出庫データを編集
    public function edit(\App\Models\StockTransaction $transaction)
    {
        $products = \App\Models\Product::orderBy('name')->get(['id','name','product_code']);
        return view('transactions.edit', [
            'transaction' => $transaction->load('product'),
            'products'    => $products,
        ]);
    }

    // 入出庫データを更新
    public function update(UpdateTransactionRequest $request, \App\Models\StockTransaction $transaction)
    {
        $transaction->update($request->validated());
        return redirect()->route('transactions.index')->with('success', '入出庫を更新しました');
    }

    // 入出庫データを削除
    public function destroy(\App\Models\StockTransaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', '入出庫を削除しました');
    }
}
