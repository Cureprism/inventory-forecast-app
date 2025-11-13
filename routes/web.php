<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;

Route::get('/', function () {                               # トップページにアクセスしたときに/loginにリダイレクト
    return redirect()->route('login');
});

Route::get('/dashboard', function () {                      # /dashboard にアクセスしたときに実行する処理を指定
    return redirect()->route('products.index');             # products.index というルート名のページにリダイレクト
})
->middleware(['auth', 'verified'])                          # ログイン（auth）とメール認証（verified）が済んだユーザーだけがアクセスできる
->name('dashboard');                                        # このルートに 'dashboard' という名前をつける

Route::middleware('auth')->group(function () {              # middleware(['auth']) でログインユーザー専用に制限
    // 商品管理
    Route::resource('products', ProductController::class);  # Route::resource はCRUDルートを一括定義するLaravelの省略構文

    // 入出庫履歴管理
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('transactions/{transaction}', [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // 需要予測：商品ごとに表示
    Route::get('products/{product}/forecast', [\App\Http\Controllers\ForecastController::class, 'show'])
    ->name('products.forecast');

    // ダミーの profile.edit（リンクしてもダッシュボードへ戻す）
    Route::get('/profile', function () {
        return redirect()->route('dashboard');
    })->name('profile.edit');
});
require __DIR__.'/auth.php';
