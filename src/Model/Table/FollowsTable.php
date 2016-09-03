<?php
namespace App\Model\Table;

use Cake\ORM\Table;


class FollowsTable extends Table
{
    /*
     * Association
     */
    public function initialize(array $config)
    {
        $this->belongsTo('from_user', [
            'className' => 'Users',
            'foreignKey' => 'from_user_id',
            'bindingKey' => 'id'
        ]);
        $this->belongsTo('to_user', [
            'className' => 'Users',
            'foreignKey' => 'to_user_id',
            'bindingKey' => 'id'
        ]);
    }
}

