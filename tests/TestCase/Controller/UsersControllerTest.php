<?php
namespace App\Test\TestCase\Controller;

use App\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;

/**
 * App\Controller\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.users',
        'app.tweets',
        'app.follows',
    ];

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
     * Test unauthorized user
     */

    /**
     * Test index method (unauthenticated)
     *
     * @return void
     */
    public function testIndexUnauthenticated()
    {
        $this->get('/users');
        $this->assertRedirect(['controller' => 'Tweets', 'action' => 'index']);
    }

    /**
     * Test index method (authenticated)
     *
     * @return void
     */
    public function testIndexAuthenticated()
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
        $this->get('/users');
        $this->assertRedirect(['controller' => 'Users', 'action' => 'view', 'test1']);
    }

    /**
     * Test view method (existing user)
     *
     * @return void
     */
    public function testViewExistingUser()
    {
        $this->get('/users/test1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<div id="profile-fullname">Test 1</div>');
    }

    /**
     * Test view method (not existing user)
     *
     * @return void
     */
    public function testViewNotExistingUser()
    {
        $this->get('/users/test4');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<h3>存在しないユーザ名です。</h3>');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->get('/register');
        $this->assertResponseSuccess();
        $this->assertResponseContains('入力フォーム');
    }

    /**
     * Test addsuccess method
     *
     * @return void
     */
    public function testAddsuccess()
    {
        $this->get('/addsuccess/フルネーム');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<p>フルネームはBluebirdに参加されました。</p>');
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLoginGet()
    {
        $this->get('/login');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<legend>ユーザ名とパスワードを入力してください。</legend>');
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLoginPostSuccess()
    {
        $this->post('/register', [
            'fullname' => 'Test 4',
            'username' => 'test4',
            'password' => 'pass4',
            'password2' => 'pass4',
            'mail' => 'mail@example.com',
            'is_public' => true
        ]);
        $this->post('/login', [
            'username' => 'test4',
            'password' => 'pass4'
        ]);
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Tweets', 'action' => 'index']);
    }

    /**
     * Test login method
     *
     * @return void
     */
    public function testLoginPostFail()
    {
        $this->post('/login', [
            'username' => 'test4',
            'password' => 'pass4'
        ]);
        $this->assertResponseSuccess();
        $this->assertResponseContains('入力が正しくありません。もう一度試してください。');
    }

    /**
     * Test logout method
     *
     * @return void
     */
    public function testLogout()
    {
        $this->get('/logout');
        $this->assertRedirect([
            'controller' => 'Users',
            'action' => 'login'
        ]);
    }

    /**
     * Test followers method
     *
     * @return void
     */
    public function testFollowers()
    {
        $this->get('/followers/' . 'test1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('Test 1は1人にフォローされています。');
        $this->assertResponseContains('<div class="follow-fullname">Test 2</div>');
    }

    /**
     * Test followers method
     *
     * @return void
     */
    public function testFollowersNotExistingUser()
    {
        $this->get('/followers/' . 'test4');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Tweets', 'action' => 'index']);
    }

    /**
     * Test following method
     *
     * @return void
     */
    public function testFollowing()
    {
        $this->get('/following/' . 'test1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('Test 1は2人をフォローしています。');
        $this->assertResponseContains('<div class="follow-fullname">Test 2</div>');
        $this->assertResponseContains('<div class="follow-fullname">Test 3</div>');
        $this->assertResponseContains('<div class="follow-tweet">テストツイート3 by test3</div>');
    }

    /**
     * Test following method
     *
     * @return void
     */
    public function testFollowingNotExistingUser()
    {
        $this->get('/following/' . 'test4');
        $this->assertResponseSuccess();
        $this->assertRedirect(['controller' => 'Tweets', 'action' => 'index']);
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchGet()
    {
        $this->get('/search');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<h2> 友だちを見つけて、フォローしましょう！</h2>');
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchPost()
    {
        $this->post('/search', [
            'searchQuery' => 'query'
        ]);
        $this->assertRedirect(['controller' => 'Users', 'action' => 'results', 'query']);
    }

    /**
     * Test search method
     *
     * @return void
     */
    public function testSearchPostEmpty()
    {
        $this->post('/search', [
            'searchQuery' => ''
        ]);
        $this->assertRedirect(['controller' => 'Users', 'action' => 'results', '_ALL']);
    }

    /**
     * Test results method
     *
     * @return void
     */
    public function testResults()
    {
        $this->get('/results/1');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<h3>1の検索結果</h3>');
        $this->assertResponseContains('<div class="follow-fullname">Test 1</div>');
        $this->assertResponseContains('<div class="follow-tweet">テストツイート1 by test1</div>');
    }

    /**
     * Test results method
     *
     * @return void
     */
    public function testResultsAll()
    {
        $this->get('/results/_ALL');
        $this->assertResponseSuccess();
        $this->assertResponseContains('<h2> 友だちを見つけて、フォローしましょう！</h2>');
        $this->assertResponseContains('<div class="follow-fullname">Test 1</div>');
        $this->assertResponseContains('<div class="follow-tweet">テストツイート1 by test1</div>');
        $this->assertResponseNotContains('の検索結果');
    }
}
