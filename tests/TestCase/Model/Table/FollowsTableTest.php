<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FollowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FollowsTable Test Case
 */
class FollowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FollowsTable
     */
    public $FollowsTable;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.follows',
        'app.tweets',
        'app.users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Follows') ? [] : ['className' => 'App\Model\Table\FollowsTable'];
        $this->FollowsTable = TableRegistry::get('Follows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FollowsTable);

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
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $result = $this->FollowsTable->add(3, 1)->execute();
        $query = $this->FollowsTable->find()
            ->order(['id' => 'DESC'])
            ->first();
        $this->assertEquals(3, $query->from_user_id);
        $this->assertEquals(1, $query->to_user_id);
    }

    /**
     * Test remove method
     *
     * @return void
     */
    public function testRemove()
    {
        $this->FollowsTable->remove(2, 1)->execute();
        $count = $this->FollowsTable->find()
            ->all()
            ->count();
        $this->assertEquals(3, $count);

        $result = $this->FollowsTable->remove(3, 1)->execute();
        $this->assertFalse(empty($result));
    }
}
