# 07_crud_setup.md（モデル・コントローラ作成とCRUD処理準備）

## 1. 目的
本工程では、在庫管理システムの基本機能となる  
**商品情報（products）** および **入出庫履歴（stock_transactions）** の  
CRUD（登録・表示・更新・削除）処理を実装するための準備を行う。  
主に以下を目的とする。

- 各テーブルに対応するモデルの作成  
- コントローラおよびフォームリクエスト（バリデーション）の生成  
- 今後のルーティング・画面処理実装に向けた基礎構成の確立  

---

## 2. 作成内容の概要
| 分類 | 名称 | 役割 |
|------|------|------|
| **モデル** | `Product`, `StockTransaction` | データベースとのやり取りを担当。1対多のリレーションを構成。 |
| **コントローラ** | `ProductController`, `TransactionController` | 画面遷移・データ操作を制御。商品管理はリソース構成で生成。 |
| **フォームリクエスト** | `StoreProductRequest`, `UpdateProductRequest`, `StoreTransactionRequest` | 入力値の検証を行う。登録・更新処理の品質を担保。 |

---

## 3. コマンド一覧
以下の Artisan コマンドを実行し、必要なファイルを生成する。

```bash
php artisan make:controller ProductController --resource
php artisan make:controller TransactionController
php artisan make:request StoreProductRequest
php artisan make:request UpdateProductRequest
php artisan make:request StoreTransactionRequest
```

--resource オプションを付与することで、ProductControllerに標準的なCRUDメソッド（index, create, store, show, edit, update, destroy）が自動生成される。

フォームリクエストは、入力値のバリデーションルールを定義する専用クラスとして利用する。

## 4. モデルの設定
Laravelがデータベースと正しくやり取りできるようにする「モデルの設定」

-- Product モデルでは、hasMany(StockTransaction::class) により、商品と取引履歴の1対多関係を定義する。

-- StockTransaction モデルでは、belongsTo(Product::class) により、対応する商品を参照できるようにする。

-- fillable プロパティで登録可能なカラムを明示し、予期せぬデータ挿入を防ぐ。

## 5. バリエーション（フォームリクエスト）
| クラス | 対象処理 | 主な検証項目 |
|------|------|------|
|StoreProductRequest|商品登録|商品名、SKUの一意性、安全在庫、リードタイム|
|UpdateProductRequest|商品更新|商品名、SKU（自身以外の重複防止）|
|StoreTransactionRequest|入出庫登録|商品IDの存在確認、入出庫区分、数量、日付形式、備考の長さ|