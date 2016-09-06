<?php
namespace App\View\Cell;

use Cake\View\Cell;

class SidebarCell extends Cell
{

    public function display($username)
    {
        $this->loadModel('Users');
        $this->loadModel('Tweets');
        if (! $this->Users->contain($username)) {
            return null;
        }

        $user = $this->Users->getArrayBy($username);
        $userId = $user['id'];
        $this->set([
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'tweets_num' => $this->getTweetsNum($username, $userId),
            'followings_num' => $this->Users->getFollowingsNum($userId),
            'followers_num' => $this->Users->getFollowersNum($userId)
        ]);
    }

    public function getTweetsNum($username, $userId)
    {
        if (! $this->Users->hasTweets($username)) {
            return '0';
        } else {
            return (string) $this->Tweets->find()
                ->where(['user_id' => $userId])
                ->count();
        }
    }
}

