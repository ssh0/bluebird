<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TweetsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TweetsTable Test Case
 */
class TweetsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TweetsTable
     */
    public $TweetsTable;

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
        $config = TableRegistry::exists('Tweets') ? [] : ['className' => 'App\Model\Table\TweetsTable'];
        $this->TweetsTable = TableRegistry::get('Tweets', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->TweetsTable);

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
        $testCases = [
            true => [
                ['content' => 'tweet content'],
            ],
            false => [
                ['content' => ''],
                ['content' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
                aaaaaaaaaaaaaaaaaaaaaaaaaa'],
            ]
        ];
 
        foreach ($testCases as $expected => $cases){
            foreach ($cases as $case){
                $testCase = array_merge(['user_id' => 1], $case);
                $entity = $this->TweetsTable->newEntity($testCase);
                if ((boolean) $expected) {
                    $this->assertEmpty($entity->errors());
                } else {
                    $this->assertFalse(empty($entity->errors()));
                    $this->assertFalse($this->TweetsTable->save($entity));
                }
            }
        }
    }

    /**
     * Test isNotEmpty method
     *
     * @return void
     */
    public function testIsNotEmpty()
    {
        $this->assertTrue($this->TweetsTable->isNotEmpty());
    }

    /**
     * Test getTweetsNum method
     *
     * @return void
     */
    public function testGetTweetsNum()
    {
        $this->assertEquals('4', $this->TweetsTable->getTweetsNum());
    }

    /**
     * Test addTweet method
     *
     * @return void
     */
    public function testAddTweet()
    {
        $status = $this->TweetsTable->addTweet(1, [
            'content' => 'テスト by Test1',
        ]);
        $this->assertTrue($status);
        $result = $this->TweetsTable->find()
            ->order(['id' => 'DESC'])
            ->first()
            ->toArray();

        $expected = [
            'id' => 5,
            'user_id' => 1,
            'content' => 'テスト by Test1',
        ];
        $this->assertArraySubset($expected, $result);
    }

    /**
     * Test removeTweet method
     *
     * @return void
     */
    public function testRemoveTweet()
    {
        $testCases = [
            true => [
                ['userId' => 1, 'tweetId' => 1],
                ['userId' => 3, 'tweetId' => 4],
            ],
            false => [
                ['userId' => 2, 'tweetId' => 2],
                ['userId' => 1, 'tweetId' => 3],
                ['userId' => 3, 'tweetId' => 4],
            ]
        ];
 
        foreach ($testCases as $expected => $cases){
            foreach ($cases as $case) {
                $result = $this->TweetsTable->removeTweet(
                    $case['userId'], $case['tweetId']
                );
                if ((boolean) $expected) {
                    $this->assertTrue($result->execute());
                } else {
                    $this->assertFalse($result);
                }
            }
        }
    }

    /**
     * Test getLatestTweet method
     *
     * @return void
     */
    public function testGetLatestTweet()
    {
        $result = $this->TweetsTable->getLatestTweet()->toArray();
        $this->assertFalse(empty($result));

        $expected = [
            'id' => 4,
            'user_id' => 3,
            'content' => 'テストツイート3 by test3',
        ];
        $this->assertArraySubset($expected, $result);
    }

    /**
     * Test countTweetsInView method
     *
     * @return void
     */
    public function testCountTweetsInView()
    {
        $testCases = [
            ['oldestId' => 1, 'latestId' => 4, 'expected' => 4],
            ['oldestId' => 4, 'latestId' => 3, 'expected' => 0],
            ['oldestId' => 5, 'latestId' => 6, 'expected' => 0],
        ];

        foreach ($testCases as $testCase){
            $this->assertEquals($testCase['expected'],
                $this->TweetsTable->countTweetsInView(
                    $testCase['oldestId'],
                    $testCase['latestId']
                )
            );
        }
    }

    /**
     * Test updateTweets method
     *
     * @return void
     */
    public function testUpdateTweets()
    {
        $results = $this->TweetsTable->updateTweets(3)->toArray();
        $expected = [
            [
                'id' => 4,
                'user_id' => 3,
                'content' => 'テストツイート3 by test3',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'content' => 'テストツイート3',
            ]
        ];
        foreach ($results as $key => $result) {
            $this->assertArraySubset($expected[$key], $result->toArray());
        }

        $results = $this->TweetsTable->updateTweets(5)->toArray();
        $this->assertEmpty($results);
    }

    /**
     * Test loadTweetsAfter method
     *
     * @return void
     */
    public function testLoadTweetsAfter()
    {
        $results = $this->TweetsTable->loadTweetsAfter(2)->toArray();
        $expected = [
            [
                'id' => 4,
                'user_id' => 3,
                'content' => 'テストツイート3 by test3',
            ],
            [
                'id' => 3,
                'user_id' => 3,
                'content' => 'テストツイート3',
            ]
        ];
        foreach ($results as $key => $result) {
            $this->assertArraySubset($expected[$key], $result->toArray());
        }

        $results = $this->TweetsTable->loadTweetsAfter(4);
        $this->assertNull($results);
    }

    /**
     * Test loadTweetsBefore method
     *
     * @return void
     */
    public function testLoadTweetsBefore()
    {
        $results = $this->TweetsTable->loadTweetsBefore(3)->toArray();
        $expected = [
            [
                'id' => 2,
                'user_id' => 1,
                'content' => 'テストツイート1 by test1',
            ],
            [
                'id' => 1,
                'user_id' => 1,
                'content' => 'テストツイート1',
            ],
        ];
        foreach ($results as $key => $result) {
            $this->assertArraySubset($expected[$key], $result->toArray());
        }

        $results = $this->TweetsTable->loadTweetsBefore(1);
        $this->assertNull($results);
    }
}
