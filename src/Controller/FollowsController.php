<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class FollowsController extends AppController
{
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

