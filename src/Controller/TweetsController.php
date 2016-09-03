<?php

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class TweetsController extends AppController
{

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow('index');
    }

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */
    public function index()
    {
        $tweets_ = $this->Tweets->find()
            ->contain(['Users'])
            ->first();

        if ($tweets_ == null) {
            $tweets_exist = false;
        } else {
            $tweets_exist = true;
        }
        $this->set('tweets_exist', $tweets_exist);

        if ($tweets_exist) {
            $tweets = $this->Tweets->find('all')
                ->contain(['Users'])
                ->order(['timestamp' => 'DESC'])
                ->all();
            $this->set('tweets', $tweets);
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
