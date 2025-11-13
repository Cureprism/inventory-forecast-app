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
        Schema::create('products', function (Blueprint $table) {
            $table->id();                                         // 主キー（bigint）
            $table->string('name', 100);                          // 商品名
            $table->string('product_code', 50)->unique();         // 管理コード（ユニーク）
            $table->integer('price')->default(0);                 // 価格
            $table->integer('safety_stock');                      // 安全在庫
            $table->smallInteger('lead_time_days');               // 発注リードタイム（日）
            $table->timestamps();                                 // created_at / updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
