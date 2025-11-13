# 11_transactions_crud.md（入出庫 CRUD：完成版）

## 1. 目的と範囲
`stock_transactions` の **一覧・登録・編集・削除（CRUD 完全版）** を実装し、商品在庫集計（IN−OUT）の基盤データを一貫して扱えるようにする。  
※ 商品コードは **product_code**、在庫数は **非保持**（`IN−OUT` 集計で算出）。

---

## 2. 対象テーブルと項目
- **stock_transactions**
  - `id`（PK）
  - `product_id`（FK → products.id）
  - `type`（`IN`｜`OUT`）
  - `quantity`（int, `min:1`）
  - `transaction_date`（date）
  - `remarks`（nullable, varchar(255)）
  - `created_at` / `updated_at`

**関連（Eloquent）**
- `Product hasMany StockTransaction` → **メソッド名：`transactions()`**  
- `StockTransaction belongsTo Product` → `product()`

> 命名を統一：ドキュメント・コードとも **`transactions`** をリレーション名として使用。

---

## 3. ルーティング
すべて **`auth`** 配下。

| メソッド | パス | ルート名 | 用途 |
|---|---|---|---|
| GET | `/transactions` | `transactions.index` | 履歴一覧（15件/頁, 日付降順→ID降順） |
| GET | `/transactions/create` | `transactions.create` | 新規登録フォーム |
| POST | `/transactions` | `transactions.store` | 新規登録 |
| GET | `/transactions/{transaction}/edit` | `transactions.edit` | 編集フォーム |
| PUT | `/transactions/{transaction}` | `transactions.update` | 更新 |
| DELETE | `/transactions/{transaction}` | `transactions.destroy` | 削除 |

---

## 4. バリデーション（FormRequest）
- `StoreTransactionRequest` / `UpdateTransactionRequest`
  - `authorize(): true`（未設定だと **403**）
  - `rules()`  
    - `product_id`：`required|exists:products,id`  
    - `type`：`required|in:IN,OUT`  
    - `quantity`：`required|integer|min:1`  
    - `transaction_date`：`required|date`  
    - `remarks`：`nullable|string|max:255`

---

## 5. コントローラの責務（概要）
**TransactionController**
- `index()`  
  - `StockTransaction::with('product')`  
  - `orderBy('transaction_date','desc')->orderBy('id','desc')`  
  - `paginate(15)` → ビューへ `$transactions`
- `create()`  
  - `Product::orderBy('name')->get(['id','name','product_code'])` → `$products`  
  - 省力化：`?product_id=xx` があれば初期選択用に渡す（任意）
- `store()`  
  - `$request->validated()` を `StockTransaction::create()`  
  - `redirect()->route('transactions.index')->with('success', ...)`
- `edit(StockTransaction $transaction)`  
  - `$transaction->load('product')`  
  - `$products` を取得してプルダウンに供給
- `update(UpdateTransactionRequest $request, StockTransaction $transaction)`  
  - `$transaction->update($request->validated())` → リダイレクト＋フラッシュ
- `destroy(StockTransaction $transaction)`  
  - `$transaction->delete()` → リダイレクト＋フラッシュ

---

## 6. 画面仕様（最小）
### 6.1 履歴一覧 `transactions.index`
- 表示列：**日付 / 商品名 / 商品管理番号(product_code) / 区分 / 数量 / 備考 / 操作（編集・削除）**  
- ページネーション：`{{ $transactions->links() }}`  
- 成功メッセージ表示：`session('success')`  
- 操作列：
  - 編集：`route('transactions.edit', $t)`  
  - 削除：`method="POST" @csrf @method('DELETE')`（confirm ダイアログ）

### 6.2 登録フォーム `transactions.create`
- 項目：
  - 商品（`<select name="product_id">`）  
    - 選択肢：`$products`（`id`, `name`, `product_code`）  
    - 再表示：`@selected(old('product_id') == $p->id)`
  - 区分（`IN`/`OUT`）
  - 数量（既定 `1`）
  - 日付（既定：**今日**）  
    - `value="{{ old('transaction_date', now()->toDateString()) }}"`
  - 備考（任意）
- エラー表示：`$errors->any()` → `<ul>`  
- 送信：`POST /transactions`（CSRF必須）

### 6.3 編集フォーム `transactions.edit`
- `create` と同一項目を **既存値で初期化**  
- 送信：`PUT /transactions/{id}`（`@method('PUT')`）

---

## 7. 商品一覧の在庫表示（関連機能）
**ProductController@index** で在庫集計を同時取得（`IN−OUT`）。  
- リレーション名は **`transactions`** を使用。
- 取得例（概念）：
  - `withSum(['transactions as stock_in' => where type=IN], 'quantity')`
  - `withSum(['transactions as stock_out' => where type=OUT], 'quantity')`
  - `current_stock = (stock_in ?? 0) - (stock_out ?? 0)`
- 一覧に **「現在庫」** 列を追加（右寄せ推奨）

> 注：`current_stock` は **DB列に持たない**（集計で算出）。

---

## 8. 確認手順（E2E）
1. **ルート**：`php artisan route:list | findstr /I transactions`  
   - `index/create/store/edit/update/destroy` が並ぶ
2. **登録**：`/transactions/create` → 入力 → 一覧に反映  
3. **編集**：`/transactions/{id}/edit` → 値変更 → 一覧に反映  
4. **削除**：一覧の削除ボタン → 確認 → 一覧から消える  
5. **バリデーション**：未選択・不正値でエラー表示 & 入力保持  
6. **認証**：未ログインでアクセスすると `/login` に誘導される  
7. **在庫反映**：`/products` の「現在庫」が IN/OUT 登録に応じて変化

---

## 9. よくある落とし穴（対策）
- **`authorize()` 未実装 → 403**  
  - FormRequestは **必ず `return true;`**
- **リレーション名不一致**  
  - ドキュメント・コードとも **`transactions()`** に統一  
  - コントローラの `withSum([...])` と一致させる
- **`links()` で例外**  
  - コレクションに `links()` は不可 → `paginate()` を使用  
- **`product_code` 未反映**  
  - マイグレーション変更後は `migrate` / `migrate:fresh` を正しく実施  
  - モデル `$fillable` / ビュー / バリデーションを **product_code** に統一

---

## 10. 完了条件
- 入出庫の **登録・編集・削除** が UI から一貫して成功する  
- 一覧にページネーション・フラッシュメッセージが動作  
- 商品一覧で **現在庫** が正しく表示・更新される  
- ルート／モデル命名がドキュメントと一致（`transactions`）

