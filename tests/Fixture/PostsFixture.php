<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PostsFixture
 */
class PostsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '投稿ID', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '投稿者ID', 'precision' => null, 'autoIncrement' => null],
        'category_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => '0', 'comment' => 'カテゴリID', 'precision' => null, 'autoIncrement' => null],
        'title' => ['type' => 'string', 'length' => 256, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'タイトル', 'precision' => null, 'fixed' => null],
        'title_sub1' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'サブタイトル１', 'precision' => null, 'fixed' => null],
        'title_sub2' => ['type' => 'string', 'length' => 256, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'サブタイトル２', 'precision' => null, 'fixed' => null],
        'context' => ['type' => 'text', 'length' => 4294967295, 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '投稿内容', 'precision' => null],
        'featured_image' => ['type' => 'string', 'length' => 512, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'アイキャッチ', 'precision' => null, 'fixed' => null],
        'open_date' => ['type' => 'date', 'length' => null, 'null' => false, 'default' => null, 'comment' => '公開日', 'precision' => null],
        'is_open' => ['type' => 'string', 'length' => 32, 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => '記事状態区分', 'precision' => null, 'fixed' => null],
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
                'user_id' => 1,
                'category_id' => 1,
                'title' => 'Lorem ipsum dolor sit amet',
                'title_sub1' => 'Lorem ipsum dolor sit amet',
                'title_sub2' => 'Lorem ipsum dolor sit amet',
                'context' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'featured_image' => 'Lorem ipsum dolor sit amet',
                'open_date' => '2020-06-15',
                'is_open' => 'Lorem ipsum dolor sit amet',
                'created' => '2020-06-15 10:08:33',
                'modified' => '2020-06-15 10:08:33',
            ],
        ];
        parent::init();
    }
}
