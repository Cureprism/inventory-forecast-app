<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stock_transactions', function (Blueprint $table) {
            $table->id();                                         // 主キー（bigint）
            $table->foreignId('product_id')                       // products テーブルの id カラムを参照する外部キー
                  ->constrained('products');                      // 1対多リレーションを明示
            $table->enum('type', ['IN', 'OUT']);                  // 入庫 / 出庫
            $table->integer('quantity');                          // 数量（正の整数）
            $table->date('transaction_date');                     // 取引日
            $table->string('remarks', 255)->nullable();           // 備考（任意）
            $table->timestamps();                                 // created_at / updated_at

            // 検索性能向上のため、特定商品の取引履歴を日付順で検索できるようにする
            $table->index(['product_id', 'transaction_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transactions');
    }
};
