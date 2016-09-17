<?php
namespace App\Test\TestCase\Controller;

use App\Controller\FollowsController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FollowsController Test Case
 */
class FollowsControllerTest extends IntegrationTestCase
{

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
    public function authorize1()
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
     * Authorize
     *
     * @return void
     */
    public function authorize3()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 3,
                    'username' => 'test3',
                    'fullname' => 'Test 3',
                    'mail' => 'mail3@example.com',
                    'is_public' => 1,
                    'created' => '2016-08-31 20:05:37',
                    'last_login' => '2016-09-01 19:05:37'
                ]
            ]
        ]);
    }



    /**
     * Test addFollow method
     *
     * @return void
     */
    public function testAddFollowSuccess()
    {
        $this->ajaxSetUp();
        $this->authorize3();
        $this->post('/follows/addFollow/' . '1');
        $this->assertResponseOk();

        $follows = TableRegistry::get('Follows');
        $following = $follows->find()
            ->select(['to_user_id'])
            ->where(['from_user_id' => 3])
            ->first();
        $this->assertEquals(1, $following->to_user_id);

        $follows = TableRegistry::get('Follows');
        $count = $follows->find()->count();
        $this->assertEquals(5, $count);
    }

    /**
     * Test addFollow method
     *
     * @return void
     */
    public function testAddFollowFail()
    {
        $this->ajaxSetUp();
        $this->authorize1();
        $this->post('/follows/addFollow/' . '2');
        $this->assertResponseOk();

        $follows = TableRegistry::get('Follows');
        $count = $follows->find()->count();
        $this->assertEquals(4, $count);
    }


    /**
     * Test unfollow method
     *
     * @return void
     */
    public function testUnfollow()
    {
        $this->ajaxSetUp();
        $this->authorize1();
        $this->post('/follows/unFollow/' . '3');

        $this->assertResponseOk();

        $follows = TableRegistry::get('Follows');
        $count = $follows->find()->count();
        $this->assertEquals(3, $count);

        $follows = TableRegistry::get('Follows');
        $following = $follows->find()
            ->where(['from_user_id' => 1])
            ->andWhere(['to_user_id' => 3])
            ->toArray();
        $this->assertEmpty($following);
    }
}
