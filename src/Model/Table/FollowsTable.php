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
        $this->belongsTo('Users', [
            'foreignKey' => 'to',
            'bindingKey' => 'id'
        ]);
    }
}

