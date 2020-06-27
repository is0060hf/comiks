<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UploadedFilesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UploadedFilesTable Test Case
 */
class UploadedFilesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UploadedFilesTable
     */
    public $UploadedFiles;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.UploadedFiles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('UploadedFiles') ? [] : ['className' => UploadedFilesTable::class];
        $this->UploadedFiles = TableRegistry::getTableLocator()->get('UploadedFiles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UploadedFiles);

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
}
