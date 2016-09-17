<?php
namespace App\Controller;

use App\Controller\AppController;

class FollowsController extends AppController
{
    /**
     * Add to follow
     */
    public function addFollow($userId)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->Follows->add($this->Auth->user('id'), $userId);
        }
    }

    /**
     * unfollow
     */
    public function unfollow($userId)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $this->Follows->remove($this->Auth->user('id'), $userId);
        }
    }
}

