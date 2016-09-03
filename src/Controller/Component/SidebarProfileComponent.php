<?php

namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\ORM\TableRegistry;

class SidebarProfileComponent extends Component
{
    public function initialize(array $config) {
        $this->Users = TableRegistry::get("Users");
        $this->Tweets = TableRegistry::get("Tweets");
    }

    public function checkUser($username)
    {
        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        if ($user == null) {
            return false;
        } else {
            return $user;
        }
    }

    public function getTweetsNum($username)
    {
        $user = $this->checkUser($username);
        if (! $user) {
            return null;
        }

        $tweets_check = $this->Tweets->find()
            ->where(['user_id' => $user->id]);

        if ($tweets_check->first() == null) {
            return 0;
        }

        $tweets_num = $this->Tweets->find()
            ->where(['user_id' => $user->id])
            ->count();
        return $tweets_num;
    }

    public function getFollowingsNum($username)
    {

        $user = $this->checkUser($username);
        if (! $user) {
            return null;
        }

        $followings_check = $this->Users->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $user->id]);

        if ($followings_check->first() == null) {
            return 0;
        }

        $followings_num = $this->Users->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $user->id]);
        return $followings_num->count();
    }

    public function getFollowersNum($username)
    {
        $user = $this->checkUser($username);
        if (! $user) {
            return null;
        }

        $followers_check = $this->Users->find()
            ->contain(['followed'])
            ->where(['followed.to_user_id' => $user->id]);

        if ($followers_check->first() == null) {
            return 0;
        }

        $followers_num = $this->Users->find()
            ->contain(['followed'])
            ->where(['followed.to_user_id' => $user->id]);
        return $followers_num->count();
    }

    public function create()
    {
    
    
    }
}


?>
