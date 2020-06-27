<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserSkillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserSkillsTable Test Case
 */
class UserSkillsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserSkillsTable
     */
    public $UserSkills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserSkills',
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
        $config = TableRegistry::getTableLocator()->exists('UserSkills') ? [] : ['className' => UserSkillsTable::class];
        $this->UserSkills = TableRegistry::getTableLocator()->get('UserSkills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserSkills);

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
