# Rese(飲食店予約サービス)

ゲストは飲食店の検索や詳細表示、ログインすると予約、お気に入り登録、評価投稿等ができるシステム。
管理者権限では店舗代表者の作成やお知らせメールの送信、店舗代表者権限では店舗情報の作成や予約情報の確認ができる。
また、予約情報のリマインダー送信や決済も可能。

<img width="730" alt="トップ画面" src="img/top-page.png">

## 作成した目的

外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい為。

## アプリケーション URL

- http://mnakagawa.com/

## 機能一覧

- 会員登録
- メール認証
- ログイン
- ログアウト
- ユーザー情報取得
- ユーザー飲食店お気に入り一覧取得
- ユーザー飲食店予約情報取得
- 飲食店一覧取得
- 飲食店エリア・ジャンル・店名検索
- 飲食店詳細取得
- 飲食店お気に入り追加
- 飲食店お気に入り削除
- 飲食店予約情報追加
- 飲食店予約情報変更
- 飲食店予約情報削除
- 飲食店評価機能
- 店舗代表者作成・利用者へのお知らせメール送信(管理者権限)
- 店舗情報作成・更新と予約情報確認(管理者権限)
- 店舗画像をストレージに保存
- 利用者へ予約情報のリマインダー送信
- 来店時に予約情報を照合できるQRコードを発行
- 決済機能

## 使用技術(実行環境)

- php 7.4.9
- Laravel 8.83.8
- MySQL 8.0.26
- javascript

## テーブル設計

<img width="730" alt="テーブル" src="img/table1.png"><br>
<img width="730" alt="テーブル" src="img/table2.png"><br>
<img width="730" alt="テーブル" src="img/table3.png">

## ER 図

<img width="730" alt="テーブル" src="img/erd.png">

# 環境構築

**Docker ビルド**

1. `git clone git@github.com:myaa6a/rese.git`
2. DockerDesktop アプリを立ち上げる
3. `docker-compose up -d --build`

> _Mac の M1・M2 チップの PC の場合、`no matching manifest for linux/arm64/v8 in the manifest list entries`のメッセージが表示されビルドができないことがあります。
> エラーが発生する場合は、docker-compose.yml ファイルの「mysql」内に「platform」の項目を追加で記載してください_

```bash
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

**Laravel 環境構築**

1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルを 「.env」ファイルに命名を変更。または、新しく.env ファイルを作成
4. .env に以下の環境変数を追加

```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. アプリケーションキーの作成

```bash
php artisan key:generate
```

6. マイグレーションの実行

```bash
php artisan migrate
```

7. シーディングの実行

```bash
php artisan db:seed
```

## 追加機能

- レビュー投稿時に画像を投稿でき、レビュー一覧で画像を表示できる


