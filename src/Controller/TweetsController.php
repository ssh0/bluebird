<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;

class TweetsController extends AppController
{

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
        $authUser = $this->request->session()->read('Auth.User');
        $this->set('authUser', $authUser);

        if ($this->Tweets->isNotEmpty()) {
            $this->set([
                'tweetsExist' => true,
                'tweets' => $this->paginate()
            ]);
        } else {
            $this->set('tweetsExist', false);
        }
    }

    /**
     * Submit post
     */
    public function posts()
    {
        if ($this->request->is('post')) {
            $result = $this->Tweets->addTweet(
                $this->Auth->user('id'),
                $this->request->data
            );
            if ($result) {
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
    public function remove($tweetId)
    {
        if ($this->request->is('post')) {
            if ($this->Tweets->removeTweet($this->Auth->user('id'), $tweetId)) {
                $this->Flash->success(__('ツイートを削除しました。'));
            } else {
                $this->Flash->error(__('ツイートの削除に失敗しました。'));
            }
        }
        return $this->redirect([
            'controller' => 'Tweets',
            'action' => 'index'
        ]);
    }
}
