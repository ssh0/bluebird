<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class FollowsController extends AppController
{
    /**
     * Add to follow
     */
    public function addFollow($user_id)
    {
        if ($this->request->is('post')) {
            // Is authorized action?
            $auth_user = $this->request->session()->read('Auth.User');

            $query = $this->Follows->query();
            $query->insert(['from_user_id', 'to_user_id'])
                ->values([
                    'from_user_id' => $auth_user['id'],
                    'to_user_id' => $user_id
                ])
                ->execute();
            $this->Flash->success(__('フォローに追加しました'));
        } else {
            $this->Flash->error(__('不正な操作です。'));
        }

        return $this->redirect($this->referer());
    }

    /**
     * unfollow
     */
    public function unfollow($user_id)
    {
        if ($this->request->is('post')) {
            // Is authorized action?
            $auth_user = $this->request->session()->read('Auth.User');

            $query = $this->Follows->query()
                ->where([
                    'from_user_id' => $auth_user['id'],
                    'to_user_id' => $user_id
                ]);
            $query->delete()
                ->where([
                    'from_user_id' => $auth_user['id'],
                    'to_user_id' => $user_id
                ])
                ->execute();
            $this->Flash->success(__('フォローを解除しました'));
        } else {
            $this->Flash->error(__('不正な操作です。'));
        }

        return $this->redirect([
            'controller' => 'Users',
            'action' => 'following',
            $auth_user['username']
        ]);
    }
}

