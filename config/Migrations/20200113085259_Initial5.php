<?php
use Migrations\AbstractMigration;

class Initial5 extends AbstractMigration
{
    public function up()
    {

        $this->table('accesses')
            ->addColumn('url', 'string', [
                'comment' => 'アクセス先URL',
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->addColumn('access_time', 'datetime', [
                'comment' => 'アクセス時刻',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('ip_address', 'string', [
                'comment' => 'アクセス元IPアドレス',
                'default' => null,
                'limit' => 128,
                'null' => true,
            ])
            ->addColumn('host_name', 'string', [
                'comment' => 'アクセス元ホスト名',
                'default' => null,
                'limit' => 256,
                'null' => true,
            ])
            ->addColumn('referer', 'string', [
                'comment' => 'リファラー',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('browser_info', 'string', [
                'comment' => 'アクセスブラウザ情報',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('request_method', 'string', [
                'comment' => 'リクエスト情報',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('post_images')
            ->addColumn('image_path', 'string', [
                'comment' => '画像パス',
                'default' => null,
                'limit' => 512,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('posts')
            ->addColumn('user_id', 'integer', [
                'comment' => '投稿者ID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('title', 'string', [
                'comment' => 'タイトル',
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->addColumn('context', 'text', [
                'comment' => '投稿内容',
                'default' => null,
                'limit' => 4294967295,
                'null' => false,
            ])
            ->addColumn('category_name', 'string', [
                'comment' => 'カテゴリ名',
                'default' => null,
                'limit' => 128,
                'null' => true,
            ])
            ->addColumn('featured_image', 'string', [
                'comment' => 'アイキャッチ',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('open_date', 'datetime', [
                'comment' => '公開日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('status_kb', 'integer', [
                'comment' => '記事状態区分',
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('user_notice_flags')
            ->addColumn('user_id', 'integer', [
                'comment' => 'ユーザーID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_notice_id', 'integer', [
                'comment' => '通知ID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('open_flg', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('user_notices')
            ->addColumn('title', 'string', [
                'comment' => 'タイトル',
                'default' => '無題',
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('context', 'text', [
                'comment' => '通知内容',
                'default' => null,
                'limit' => 4294967295,
                'null' => true,
            ])
            ->addColumn('important_flg', 'boolean', [
                'comment' => '既読フラグ',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'comment' => '送り主ID',
                'default' => null,
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('notice_level', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('send_date', 'datetime', [
                'comment' => '通知日時',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('icon_image_path', 'string', [
                'comment' => 'アイコン画像',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('login_name', 'string', [
                'comment' => 'ログイン名',
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'comment' => 'パスワード',
                'default' => null,
                'limit' => 256,
                'null' => false,
            ])
            ->addColumn('mail_address', 'string', [
                'comment' => 'メールアドレス',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('rank_kb', 'integer', [
                'comment' => 'ランク区分',
                'default' => '-1',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('user_role', 'integer', [
                'comment' => 'ユーザーロール',
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('icon_image_path', 'string', [
                'comment' => 'アイコン画像',
                'default' => null,
                'limit' => 512,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'comment' => '作成日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified', 'datetime', [
                'comment' => '更新日',
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'login_name',
                ],
                ['unique' => true]
            )
            ->create();
    }

    public function down()
    {
        $this->table('accesses')->drop()->save();
        $this->table('post_images')->drop()->save();
        $this->table('posts')->drop()->save();
        $this->table('user_notice_flags')->drop()->save();
        $this->table('user_notices')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
