# 06_db_setup.md（データベース構築手順）

## 1. 目的
アプリで使用する商品情報・入出庫履歴のテーブルを作成し、  
Eloquentモデルを通して操作できるようにする。

---

## 2. マイグレーションファイルとモデル作成
以下のコマンドでマイグレーションファイルとモデルを生成する。

```bash
# 商品マスタ（productsテーブル）
php artisan make:model Product -m

# 入出庫履歴（stock_transactionsテーブル）
php artisan make:model StockTransaction -m
```

## 3. マイグレーションファイルの編集
「02_data_design.md」の定義に沿って、マイグレーションファイルを編集する。

## 4. マイグレーション実行
テーブルを実際に作成する。
```bash
php artisan migrate
```