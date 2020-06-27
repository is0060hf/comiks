<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserNoticesFixture
 */
class UserNoticesFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '通知ID', 'autoIncrement' => true, 'precision' => null],
        'title' => ['type' => 'string', 'length' => 128, 'null' => false, 'default' => '無題', 'collate' => 'utf8_general_ci', 'comment' => 'タイトル', 'precision' => null, 'fixed' => null],
        'context' => ['type' => 'text', 'length' => 4294967295, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '通知内容', 'precision' => null],
        'important_flg' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '0', 'comment' => '既読フラグ', 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '送り主ID', 'precision' => null, 'autoIncrement' => null],
        'notice_level' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'send_date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '通知日時', 'precision' => null],
        'icon_image_path' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アイコン画像', 'precision' => null, 'fixed' => null],
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
                'title' => 'Lorem ipsum dolor sit amet',
                'context' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'important_flg' => 1,
                'user_id' => 1,
                'notice_level' => 1,
                'send_date' => '2020-06-15 10:08:33',
                'icon_image_path' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-06-15 10:08:33',
                'modified' => '2020-06-15 10:08:33',
            ],
        ];
        parent::init();
    }
}
