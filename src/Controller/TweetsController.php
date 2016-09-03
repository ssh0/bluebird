<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class TweetsController extends AppController
{

    public $components = ['SidebarProfile'];
    public $paginate = [
        'limit' => 10,
        'contain' => 'Users',
        'order' => [
            'timestamp' => 'DESC'
        ]
    ];


    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('index');
    }

    public function index()
    {
        $auth_user = $this->request->session()->read('Auth.User');
        $this->set('auth_user', $auth_user);

        $tweets_check = $this->Tweets->find()
            ->contain(['Users'])
            ->first();

        if ($tweets_check == null) {
            $tweets_exist = false;
        } else {
            $tweets_exist = true;
        }
        $this->set('tweets_exist', $tweets_exist);

        if ($tweets_exist) {
            $this->set('tweets', $this->paginate());
        }

        if (! $auth_user == null) {
            $tweets_num = $this->SidebarProfile->getTweetsNum($auth_user['username']);
            $followings_num = $this->SidebarProfile->getFollowingsNum($auth_user['username']);
            $followers_num = $this->SidebarProfile->getFollowersNum($auth_user['username']);
            $this->set([
                'fullname' => $auth_user['fullname'],
                'username' => $auth_user['username'],
                'tweets_num' => (string) $tweets_num,
                'followings_num' => (string) $followings_num,
                'followers_num'=> (string) $followers_num
            ]);
        }
    }

    /**
     * Submit post
     */
    public function posts()
    {
        if ($this->request->is('post')) {
            $tweets = $this->Tweets->newEntity();
            $tweets->user_id = $this->Auth->user()['id'];
            $user = $this->Tweets->patchEntity($tweets, $this->request->data);
            if ($this->Tweets->save($tweets)) {
                $this->Flash->success(__('ツイートしました。'));
            } else {
                $this->Flash->error(__('ツイートに失敗しました。'));
            }
        }
        return $this->redirect([
            'controller' => 'Tweets',
            'action' => 'index'
        ]);
    }

    /**
     * Remove post
     */
    public function remove($tweet_id)
    {
        if ($this->request->is('post')) {
            // Is authorized action?
            $query = $this->Tweets->find('all')
                ->select(['user_id'])
                ->where(['id' => $tweet_id]);
            $user_id = $query->first()->user_id;
            $auth_user_id = $this->request->session()->read('Auth.User');
            if ($user_id == $auth_user_id['id']) {
                $query = $this->Tweets->query();
                $query->delete()
                    ->where(['id' => $tweet_id])
                    ->execute();
                $this->Flash->success(__('ツイートを削除しました。'));
            } else {
                $this->Flash->error(__('不正な操作です。'));
            }
        }
        return $this->redirect([
            'controller' => 'Tweets',
            'action' => 'index'
        ]);
    }

}
