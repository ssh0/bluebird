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
}

