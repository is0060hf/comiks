<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserNoticeFlagsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserNoticeFlagsTable Test Case
 */
class UserNoticeFlagsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserNoticeFlagsTable
     */
    public $UserNoticeFlags;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UserNoticeFlags',
        'app.Users',
        'app.UserNotices',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UserNoticeFlags') ? [] : ['className' => UserNoticeFlagsTable::class];
        $this->UserNoticeFlags = TableRegistry::getTableLocator()->get('UserNoticeFlags', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UserNoticeFlags);

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
