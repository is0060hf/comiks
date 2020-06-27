<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CategoryNamesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CategoryNamesTable Test Case
 */
class CategoryNamesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CategoryNamesTable
     */
    public $CategoryNames;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.CategoryNames',
        'app.Users',
        'app.PageNames',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CategoryNames') ? [] : ['className' => CategoryNamesTable::class];
        $this->CategoryNames = TableRegistry::getTableLocator()->get('CategoryNames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CategoryNames);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
