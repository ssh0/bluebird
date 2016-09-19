<?php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\ORM\Rule\IsUnique;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;


class UsersTable extends Table
{
    /*
     * Association
     */
    public function initialize(array $config)
    {
        $this->belongsTo('Tweets', [
            'foreignKey' => 'id',
            'bindingKey' => 'user_id'
        ]);

        $this->hasMany('follows_from',[
            'className' => 'Follows',
            'foreignKey' => 'from_user_id',
        ]);
        $this->hasMany('follows_to',[
            'className' => 'Follows',
            'foreignKey' => 'to_user_id',
        ]);
        $this->belongsTo('followed',[
            'className' => 'Follows',
            'foreignKey' => 'id',
            'bindingKey' => 'from_user_id'
        ]);
        $this->belongsTo('following',[
            'className' => 'Follows',
            'foreignKey' => 'id',
            'bindingKey' => 'to_user_id'
        ]);
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->notEmpty('fullname', '名前が必要です。')
            ->lengthBetween('fullname', [4, 20], '名前は4〜20字としてください。')
            ->add('fullname', 'fullnamePattern', [
                'rule' => 'isValidFullname',
                'message' => '名前は4〜20字とし，「-」、「_」以外の半角記号を使用することはできません。',
                'provider' => 'table'
            ])
            ->notEmpty('username', 'ユーザ名が必要です。')
            ->add('username', 'usernamePattern', [
                'rule' => 'isValidUsername',
                'message' => 'ユーザ名は4〜20字の半角英数字もしくは「-」、「_」で構成されている必要があります。',
                'provider' => 'table'
            ])
            ->notEmpty('password', 'パスワードが必要です。')
            ->add('password', 'passPattern', [
                'rule' => 'isValidPassword',
                'message' => 'パスワードは半角英数字(4〜8字)で構成されている必要があります。',
                'provider' => 'table'
            ])
            ->notEmpty('password2', '確認用パスワードが必要です。')
            ->sameAs('password2', 'password', '入力したパスワードが異なっています。')
            ->notEmpty('mail', 'メールアドレスが必要です。')
            ->email('mail', '正しいメールアドレスではありません。')
            ->allowEmpty('is_public')
            ->boolean('is_public', 'ブール値ではありません');
    }

    /**
     * Validation rule for username
     *
     * @return boolean
     */
    public function isValidUsername($value)
    {
        return preg_match('/^[a-zA-Z0-9\-_]{4,20}$/', $value) == 1;
    }

    /**
     * Validation rule for fullname
     *
     * @return boolean
     */
    public function isValidFullname($value)
    {
        return preg_match('/^[a-zA-Z0-9\-_ぁ-んァ-ヶー一-龠０-９、。]{4,20}$/u', $value) == 1;
    }


    /**
     * Validation rule for password
     *
     * @return boolean
     */
    public function isValidPassword($value)
    {
        return preg_match('/^[a-zA-Z0-9]{4,8}$/', $value) == 1;
    }

    /**
     * save実行時のバリデーション
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->IsUnique(
            ['username'],
            '既に使用されているユーザ名です。'
        ));
        return $rules;
    }

    public function contain($username)
    {
        $user = $this->find()
            ->where(['username' => $username])
            ->first();

        if ($user !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function getArrayBy($username)
    {
        return $this->find()
            ->contain('Tweets')
            ->where(['username' => $username])
            ->first()
            ->toArray();
    }

    public function isAuthorized($authUser, $username)
    {
        if ($authUser !== null && $authUser['username'] == $username) {
            return true;
        } else {
            return false;
        }
    }

    public function addUser($user, $postedData)
    {
        $patched = $this->patchEntity($user, $postedData, [
            'fieldList' => [
                'fullname', 'username', 'password', 'mail', 'is_public'
            ]
        ]);

        if ($this->save($patched)) {
            return true;
        } else {
            return false;
        }
    }

    public function updateLastLogin($username)
    {
        $query = $this->query();
        $query->update()
            ->set(['last_login' => date('Y-m-d H:i:s')])
            ->where(['username' => $username])
            ->execute();
    }

    public function hasTweets($userId)
    {
        $user = $this->find()
            ->contain(['Tweets'])
            ->where(['user_id' => $userId])
            ->first();

        if ($user !== null && $user->tweet !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function hasFollowings($userId)
    {
        $user = $this->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $userId])
            ->first();

        if ($user !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function hasFollowers($userId)
    {
        $user = $this->find()
            ->contain(['followed'])
            ->where(['followed.to_user_id' => $userId])
            ->first();

        if ($user !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function getTweetsNum($userId)
    {
        if ($this->hasTweets($userId)) {
            return (string) $this->find()
                ->contain(['Tweets'])
                ->where(['user_id' => $userId])
                ->count();
        } else {
            return '0';
        }
    }

    public function getFollowingsNum($userId)
    {
        if ($this->hasFollowings($userId)) {
            return (string) $this->find()
                ->contain(['following'])
                ->where(['following.from_user_id' => $userId])
                ->count();
        } else {
            return '0';
        }
    }

    public function getFollowersNum($userId)
    {
        if ($this->hasFollowers($userId)) {
            return (string) $this->find()
                ->contain(['followed'])
                ->where(['followed.to_user_id' => $userId])
                ->count();
        } else {
            return '0';
        }
    }

    public function getAllTweets($username)
    {
        return $this->find()
            ->contain('Tweets')
            ->where(['username' => $username])
            ->order(['timestamp' => 'DESC']);
    }

    public function getAllFollowings($userId)
    {
        $whereCondition = ['following.from_user_id' => $userId];
        $contains = ['following', 'follows_to', 'Tweets'];
        return $this->getAllLatestTweets($whereCondition, $contains);
    }

    public function getAllFollowers($userId)
    {
        $whereCondition = ['followed.to_user_id' => $userId];
        $contains = ['followed', 'follows_to', 'Tweets'];
        return $this->getAllLatestTweets($whereCondition, $contains);
    }

    public function getPartialMatches($query)
    {
        $whereCondition = ['OR' => [
            'Users.username LIKE' => '%' . $query . '%',
            'Users.fullname LIKE' => '%' . $query . '%',
        ]];
        $contains = ['followed', 'follows_to', 'Tweets'];
        return $this->getAllLatestTweets($whereCondition, $contains);
    }

    public function getAllUsersWithRelations()
    {
        $whereCondition = [];
        $contains = ['followed', 'follows_to', 'Tweets'];
        return $this->getAllLatestTweets($whereCondition, $contains);
    }

    public function getAllLatestTweets($condition, $contains)
    {
        $containsWithoutTweets = array_diff($contains, ['Tweets']);
        $user = $this->find()
            ->contain($containsWithoutTweets)
            ->select(['user_id' => 'Users.id'])
            ->where($condition);

        $userIds = [];
        foreach ($user as $id) {
            $userIds[] = $id['user_id'];
        }

        if (empty($userIds)) {
            return null;
        }

        $latestTweetId = $this->find();
        $latestTweetId
            ->matching('Tweets')
            ->contain($containsWithoutTweets)
            ->where($condition)
            ->group(['Users.id'])
            ->select([
                'user_id' => 'Users.id',
                'latest_id' => $latestTweetId->func()->max('Tweets.id')
            ]);

        $tweetIds = [];
        $diffUserIds = [];
        foreach ($latestTweetId as $id) {
            $tweetIds[] = $id['latest_id'];
            $diffUserIds[] = $id['user_id'];
        }

        if (! empty($tweetIds)) {
            $whereCondition = ['Tweets.id IN' => $tweetIds];
        } else {
            $whereCondition = [];
        }

        $diffedUserIds = array_diff($userIds, $diffUserIds);
        if (! empty($diffedUserIds)) {
            $whereCondition[] = ['Users.id IN' => $diffedUserIds];
            $whereCondition = ['OR' => $whereCondition];
        }

        return $this->find()
                ->contain($contains)
                ->where($whereCondition)
                ->group('Users.id')
                ->order(['created' => 'DESC']);
    }
}

