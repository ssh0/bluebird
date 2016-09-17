<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 *
 */
class UsersFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => [
            'type' => 'integer',
            'length' => 10,
            'unsigned' => true,
            'null' => false,
            'default' => null,
            'comment' => '',
            'autoIncrement' => true,
            'precision' => null
        ],
        'username' => [
            'type' => 'string',
            'fixed' => true,
            'length' => 20,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null
        ],
        'fullname' => [
            'type' => 'string',
            'fixed' => true,
            'length' => 20,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null
        ],
        'mail' => [
            'type' => 'string',
            'fixed' => true,
            'length' => 100,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null
        ],
        'password' => [
            'type' => 'string',
            'length' => 255,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null,
            'fixed' => null
        ],
        'is_public' => [
            'type' => 'boolean',
            'length' => null,
            'null' => false,
            'default' => '1',
            'comment' => '',
            'precision' => null
        ],
        'created' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null
        ],
        'last_login' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => false,
            'default' => '0000-00-00 00:00:00',
            'comment' => '',
            'precision' => null
        ],
        '_constraints' => [
            'primary' => [
                'type' => 'primary',
                'columns' => ['id'],
                'length' => []
            ],
            'name' => [
                'type' => 'unique',
                'columns' => ['username'],
                'length' => []
            ],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'username' => 'test1',
            'fullname' => 'Test 1',
            'mail' => 'mail1@example.com',
            'password' => 'pass1',
            'is_public' => 1,
            'created' => '2016-08-29 20:05:37',
            'last_login' => '2016-09-01 20:05:37'
        ],
        [
            'username' => 'test2',
            'fullname' => 'Test 2',
            'mail' => 'mail2@example.com',
            'password' => 'pass2',
            'is_public' => 1,
            'created' => '2016-08-30 20:05:37',
            'last_login' => '2016-09-01 21:05:37'
        ],
        [
            'username' => 'test3',
            'fullname' => 'Test 3',
            'mail' => 'mail3@example.com',
            'password' => 'pass3',
            'is_public' => 1,
            'created' => '2016-08-31 20:05:37',
            'last_login' => '2016-09-01 19:05:37'
        ]
    ];
}
