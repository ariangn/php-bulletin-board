# komoread

**komoread** は、森の中をイメージした、日本語対応の読書掲示板アプリです。  
各スレッドは1冊の本に対応しており、読書感想や一文の共有、深い考察などを気軽に書き込めます。  
画面デザインは、木漏れ日、紙の本、静かな時間をイメージした落ち着いた雰囲気です。


## 主な機能

- スレッド：1スレッド = 1冊の本
- 各スレッドにはタイトル・著者・紹介文・レス（感想など）を含む
- レス投稿（ログインユーザーのみ）
- スレッド/レスの編集・削除
- ユーザー登録 / ログイン / ログアウト
- 木漏れ日＋読書をテーマにしたデザイン（ランダムカラーの本の表紙アイコン）


## 前提条件

- macOS または Windows（**MAMP** 推奨）
- PHP 7.4 以上
- MySQL（MAMP に含まれています）
- TablePlus
- Webブラウザ（Chrome, Safariなど）


## ローカルでの実行手順

### 1. プロジェクトを設置する

1. 本リポジトリをクローンまたはZIPダウンロードします：

```bash
git clone https://github.com/ariangn/php-bulletin-board.git
```

2. フォルダを以下の場所に移動します：

```
/Applications/MAMP/htdocs/php-bulletin-board/
```

※ `htdocs` 配下に置かないと、MAMPのApacheサーバーで表示できません。

---

### 2. データベースを作成する

#### ① MAMPを起動

- MAMPアプリを開き、「Start Servers（サーバーを起動）」をクリックします
- ApacheとMySQLが両方緑になっていることを確認します

#### ② データベースを作成

1. TablePlus を開き、MySQL に接続（ポート: `8889`, ユーザー: `root`, パスワード: `root`）
2. `message_board` という名前のデータベースを作成
3. `schema.sql` を実行し、必要なテーブルを作成
4. 必要に応じて `seed.sql` を実行し、日本文学の本スレッドを自動挿入

```sql
CREATE DATABASE message_board CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
```

### 3. アプリを開く

ブラウザで以下にアクセス：

```
http://localhost:8888/php-bulletin-board/public/
```

`index.php` が表示されれば成功です！


