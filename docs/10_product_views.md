# 10_product_views.md（商品ビュー構築）

## 1. 目的
本工程では、`ProductController` に対応する4つの基本ビューを作成し、  
商品情報のCRUD操作を画面上で実行できるようにする。  
UIデザインや共通レイアウトは後続工程で拡張可能とする。

---

## 2. 作成対象ビュー
| 画面名 | 役割 | ファイル |
|---------|------|-----------|
| 商品一覧 | 登録済み商品の一覧・編集/削除リンクを表示 | `resources/views/products/index.blade.php` |
| 商品登録 | 新規商品の入力フォームを提供 | `resources/views/products/create.blade.php` |
| 商品編集 | 既存商品の修正フォームを提供 | `resources/views/products/edit.blade.php` |
| 商品詳細（任意） | 商品情報の確認用 | `resources/views/products/show.blade.php` |

---

## 3. ビュー設計方針
- LaravelのBladeテンプレート構文（`{{ }}` / `@csrf` / `@foreach` など）を使用  
- 成功・エラー時のメッセージを簡易的に表示する  

---

## 4. 実装概要

### (1) 商品一覧（index）
- データベースから取得した `$products` を表形式で一覧表示  
- 「編集」「削除」ボタン、および「新規登録」リンクを設置  
- ページネーションを有効化（`$products->links()`）

### (2) 商品登録（create）
- 新規商品を追加するフォームを設置  
- バリデーションエラーがある場合、エラーメッセージを表示  
- 登録完了後は一覧画面にリダイレクト  

### (3) 商品編集（edit）
- 選択された商品の情報を初期値としてフォームに表示  
- 入力内容を `UpdateProductRequest` で検証し、更新処理へ渡す  

### (4) 商品詳細（show）
- 任意画面。選択した商品の情報をリスト形式で表示  
- 「編集」「一覧へ戻る」などのナビゲーションを設置  

---

## 5. 確認ポイント（動作確認手順を含む）
### 5.1 機能面チェック
1. `/products` で商品一覧が表示されること  
2. 「＋新規登録」から `/products/create` へ遷移できること  
3. 登録フォームで入力 → 保存後に一覧へリダイレクトされること  
4. 一覧から「編集」リンクで `/products/{id}/edit` に遷移し、更新が反映されること  
5. 「削除」ボタン押下で確認ダイアログが表示され、削除後一覧に戻ること  
6. ページ下部にページネーションが表示されること（登録件数が多い場合）  
7. 入力ミス時にエラーメッセージが表示され、再入力できること  

---

### 5.2 環境面チェック
| 確認項目 | コマンド例 / 補足 |
|------------|--------------------|
| ルート登録済みか | `php artisan route:list` → productsルートが表示される |
| マイグレーション済みか | `php artisan migrate` 実行でテーブル作成済みを確認 |
| 開発サーバ起動 | `php artisan serve` → `http://127.0.0.1:8000` にアクセス |
| ログイン確認 | Breeze認証の `/login` ページからログイン可能であること |

---

### 5.3 よくあるエラーと対処
| 症状 | 原因 / 対応策 |
|------|----------------|
| 404エラー（画面が見つからない） | `routes/web.php` に `Route::resource('products', ProductController::class)` が存在するか確認 |
| 419エラー（CSRF token mismatch） | フォームに `@csrf` が含まれているか確認 |
| MethodNotAllowedHttpException | 更新フォームに `@method('PUT')`、削除フォームに `@method('DELETE')` が設定されているか確認 |
| SQLSTATE[23000]（一意制約違反） | `sku` が既存レコードと重複していないか確認 |
| Target class does not exist | コントローラの `namespace` や `use` 宣言を確認（`App\Http\Controllers\ProductController`） |

---

### 5.4 動作確認サンプルデータ（任意）
開発中にダミーデータを投入する場合：

```bash
php artisan tinker
>>> \App\Models\Product::create([
... 'name' => 'Demo商品',
... 'sku' => 'D0001',
... 'safety_stock' => 5,
... 'lead_time_days' => 7
... ]);


---

## 6. 完了条件
- CRUD操作が画面上で完結する  
- すべてのルートに対応するビューが存在し、コントローラと連携して動作する  
- デザインや共通レイアウトは後続工程で拡張可能な状態である