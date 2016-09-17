<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TweetsFixture
 *
 */
class TweetsFixture extends TestFixture
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
        'user_id' => [
            'type' => 'integer',
            'length' => 11,
            'unsigned' => false,
            'null' => false,
            'default' => null,
            'comment' => '',
            'precision' => null,
            'autoIncrement' => null
        ],
        'content' => [
            'type' => 'string',
            'fixed' => true,
            'length' => 140,
            'null' => false,
            'default' => null,
            'collate' => 'utf8_general_ci',
            'comment' => '',
            'precision' => null
        ],
        'timestamp' => [
            'type' => 'timestamp',
            'length' => null,
            'null' => false,
            'default' => 'CURRENT_TIMESTAMP',
            'comment' => '',
            'precision' => null],
        '_constraints' => [
            'primary' => [
                'type' => 'primary',
                'columns' => ['id'],
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
            'user_id' => 1,
            'content' => 'テストツイート1',
            'timestamp' => '2016-09-01 20:05:37'
        ],
        [
            'user_id' => 1,
            'content' => 'テストツイート1 by test1',
            'timestamp' => '2016-09-01 20:10:37'
        ],
        [
            'user_id' => 3,
            'content' => 'テストツイート3',
            'timestamp' => '2016-09-01 20:15:37'
        ],
        [
            'user_id' => 3,
            'content' => 'テストツイート3 by test3',
            'timestamp' => '2016-09-01 20:26:37'
        ]
    ];
}
