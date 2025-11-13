# ① 設定キャッシュをクリア
php artisan config:clear

# ② ルートキャッシュをクリア
php artisan route:clear

# ③ ビューキャッシュをクリア（Bladeテンプレート用）
php artisan view:clear

# ④ コンパイル済みファイルをクリア（オートロード関係）
php artisan clear-compiled

# ⑤ キャッシュを総合的にクリア
php artisan cache:clear

# ⑥ サーバーを再起動
php artisan serve
