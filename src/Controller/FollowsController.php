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
        if ($this->request->is('post')) {
            // Is authorized action?
            /* $authUser = $this->request->session()->read('Auth.User'); */
            if ($this->Follows->add($this->Auth->user('id'), $userId)) {
                $this->Flash->success(__('フォローに追加しました'));
            } else {
                $this->Flash->error(__('フォローへの追加に失敗しました。'));
            }
        }
        return $this->redirect($this->referer());
    }

    /**
     * unfollow
     */
    public function unfollow($userId)
    {
        if ($this->request->is('post')) {
            // Is authorized action?
            /* $authUser = $this->request->session()->read('Auth.User'); */
            if ($this->Follows->remove($this->Auth->user('id'), $userId)) {
                $this->Flash->success(__('フォローを解除しました'));
            } else {
                $this->Flash->error(__('フォロー解除に失敗しました。'));
            }
        }
        return $this->redirect($this->referer());
    }
}

