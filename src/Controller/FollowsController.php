<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class FollowsController extends AppController
{

    /*
     * Following users
     */
    public function following()
    {
        $user = $this->Auth->user();

        $followings = $this->Follows->find('all');
        $followings->contain(['Users'])
            ->where(['Follows.from' => $user['id']])
            ->order(['Users.created' => 'DESC']);

        $followings_check = $this->Follows->find('all');
        $followings_check->contain(['Users'])
            ->where(['Follows.from' => $user['id']])
            ->order(['Users.created' => 'DESC']);

        if ($followings_check->first() == null) {
            $hasfollowings = false;
        } else {
            $hasfollowings = true;
        }

        $this->set('hasfollowings', $hasfollowings);
        $this->set('followings', $followings);
    }

    /*
     * Add to following
     */
    public function add($follow_id)
    {
        if ($this->request->is('post')) {
            $follows = $this->Follows->newEntity();
            $my_id = $this->Auth->user()['id'];

            $query = $this->Follows->query();
            $query->insert(['from', 'to'])
                ->values([
                    'from' => $my_id,
                    'to' => $follow_id
                ])
                ->execute();
                $this->Flash->success(__('フォローに追加しました。'));
            ]);
        }
    }

}

