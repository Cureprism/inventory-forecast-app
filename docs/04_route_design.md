## 1. 前提
- すべてのアプリ画面は **認証必須（authミドルウェア）**
- 一般登録は不可。**管理者のみ**ユーザーを作成できる（実装は後日）

## 2. ルート一覧（在庫管理：CRUD＋入出庫）

| 画面/機能 | メソッド | パス | コントローラ@アクション | 備考 |
|---|---|---|---|---|
| ログイン | GET/POST | `/login` | Breeze標準 | 認証 |
| ログアウト | POST | `/logout` | Breeze標準 | 認証解除 |
| 在庫一覧（ダッシュボード） | GET | `/products` | ProductController@index | 現在庫/欠品見込み |
| 商品登録フォーム | GET | `/products/create` | ProductController@create |  |
| 商品登録 | POST | `/products` | ProductController@store |  |
| 商品詳細 | GET | `/products/{id}` | ProductController@show | 入出庫履歴＋軽量予測 |
| 商品編集フォーム | GET | `/products/{id}/edit` | ProductController@edit |  |
| 商品更新 | PUT/PATCH | `/products/{id}` | ProductController@update |  |
| 商品削除 | DELETE | `/products/{id}` | ProductController@destroy |  |
| 入出庫登録フォーム | GET | `/transactions/create` | TransactionController@create | 商品・区分(IN/OUT)・数量 |
| 入出庫登録 | POST | `/transactions` | TransactionController@store |  |

## 3. ミドルウェア適用
- `/login` を除く上記ルートに `auth` を適用する
- 管理機能（ユーザー作成など）が加わる場合は `role:admin` を別途付与

## 4. メモ
- 軽量予測（SMA＋曜日補正）は **保存せず**、`ProductController@show` 内で都度計算して表示
- API化の予定は現時点なし（必要になれば `/api/...` を別設計）