<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PricePlansTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PricePlansTable Test Case
 */
class PricePlansTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PricePlansTable
     */
    public $PricePlans;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.PricePlans',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PricePlans') ? [] : ['className' => PricePlansTable::class];
        $this->PricePlans = TableRegistry::getTableLocator()->get('PricePlans', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PricePlans);

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
