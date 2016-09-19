<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\I18n\Time;

/**
 * App\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UsersTable
     */
    public $UsersTable;

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
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'App\Model\Table\UsersTable'];
        $this->UsersTable = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UsersTable);

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
     * Data provider for testValidationDefault
     *
     * @return array
     */
    public function validationProvider()
    {
        $baseCase = [
            'username' => 'test4',
            'fullname' => 'BobBob',
            'password' => 'pass',
            'password2' => 'pass',
            'mail' => 'mail@example.com',
            'is_public' => True,
        ];
 
        $testCases = [
            true => [
                'other username' => ['username' => 'aaaa'],
                'other username' => ['username' => 'user_name-desu'],
                'other fullname' => ['fullname' => '日本語_and'],
                'other fullname' => ['fullname' => '半角ｶﾅ'],
                'is_public can be null' => ['is_public' => null],
            ],
            false => [
                'noEmpty(username)'       => ['username'  => ''],
                'noEmpty(fullname)'       => ['fullname'  => ''],
                'noEmpty(password)'       => ['password'  => ''],
                'noEmpty(password2)'      => ['password2' => ''],
                'noEmpty(mail)'           => ['mail'      => ''],
                'other username'          => ['username'  => 'user=name'],
                'lengthBetween(username)' => ['username'  => 'bob'],
                'lengthBetween(username)' => ['username'  => 'bobbobbobbobbobbobbob'],
                'other fullname'          => ['fullname'  => '日本語+and'],
                'lengthBetween(fullname)' => ['fullname'  => 'Bob'],
                'lengthBetween(fullname)' => ['fullname'  => 'BOBBOBBOBBOBBOBBOBBOB'],
                'lengthBetween(password)' => ['password'  => 'pas', 'password2' => 'pas'],
                'lengthBetween(password)' => ['password'  => 'passwoord', 'password2' => 'passwoord'],
                'alphaNumeric(password)'  => ['password'  => 'パスワード', 'password2' => 'パスワード'],
                'sameAs(password)'        => ['password'  => 'pass', 'password2' => 'paas'],
                'email(mail)'             => ['mail'      => 'foobar'],
                'boolean(is_public)'      => ['is_public' => 'foo'],
            ]
        ];
 
        $result = [];
        foreach ($testCases as $expected => $cases){
            foreach ($cases as $key => $case){
                $testCase = array_merge($baseCase, $case);
                $result[$key] = ['expected' => $expected, 'testCase' => $testCase];
            }
        }
        return $result;
    }

    /**
     * Test validationDefault method
     *
     * @dataProvider validationProvider
     * @return void
     */
    public function testValidationDefault($expected, $testCase)
    {
        $entity = $this->UsersTable->newEntity($testCase);
        if ((boolean) $expected) {
            $this->assertEmpty($entity->errors());
        } else {
            $this->assertFalse(empty($entity->errors()));
            $this->assertFalse($this->UsersTable->save($entity));
        }
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

    /**
     * Test contain method
     *
     * @return void
     */
    public function testContain()
    {
        $result = $this->UsersTable->contain('test1');
        $this->assertEquals(true, $result);

        $result = $this->UsersTable->contain('foo');
        $this->assertEquals(false, $result);
    }

    /**
     * Test getArrayBy method
     *
     * @return void
     */
    public function testGetArrayBy()
    {
        $result = $this->UsersTable->getArrayBy('test1');
        $expected = [
            'id' => 1,
            'username' => 'test1',
            'fullname' => 'Test 1',
            'mail' => 'mail1@example.com',
            'password' => 'pass1',
            'is_public' => True,
            'created' => new Time('2016-08-29 20:05:37'),
            'last_login' => new Time('2016-09-01 20:05:37'),
            'tweet' => [
                'id' => 1,
                'user_id' => 1,
                'content' => 'テストツイート1',
                'timestamp' => new Time('2016-09-01 20:05:37')
            ]
        ];
        $this->assertEquals($expected, $result);
    }

    /**
     * Test isAuthorized method
     *
     * @return void
     */
    public function testIsAuthorized()
    {
        $authUser = ['username' => 'test1'];
        $this->assertTrue($this->UsersTable->isAuthorized($authUser, 'test1'));
        $this->assertFalse($this->UsersTable->isAuthorized($authUser, 'test2'));
        $this->assertFalse($this->UsersTable->isAuthorized(null, 'test1'));
    }

    /**
     * Data provider for testAddUser
     *
     * @return array
     */
    public function addUserProvider()
    {
        $baseCase = [
            'username' => 'test4',
            'fullname' => 'Test 4',
            'mail' => 'mail4@example.com',
            'password' => 'pass4',
            'password2' => 'pass4',
            'is_public' => true,
        ];
 
        $testCases = [
            true => [
                'username' => ['username' => 'aaaa'],
                'is_public' => ['is_public' => false],
            ],
            false => [
                'username must be unique' => ['username' => 'test1'],
            ]
        ];
        $result = [];
        foreach ($testCases as $expected => $cases){
            foreach ($cases as $key => $case){
                $testCase = array_merge($baseCase, $case);
                $result[$key] = ['expected' => $expected, 'testCase' => $testCase];
            }
        }
        return $result;
    }

    /**
     * Test addUser method
     *
     * @dataProvider addUserProvider
     * @return void
     */
    public function testAddUser($expected, $testCase)
    {
        $user = $this->UsersTable->newEntity();
        if ((boolean) $expected) {
            $this->assertTrue($this->UsersTable->addUser($user, $testCase));
        } else {
            $this->assertFalse($this->UsersTable->addUser($user, $testCase));
        }
    }

    /**
     * Test updateLastLogin method
     *
     * @return void
     */
    public function testUpdateLastLogin()
    {
        $now = date('2016-09-01 12:00:00');
        $this->UsersTable->updateLastLogin('test1');
        $lastLogin = $this->UsersTable->find()
            ->select(['last_login'])
            ->where(['username' => 'test1'])
            ->first()
            ->toArray();
        $this->assertGreaterThan($now, $lastLogin);
    }

    /**
     * Test hasTweets method
     *
     * @return void
     */
    public function testHasTweets()
    {
        $testCases = [
            [1 => true],
            [2 => false],
            [3 => true],
            [4 => false]
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->hasTweets((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test hasFollowings method
     *
     * @return void
     */
    public function testHasFollowings()
    {
        $testCases = [
            [1 => true],
            [2 => true],
            [3 => false],
            [4 => false]
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->hasFollowings((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test hasFollowers method
     *
     * @return void
     */
    public function testHasFollowers()
    {
        $testCases = [
            [1 => true],
            [2 => true],
            [3 => true],
            [4 => false]
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->hasFollowers((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test getTweetsNum method
     *
     * @return void
     */
    public function testGetTweetsNum()
    {
        $testCases = [
            [1 => '2'],
            [2 => '0'],
            [3 => '2'],
            [4 => '0']
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->getTweetsNum((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test getFollowingsNum method
     *
     * @return void
     */
    public function testGetFollowingsNum()
    {
        $testCases = [
            [1 => '2'],
            [2 => '2'],
            [3 => '0'],
            [4 => '0']
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->getFollowingsNum((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test getFollowersNum method
     *
     * @return void
     */
    public function testGetFollowersNum()
    {
        $testCases = [
            [1 => '1'],
            [2 => '1'],
            [3 => '2'],
            [4 => '0']
        ];

        foreach ($testCases as $testCase) {
            foreach ($testCase as $userId => $expected) {
                $result = $this->UsersTable->getFollowersNum((int) $userId);
                $this->assertEquals($expected, $result);
            }
        }
    }

    /**
     * Test getAllTweets method
     *
     * @return void
     */
    public function testGetAllTweets()
    {
        $testCase = [
            'test1' => [
                [
                    'username' => 'test1',
                    'tweet' => [
                        'id' => 2,
                        'user_id' => 1,
                        'content' => 'テストツイート1 by test1',
                    ]
                ],
                [
                    'username' => 'test1',
                    'tweet' => [
                        'id' => 1,
                        'user_id' => 1,
                        'content' => 'テストツイート1',
                    ]
                ],
            ],
            'test2' => [
                [
                    'username' => 'test2',
                    'tweet' => null
                ],
            ]
        ];

        foreach ($testCase as $username => $expected) {
            $results = $this->UsersTable->getAllTweets($username)->toArray();
            foreach ($results as $key => $result) {
                $this->assertArraySubset($expected[$key], $result->toArray());
            }
        }
    }

    /**
     * Test getAllFollowings method
     *
     * @return void
     */
    public function testGetAllFollowings()
    {
        $testCase = [
            1 => [
                [
                    'username' => 'test3',
                    'tweet' => [
                        'id' => 4,
                        'user_id' => 3,
                        'content' => 'テストツイート3 by test3',
                    ]
                ],
                [
                    'username' => 'test2',
                    'tweet' => []
                ],
            ],
            2 => [
                [
                    'username' => 'test3',
                    'tweet' => [
                        'id' => 4,
                        'user_id' => 3,
                        'content' => 'テストツイート3 by test3',
                    ]
                ],
                [
                    'username' => 'test1',
                    'tweet' => [
                        'id' => 2,
                        'user_id' => 1,
                        'content' => 'テストツイート1 by test1',
                    ]
                ],
            ],
        ];

        foreach ($testCase as $userId => $expected) {
            $results = $this->UsersTable->getAllFollowings($userId)->toArray();
            foreach ($results as $key => $result) {
                $this->assertArraySubset($expected[$key], $result->toArray());
            }
        }
    }

    /**
     * Test getAllFollowers method
     *
     * @return void
     */
    public function testGetAllFollowers()
    {
        $testCase = [
            1 => [
                [
                    'username' => 'test2',
                    'tweet' => []
                ],
            ],
            2 => [
                [
                    'username' => 'test1',
                    'tweet' => [
                        'id' => 2,
                        'user_id' => 1,
                        'content' => 'テストツイート1 by test1',
                    ]
                ],
            ],
        ];

        foreach ($testCase as $userId => $expected) {
            $results = $this->UsersTable->getAllFollowers($userId)->toArray();
            foreach ($results as $key => $result) {
                $this->assertArraySubset($expected[$key], $result->toArray());
            }
        }
    }

    /**
     * Test getPartialMatches method
     *
     * @return void
     */
    public function testGetPartialMatches()
    {
        $testCase = [
            '1' => [
                [
                    'username' => 'test1',
                    'tweet' => [
                        'user_id' => 1,
                        'content' => 'テストツイート1 by test1',
                    ],
                    'follows_to' => [
                        [
                            'to_user_id' => 1,
                        ]
                    ],

                ],
            ],
            'test' => [
                [
                    'username' => 'test3',
                    'tweet' => [
                        'user_id' => 3,
                        'content' => 'テストツイート3 by test3',
                    ],
                    'follows_to' => [
                        [
                            'from_user_id' => 1,
                            'to_user_id' => 3,
                        ],
                        [
                            'from_user_id' => 2,
                            'to_user_id' => 3,
                        ]
                    ],
                ],
                [
                    'username' => 'test2',
                    'tweet' => [],
                    'follows_to' => [
                        [
                            'to_user_id' => 2,
                        ]
                    ],
                ],
                [
                    'username' => 'test1',
                    'tweet' => [
                        'user_id' => 1,
                        'content' => 'テストツイート1 by test1',
                    ],
                    'follows_to' => [
                        [
                            'to_user_id' => 1,
                        ]
                    ],
                ]
            ]
        ];

        foreach ($testCase as $query => $expected) {
            $results = $this->UsersTable->getPartialMatches($query)->toArray();
            foreach ($results as $key => $result) {
                $this->assertArraySubset($expected[$key], $result->toArray());
            }
        }

        $result = $this->UsersTable->getPartialMatches('fff');
        $this->assertNull($result);
    }

    /**
     * Test getAllUsersWithRelations method
     *
     * @return void
     */
    public function testGetAllUsersWithRelations()
    {
        $testCase = [
            [
                'username' => 'test3',
                'tweet' => [
                    'user_id' => 3,
                    'content' => 'テストツイート3 by test3',
                ],
                'follows_to' => [
                    [
                        'from_user_id' => 1,
                        'to_user_id' => 3,
                    ],
                    [
                        'from_user_id' => 2,
                        'to_user_id' => 3,
                    ]
                ],
            ],
            [
                'username' => 'test2',
                'tweet' => [],
                'follows_to' => [
                    [
                        'from_user_id' => 1,
                        'to_user_id' => 2,
                    ]
                ],
            ],
            [
                'username' => 'test1',
                'tweet' => [
                    'user_id' => 1,
                    'content' => 'テストツイート1 by test1',
                ],
                'follows_to' => [
                    [
                        'from_user_id' => 2,
                        'to_user_id' => 1,
                    ]
                ],
            ]

        ];

        $results = $this->UsersTable->getAllUsersWithRelations()->toArray();
        foreach ($results as $key => $result) {
            $this->assertArraySubset($testCase[$key], $result->toArray());
        }
    }

    /**
     * Test getAllLatestTweets method
     *
     * @return void
     */
    public function testGetAllLatestTweets()
    {
        $whereCondition = ['Users.id' => 1];
        $contains = ['follows_to', 'Tweets'];

        $expected = [
            [
                'username' => 'test1',
                'tweet' => [
                    'user_id' => 1,
                    'content' => 'テストツイート1 by test1',
                ],
                'follows_to' => [
                    [
                        'from_user_id' => 2,
                        'to_user_id' => 1,
                    ]
                ],
            ]
        ];

        $results = $this->UsersTable->getAllLatestTweets($whereCondition, $contains)->toArray();
        foreach ($results as $key => $result) {
            $this->assertArraySubset($expected[$key], $result->toArray());
        }
    }
}
