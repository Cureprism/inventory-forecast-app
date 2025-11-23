# データベース設計書

## 1. テーブル構成
- products：商品マスタ（商品一覧画面の表示内容）
- stock_transactions：入出庫履歴（入出庫一覧画面の表示内容）  
※ 在庫は IN/OUT の差分で算出するため current_stock は保持しない。

関係：products (1) ── (n) stock_transactions  
外部キー：stock_transactions.product_id → products.id
※1つの商品に対して、複数の入出庫履歴が紐づく構成。  
　そのため、products.id を親として、stock_transactions.product_id に外部キーを設定。

## 2. テーブル概要

### 2.1 products
| カラム | 型 | 内容 |
|---|---|---|
| id | bigint | 主キー |
| name | varchar | 商品名 |
| product_code | varchar | 商品管理番号 |
| price | int | 価格 |
| safety_stock | int | 安全在庫 |
| lead_time_days | smallint | リードタイム |
| created_at / updated_at | timestamp | 登録・更新日時 |

※ product_code はユニーク制約。  
※ 現在庫は IN/OUT の履歴から算出するため保持しない。

### 2.2 stock_transactions
| カラム | 型 | 内容 |
|---|---|---|
| id | bigint | 主キー |
| product_id | bigint | 外部キー（products.id）|
| type | enum('IN','OUT') | 入庫/出庫 |
| quantity | int | 数量 |
| transaction_date | date | 取引日 |
| remarks | varchar | 備考 |
| created_at / updated_at | timestamp | 登録・更新日時 |

## 3. 派生情報（クエリで算出）
- **現在庫**：該当商品の入庫（IN）合計から出庫（OUT）合計を差し引いて算出
- **予測入力系列**：出庫（OUT）件を日別集計した時系列

