<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AccessesFixture
 */
class AccessesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => 'アクセスID', 'autoIncrement' => true, 'precision' => null],
        'url' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アクセス先URL', 'precision' => null, 'fixed' => null],
        'access_time' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => 'アクセス時刻', 'precision' => null],
        'ip_address' => ['type' => 'string', 'length' => 128, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アクセス元IPアドレス', 'precision' => null, 'fixed' => null],
        'host_name' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アクセス元ホスト名', 'precision' => null, 'fixed' => null],
        'referer' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'リファラー', 'precision' => null, 'fixed' => null],
        'browser_info' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アクセスブラウザ情報', 'precision' => null, 'fixed' => null],
        'request_method' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'リクエスト情報', 'precision' => null, 'fixed' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '作成日', 'precision' => null],
        'modified' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '更新日', 'precision' => null],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
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
                'url' => 'Lorem ipsum dolor sit amet',
                'access_time' => '2020-06-15 10:08:33',
                'ip_address' => 'Lorem ipsum dolor sit amet',
                'host_name' => 'Lorem ipsum dolor sit amet',
                'referer' => 'Lorem ipsum dolor sit amet',
                'browser_info' => 'Lorem ipsum dolor sit amet',
                'request_method' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-06-15 10:08:33',
                'modified' => '2020-06-15 10:08:33',
            ],
        ];
        parent::init();
    }
}
