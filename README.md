# 在庫予測機能付き商品在庫管理アプリ

在庫管理と、入出庫履歴からの在庫予測を行う小規模向けWebアプリです。
現在庫は入庫/出庫履歴から自動算出し、安全在庫を下回る場合は強調表示します。

## デモ
URL: https://inventory-forecast-app-bfb4db13bcbc.herokuapp.com/login  
ログイン: demo [at] example.com / demo1234

## 主な設計ポイント
- 商品と入出庫履歴を1対多で管理
- 現在庫は履歴からリアルタイム算出
- 出庫傾向を基にしたシンプルな在庫予測

## 設計ドキュメント
- [要件定義書](docs/01_requirements.md)
- [DB設計書](docs/02_data_design.md)
- [在庫予測ロジック](docs/03_data_design.md)
- [在庫予測ロジック検証](docs/04_foracast_logic_verification.md)
