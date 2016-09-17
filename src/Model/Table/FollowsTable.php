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

    public function add($authUserId, $userId)
    {
        $count = $this->find()
            ->where(['from_user_id' => $authUserId])
            ->andWhere(['to_user_id' => $userId])
            ->count();
        if ($count > 0) {
            return null;
        }

        $query = $this->query();
        $query->insert(['from_user_id', 'to_user_id'])
            ->values([
                'from_user_id' => $authUserId,
                'to_user_id' => $userId
            ]);
        return $query->execute();
    }

    public function remove($authUserId, $userId)
    {
        $count = $this->find()
            ->where(['from_user_id' => $authUserId])
            ->andWhere(['to_user_id' => $userId])
            ->count();
        if ($count !== 1) {
            return null;
        }

        $query = $this->query();
        $query->delete()
            ->where([
                'from_user_id' => $authUserId,
                'to_user_id' => $userId
            ]);
        return $query->execute();
    }

}

