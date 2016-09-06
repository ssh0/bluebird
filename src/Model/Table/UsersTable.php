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
            ->notEmpty('username', 'ユーザ名が必要です。')
            ->lengthBetween('username', [4, 20], 'ユーザ名は4〜20字としてください。')
            ->notEmpty('password', 'パスワードが必要です。')
            ->lengthBetween('password', [4, 8], 'パスワードは4〜8字としてください。')
            ->alphaNumeric('password', 'パスワードは半角英数字だけで構成されている必要があります。')
            ->notEmpty('password2', '確認用パスワードが必要です。')
            ->sameAs('password2', 'password', '入力したパスワードが異なっています。')
            ->notEmpty('mail', 'メールアドレスが必要です。')
            ->email('mail', '正しいメールアドレスではありません。')
            ->allowEmpty('is_public')
            ->boolean('is_public', 'ブール値ではない(普通表示されない)');
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
            return true;  // success
        } else {
            return false;  // fail
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

    public function hasTweets($username)
    {
        $user = $this->find()
            ->contain(['Tweets'])
            ->where(['username' => $username])
            ->first();

        if ($user->tweet !== null) {
            return true;
        } else {
            return false;
        }
    }

    public function getAllTweets($username)
    {
        return $this->find()
            ->contain('Tweets')
            ->where(['username' => $username])
            ->order(['timestamp' => 'DESC']);
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

    public function getAllFollowings($userId)
    {
        return $this->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $userId])
            ->order(['created' => 'DESC']);
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

    public function getAllFollowers($userId)
    {
        return $this->find()
            ->contain(['followed', 'follows_to'])
            ->distinct(['Users.id'])
            ->where(['followed.to_user_id' => $userId])
            ->order(['created' => 'DESC']);
    }

    public function getPartialMatches($query)
    {
        $user = $this->find()
            ->where(['OR' => [
                'Users.username LIKE' => '%' . $query . '%',
                'Users.fullname LIKE' => '%' . $query . '%',
            ]])
            ->first();

        if ($user !== null) {
            return $this->find()
                ->contain(['followed', 'follows_to'])
                ->distinct(['Users.id'])
                ->where(['OR' => [
                    'Users.username LIKE' => '%' . $query . '%',
                    'Users.fullname LIKE' => '%' . $query . '%',
                ]])
                ->order(['created' => 'DESC']);
        } else {
            return null;
        }
    }

    public function getAllUsersWithRelations()
    {
        if ($this->find()->first() !== null) {
            return $this->find()
                ->contain(['followed', 'follows_to'])
                ->distinct(['Users.id'])
                ->order(['created' => 'DESC']);
        } else {
            return null;
        }
    }
}

