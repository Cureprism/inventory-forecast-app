# 09_product_controller.md（ProductController 基本CRUD実装）

## 1. 目的
この工程では、**商品情報（products）テーブル** に対する  
CRUD（Create / Read / Update / Delete）処理を実装する。  
ルーティングで定義された各URLに対応するコントローラメソッドを作成し、  
商品の登録・一覧表示・編集・削除といった基本操作を実現する。

---

## 2. 構成概要
`ProductController` は、商品データを操作するための中心的なコントローラであり、  
Laravelのリソースコントローラ構成に従って、次の7つのメソッドを持つ。

| メソッド | 主な処理内容 | 対応するHTTPメソッド | ビュー |
|-----------|---------------|------------------------|--------|
| `index()` | 商品一覧を取得して表示 | GET `/products` | `products.index` |
| `create()` | 新規登録フォームを表示 | GET `/products/create` | `products.create` |
| `store()` | 新しい商品を登録 | POST `/products` | -（リダイレクト） |
| `show()` | 商品詳細を表示 | GET `/products/{id}` | `products.show` |
| `edit()` | 編集フォームを表示 | GET `/products/{id}/edit` | `products.edit` |
| `update()` | 商品情報を更新 | PUT `/products/{id}` | -（リダイレクト） |
| `destroy()` | 商品を削除 | DELETE `/products/{id}` | -（リダイレクト） |

---

## 3. 実装のポイント

### 3.1 データの取得と一覧表示
`index()` メソッドでは、Eloquentの `Product::orderBy('id','desc')->paginate(10)` を用いて  
商品一覧を取得し、ビューに渡す。ページネーションを利用することで、  
表示負荷を軽減し、見やすい一覧画面を実現する。

---

### 3.2 新規登録
`store()` メソッドでは、`StoreProductRequest` に定義されたバリデーションを通過した  
データを `Product::create()` に渡し、新しい商品を登録する。  
登録後は一覧ページへリダイレクトし、完了メッセージを表示する。

---

### 3.3 編集と更新
`edit()` で指定IDの商品情報を取得し、フォームに初期値として表示。  
`update()` でフォームの入力を `UpdateProductRequest` により検証し、  
既存レコードを `$product->update()` で更新する。

---

### 3.4 削除
`destroy()` では、該当する商品レコードを削除し、  
削除完了後に一覧画面へリダイレクトする。

---

## 4. 完了条件
- 商品データの登録・更新・削除・一覧表示が正常に動作する。  
- バリデーションによる入力チェックが行われている。  
- 各ビュー（`index`, `create`, `edit`, `show`）と連携できる状態にある。
