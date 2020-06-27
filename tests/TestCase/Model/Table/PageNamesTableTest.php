<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PageNamesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PageNamesTable Test Case
 */
class PageNamesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PageNamesTable
     */
    public $PageNames;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PageNames',
        'app.Users',
        'app.CategoryNames',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PageNames') ? [] : ['className' => PageNamesTable::class];
        $this->PageNames = TableRegistry::getTableLocator()->get('PageNames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PageNames);

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
