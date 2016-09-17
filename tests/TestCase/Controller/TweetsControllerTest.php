<?php
namespace App\Test\TestCase\Controller;

use App\Controller\TweetsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\TweetsController Test Case
 */
class TweetsControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tweets',
        'app.users',
    ];

    /**
     * Ajax configuration
     *
     * @return void
     */
    public function ajaxSetUp()
    {
        $this->configRequest([
            'headers' => [
                'X-Requested-With' => 'XMLHttpRequest',
                'Accept' => 'application/json',
                'ContentType' => 'application/json',
            ],
        ]);
    }


    /**
     * Authorize
     *
     * @return void
     */
    public function authorize()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 1,
                    'username' => 'test1',
                    'fullname' => 'Test 1',
                    'mail' => 'mail1@example.com',
                    'is_public' => 1,
                    'created' => '2016-08-29 20:05:37',
                    'last_login' => '2016-09-01 20:05:37'
                ]
            ]
        ]);
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
     * Test beforeFilter method
     *
     * @return void
     */
    public function testBeforeFilter()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->get('/');
        $this->assertResponseSuccess();
        $this->assertTrue($this->viewVariable('tweetsExist'));
    }

    /**
     * Test ajaxPost for unauthorized user
     */
    public function testAjaxPostUnauthenticatedFail()
    {
        $this->get('/tweets/ajaxPost');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Test ajaxPost method
     *
     * @return void
     */
    public function testAjaxPostAuthenticated()
    {
        $this->ajaxSetUp();
        $this->authorize();
        $this->post('/tweets/ajaxPost', ['content' => 'Test tweet.']);

        $this->assertResponseOk();

        $tweets = TableRegistry::get('Tweets');
        $tweet = $tweets->find()
            ->order(['timestamp' => 'DESC'])
            ->first();
        $this->assertArraySubset(
            [
                'id' => 5,
                'user_id' => 1,
                'content' => 'Test tweet.'
            ],
            $tweet->toArray()
        );
    }

    /**
     * Test ajaxRemove for unauthorized user
     */
    public function testAjaxRemoveUnauthenticatedFail()
    {
        $this->get('/tweets/ajaxRemove');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'login']);
    }

    /**
     * Test ajaxRemove method
     *
     * @return void
     */
    public function testAjaxRemove()
    {
        $this->ajaxSetUp();
        $this->authorize();
        $this->post('/tweets/ajaxRemove/' . '2');

        $this->assertResponseOk();

        $tweets = TableRegistry::get('Tweets');
        $this->assertEquals('3' ,$tweets->getTweetsNum());

        $removed = $tweets->find()
            ->where(['id' => 2])
            ->toArray();
        $this->assertEmpty($removed);
    }

    /**
     * Test ajaxRecieveNewTweets method
     *
     * @return void
     */
    public function testAjaxRecieveNewTweets()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxRecieveNewTweets/'. '3');

        $this->assertResponseOk();
        $this->assertContentType('application/json; charset=UTF-8');

        $this->assertResponseContains('"id": 4,');
        $this->assertResponseNotContains('"user_id": 1,');
    }

    /**
     * Test ajaxRecieveNewTweets method
     *
     * @return void
     */
    public function testAjaxRecieveNewTweetsFail()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxRecieveNewTweets/'. '4');

        $this->assertResponseOk();
        $this->assertResponseEmpty();
    }

    /**
     * Test ajaxSyncAllTweets method
     *
     * @return void
     */
    public function testAjaxSyncAllTweetsEmpty()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxSyncAllTweets/1/4/4');
        $this->assertResponseOk();
        $this->assertResponseEmpty();
    }

    /**
     * Test ajaxSyncAllTweets method
     *
     * @return void
     */
    public function testAjaxSyncAllTweets()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxSyncAllTweets/1/4/3');
        $this->assertResponseOk();
        $this->assertContentType('application/json; charset=UTF-8');
        $this->assertResponseNotEmpty();
    }

    /**
     * Test ajaxLoadTweets method
     *
     * @return void
     */
    public function testAjaxLoadTweetsEmpty()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxLoadTweets/1');
        $this->assertResponseOk();
        $this->assertResponseEmpty();
    }

    /**
     * Test ajaxLoadTweets method
     *
     * @return void
     */
    public function testAjaxLoadTweetsLoadOne()
    {
        $this->ajaxSetUp();
        $this->post('/tweets/ajaxLoadTweets/2');
        $this->assertResponseOk();
        $this->assertResponseContains('"user_id": 1,');
        $this->assertResponseNotContains('"user_id": 3,');
    }
}
