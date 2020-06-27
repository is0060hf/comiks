<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'ユーザーID', 'autoIncrement' => true, 'precision' => null],
        'login_name' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ユーザー名', 'precision' => null, 'fixed' => null],
        'login_cd' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'ログイン用ID', 'precision' => null, 'fixed' => null],
        'password' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'パスワード', 'precision' => null, 'fixed' => null],
        'mail_address' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'メールアドレス', 'precision' => null, 'fixed' => null],
        'rank_kb' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '-1', 'comment' => 'ランク区分', 'precision' => null, 'autoIncrement' => null],
        'user_role' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => 'ユーザーロール', 'precision' => null, 'autoIncrement' => null],
        'job_name' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '仕事名', 'precision' => null, 'fixed' => null],
        'twitter_account' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Twitterアカウント', 'precision' => null, 'fixed' => null],
        'youtube_account' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Youtubeアカウント', 'precision' => null, 'fixed' => null],
        'instagram_account' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Instagramアカウント', 'precision' => null, 'fixed' => null],
        'facebook_account' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Facebookアカウント', 'precision' => null, 'fixed' => null],
        'intro_message' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '自己紹介文', 'precision' => null, 'fixed' => null],
        'skill_message' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'スキルメッセージ', 'precision' => null, 'fixed' => null],
        'icon_image_path' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アイコン画像', 'precision' => null, 'fixed' => null],
        'default_featured_image_path' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'デフォルトアイキャッチ画像', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '作成日', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '更新日', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'users_login_name_uindex' => ['type' => 'unique', 'columns' => ['login_name'], 'length' => []],
            'users_login_cd_uindex' => ['type' => 'unique', 'columns' => ['login_cd'], 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'id' => 1,
                'login_name' => 'Lorem ipsum dolor sit amet',
                'login_cd' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'mail_address' => 'Lorem ipsum dolor sit amet',
                'rank_kb' => 1,
                'user_role' => 1,
                'job_name' => 'Lorem ipsum dolor sit amet',
                'twitter_account' => 'Lorem ipsum dolor sit amet',
                'youtube_account' => 'Lorem ipsum dolor sit amet',
                'instagram_account' => 'Lorem ipsum dolor sit amet',
                'facebook_account' => 'Lorem ipsum dolor sit amet',
                'intro_message' => 'Lorem ipsum dolor sit amet',
                'skill_message' => 'Lorem ipsum dolor sit amet',
                'icon_image_path' => 'Lorem ipsum dolor sit amet',
                'default_featured_image_path' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-06-15 10:08:33',
                'modified' => '2020-06-15 10:08:33',
            ],
        ];
        parent::init();
    }
}
