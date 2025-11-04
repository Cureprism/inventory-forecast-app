## 1. 開発環境
| 項目 | バージョン / 内容 |
|------|------------------|
| OS | Windows 10 / 11（開発） |
| PHP | 8.3.x |
| Laravel | 12.x |
| Composer | 最新版 |
| MySQL | 8.x |
| Node.js | 20.x（vite利用） |
| パッケージ管理 | npm / artisan |
| エディタ | VS Code |

---

## 2. 初期セットアップ手順（メモ）
```bash
# 1. リポジトリをクローン
git clone https://github.com/Cureprism/inventory-forecast-app.git
cd inventory-forecast-app

# 2. 依存関係のインストール
composer install
npm install && npm run dev

# 3. 環境設定
cp .env.example .env
php artisan key:generate

# 4. マイグレーション・シード
php artisan migrate --seed

# 5. 認証機能（Breeze）導入（初回のみ）
composer require laravel/breeze --dev
php artisan breeze:install
npm install && npm run build
php artisan migrate