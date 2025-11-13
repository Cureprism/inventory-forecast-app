## 1. 開発環境
| 項目 | バージョン / 内容 |
|------|------------------|
| OS | Windows 11（開発） |
| PHP | 8.4.x |
| Laravel | 12.x |
| Composer | 2.8.x |
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

# 2. Laravelのセットアップ
composer create-project laravel/laravel="12.*" ./

# 3. 環境設定（タイムゾーン・言語・デバッグバーの設定）
'timezone' => 'Asia/Tokyo'
'locale' => env('APP_LOCALE', 'ja')
composer require barryvdh/laravel-debugbar

# 4. DBの接続設定
XAMPP -> MYSQL -> Admin　データベース新規作成
.env　環境設定
php artisan config:clear　変更反映

# 5. 認証機能（Breeze）導入
composer require laravel/breeze --dev # Laravel Breeze（認証機能）を開発環境にインストール
php artisan breeze:install # BreezeをBladeテンプレート（Tailwind CSSベース）でセットアップ
npm install # フロントエンド依存関係（Vite, Tailwind CSSなど）をインストール
npm run build # 開発用のJS/CSSをViteでビルドし、ブラウザが参照できるpublic/build配下に出力
php artisan migrate # 認証用のテーブル（users, password_reset など）をDBに作成