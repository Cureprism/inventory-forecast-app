# 02_data_design.md（最小）

## 1. テーブル構成
- **products**：商品マスタ
- **stock_transactions**：入出庫履歴  
※ 在庫予測は「都度計算（保存しない）」ため専用テーブルは持たない。

関係：`products (1) ── (n) stock_transactions`

---

## 2. テーブル概要

### 2.1 products
| カラム | 型 | 内容 |
|---|---|---|
| id | bigint | 主キー |
| name | varchar(100) | 商品名 |
| sku | varchar(50) | 管理コード（ユニーク） |
| safety_stock | int | 安全在庫 |
| lead_time_days | smallint | 発注リードタイム（日） |
| created_at / updated_at | timestamp | 監査用 |

**補足**：`sku` はユニーク制約。

---

### 2.2 stock_transactions
| カラム | 型 | 内容 |
|---|---|---|
| id | bigint | 主キー |
| product_id | bigint | 外部キー → products.id |
| type | enum('IN','OUT') | 入庫/出庫 |
| quantity | int | 数量（正の整数） |
| transaction_date | date | 取引日 |
| remarks | varchar(255) | 備考（任意） |
| created_at / updated_at | timestamp | 監査用 |

**推奨インデックス**：`(product_id, transaction_date)`

---

## 3. 派生情報（クエリで算出）
- **現在庫**：入庫合計 − 出庫合計（商品単位）
- **予測入力系列**：出庫（OUT）件を日別集計した時系列

