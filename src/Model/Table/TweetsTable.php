<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;


class TweetsTable extends Table
{
    /*
     * Association
     */
    public function initialize(array $config)
    {
        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('content', 'つぶやきが空です。')
            ->maxLength('content', 140, 'つぶやきは140文字以内にする必要があります。');
    }

    public function isNotEmpty()
    {
        if ($this->find()->first() !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function addTweet($userId, $data)
    {
        $tweet = $this->newEntity();
        $tweet->user_id = $userId;
        $patched = $this->patchEntity($tweet, $data);
        if ($this->save($patched)) {
            return true;
        } else {
            return true;
        }
    }

    public function removeTweet($userId, $tweetId)
    {
        $tweetOwner = $this->find()
            ->select(['user_id'])
            ->where(['id' => $tweetId])
            ->first();

        // Authentication check
        if (($tweetOwner !== null) and ($tweetOwner->user_id == $userId)) {
            $query = $this->query();
            $query->delete()
                ->where(['id' => $tweetId]);
            return $query->execute();
        } else {
            return false;
        }
    }
}

