# 08_routing_setup.md — ルーティング設定とコントローラ連携

## 1. 目的
本工程では、Laravelアプリの画面遷移と処理呼び出しを定義する  
**ルーティング設定（routes/web.php）** を構築する。  
これにより、URLとコントローラのメソッドを結び付け、  
商品情報および入出庫履歴のCRUD操作を実行できるようにする。

---

## 2. 構成方針
- ログイン認証を通過したユーザーのみが在庫管理機能にアクセスできるようにする。  
- 商品管理は `ProductController` のリソースルートを用いて一括定義する。  
- 入出庫履歴（トランザクション）は、必要なルートを個別に指定する。  

---

## 3. 設定ファイル
対象：`routes/web.php`

## 4. 各ルートの概要
| URL | HTTPメソッド | コントローラ / メソッド | 主な機能 |
|------|---------------|---------------------------|------------|
| `/products` | GET | `ProductController@index` | 商品一覧表示 |
| `/products/create` | GET | `ProductController@create` | 商品登録フォーム表示 |
| `/products` | POST | `ProductController@store` | 商品登録処理 |
| `/products/{id}/edit` | GET | `ProductController@edit` | 商品編集フォーム表示 |
| `/products/{id}` | PUT | `ProductController@update` | 商品更新処理 |
| `/products/{id}` | DELETE | `ProductController@destroy` | 商品削除処理 |
| `/transactions` | GET | `TransactionController@index` | 入出庫履歴一覧表示 |
| `/transactions/create` | GET | `TransactionController@create` | 入出庫登録フォーム表示 |
| `/transactions` | POST | `TransactionController@store` | 入出庫登録処理 |

## 5. 補足
- Route::resource により、RESTfulなルートが自動生成される。
- すべてのルートは auth ミドルウェアによりログイン必須。
- /dashboard（Breeze認証後トップ）は既定ルートとしてそのまま利用。