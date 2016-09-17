<?php
namespace App\Test\TestCase\View\Cell;

use App\View\Cell\SidebarCell;
use Cake\TestSuite\TestCase;

/**
 * App\View\Cell\SidebarCell Test Case
 */
class SidebarCellTest extends TestCase
{

    /**
     * Request mock
     *
     * @var \Cake\Network\Request|\PHPUnit_Framework_MockObject_MockObject
     */
    public $request;

    /**
     * Response mock
     *
     * @var \Cake\Network\Response|\PHPUnit_Framework_MockObject_MockObject
     */
    public $response;

    /**
     * Test subject
     *
     * @var \App\View\Cell\SidebarCell
     */
    public $SidebarCell;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tweets',
        'app.users',
        'app.follows',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMockBuilder('Cake\Network\Request')->getMock();
        $this->response = $this->getMockBuilder('Cake\Network\Response')->getMock();
        $this->SidebarCell = new SidebarCell($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SidebarCell);

        parent::tearDown();
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplaySuccess()
    {
    }

    /**
     * Test display method
     *
     * @return void
     */
    public function testDisplayNotExistingUser()
    {
        $username = 'AAAA';
        $result = $this->SidebarCell->display($username);
        $this->assertNull($result);
    }
}
