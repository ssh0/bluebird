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
        $this->loadComponent('RequestHandler');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow([
            'index',
            'ajaxSyncAllTweets',
            'ajaxLoadTweets'
        ]);
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

    public function ajaxPost()
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $authUser = $this->Auth->user();
            $addTweetStatus = $this->Tweets->addTweet(
                $authUser['id'],
                $this->request->data
            );
        }
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

    public function ajaxRemove($tweetId)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            if ($this->Tweets->removeTweet($this->Auth->user('id'), $tweetId)) {
                return null;
            } else {
                return null;
            }
        }
    }

    public function ajaxRecieveNewTweets($latestId)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $html = '';
            $tweets = $this->Tweets->loadTweetsAfter($latestId);
            if ($tweets == null) {
                $this->set('tweetsExist', false);
            } else {
                $this->set([
                    'authUser' => $this->Auth->user(),
                    'tweets' => $tweets
                ]);
                $this->set('_serialize', [
                    'authUser',
                    'tweets'
                ]);
                $this->viewBuilder()->layout('ajax');
                $this->viewBuilder()->templatePath('Element/ajax');
                $html .= $this->render('tweets', false);
            }
        }
    }


    public function ajaxSyncAllTweets($oldestId, $latestId, $tweetsInView)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $nums = $this->Tweets->countTweetsInView($oldestId, $latestId);
            if ($nums == $tweetsInView) {
                return null;
            } else {
                $html = '';
                $tweets = $this->Tweets->updateTweets($oldestId);
                if ($tweets == null) {
                    $this->set('tweetsExist', false);
                } else {
                    $this->set([
                        'authUser' => $this->Auth->user(),
                        'tweets' => $tweets
                    ]);
                    $this->set('_serialize', [
                        'authUser',
                        'tweets'
                    ]);
                    $this->viewBuilder()->layout('ajax');
                    $this->viewBuilder()->templatePath('Element/ajax');
                    $html .= $this->render('tweets', false);
                }
            }
        }
    }

    public function ajaxLoadTweets($tweetId)
    {
        $this->autoRender = false;
        if ($this->request->is('ajax')) {
            $html = '';
            $authUser = $this->Auth->user();
            $tweets = $this->Tweets->loadTweetsBefore($tweetId);
            if ($tweets == null) {
                $this->set('tweetsExist', false);
            } else {
                $this->set([
                    'authUser' => $authUser,
                    'tweets' => $tweets
                ]);
                $this->set('_serialize', [
                    'authUser',
                    'tweets'
                ]);
                $this->viewBuilder()->layout('ajax');
                $this->viewBuilder()->templatePath('Element/ajax');
                $html .= $this->render('tweets', false);
            }
        }
    }

}
