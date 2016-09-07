<?php
namespace App\View\Cell;

use Cake\View\Cell;

class SidebarCell extends Cell
{

    public function display($username)
    {
        $this->loadModel('Users');
        if (! $this->Users->contain($username)) {
            return null;
        }

        $user = $this->Users->getArrayBy($username);
        $userId = $user['id'];
        $this->set([
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'tweetsNum' => $this->Users->getTweetsNum($userId),
            'followingsNum' => $this->Users->getFollowingsNum($userId),
            'followersNum' => $this->Users->getFollowersNum($userId)
        ]);
    }
}

