<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

    public $paginate = [
        'limit' => 10,
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Paginator');
    }

    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        $this->Auth->allow();
    }

    /**
     * Display
     */
    public function index()
    {
        $username = $this->request->session()->read('Auth.User');
        if (! $username == null) {
            return $this->redirect([
                'controll' => 'Users',
                'action' => 'view',
                $username['username']
            ]);
        }
        return $this->redirect([
            'controll' => 'Tweets',
            'action' => 'index'
        ]);
    }

    public function view($username)
    {
        $user_exist = $this->Users->contain($username);
        $this->set('user_exist', $user_exist);

        if ($user_exist) {
            $user = $this->Users->getArrayBy($username);
            $tweets_exist = $this->Users->hasTweets($username);
            $this->set([
                'tweets_exist' => $tweets_exist,
                'username' => $user['username'],
                'fullname' => $user['fullname'],
            ]);

            if ($tweets_exist) {
                $this->set(
                    'tweets',
                    $this->paginate($this->Users->getAllTweets($username))
                );
            }
        }
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        $this->set('user', $user);
        if ($this->request->is('post')) {
            if ($this->Users->addUser($user, $this->request->data)) {
                $this->Flash->success(__('ユーザ登録が完了しました。'));
                return $this->redirect([
                    'controller' => 'Pages',
                    'action' => 'addsuccess',
                    $user['fullname']
                ]);
            } else {
                $this->Flash->error(__('ユーザ登録に失敗しました。'));
            }
        }
    }

    /**
     * Login
     */
    public function login()
    {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                $this->Users->updateLastLogin($this->Auth->user()['username']);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(
                __('入力が正しくありません。もう一度試してください。', [
                    'key' => 'auth'
                ])
            );
        }
    }

    public function logout()
    {
        $this->Flash->success(__('正常にログアウトしました。'));
        return $this->redirect($this->Auth->logout());
    }

    /**
     * Followers
     */
    public function followers($username)
    {
        $authUser = $this->request->session()->read('Auth.User');
        if ($this->Users->isAuthorized($authUser, $username)) {
            $this->set('isAuthorized', true);
        } else {
            $this->set('isAuthorized', false);
        }

        if (! $this->Users->contain($username)) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        } else {
            $user = $this->Users->getArrayBy($username);
            $userId = $user['id'];
            if (! $this->Users->hasFollowers($userId)) {
                $this->set([
                    'fullname' => $user['fullname'],
                    'username' => $user['username'],
                    'hasfollowers' => false
                ]);
            } else {
                $this->set([
                    'user_id' => $userId,
                    'fullname' => $user['fullname'],
                    'username' => $user['username'],
                    'hasfollowers' => true,
                    'followers' => $this->paginate($this->Users->getAllFollowers($userId)),
                    'followers_num'=> $this->Users->getFollowersNum($userId)
                ]);
            }
        }
    }

    /**
     * Following
     */
    public function following($username)
    {
        $authUser = $this->request->session()->read('Auth.User');
        if ($this->Users->isAuthorized($authUser, $username)) {
            $this->set('isAuthorized', true);
            $this->set('authUserId', $authUser['id']);
        } else {
            $this->set('isAuthorized', false);
        }

        if (! $this->Users->contain($username)) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        } else {
            $user = $this->Users->getArrayBy($username);
            $userId = $user['id'];
            if (! $this->Users->hasFollowings($userId)) {
                $this->set([
                    'username' => $user['username'],
                    'fullname' => $user['fullname'],
                    'hasfollowings' => false
                ]);
            } else {
                $this->set([
                    'user_id' => $userId,
                    'fullname' => $user['fullname'],
                    'username' => $user['username'],
                    'hasfollowings' => true,
                    'followings' => $this->paginate($this->Users->getAllFollowings($userId)),
                    'followings_num'=> $this->Users->getFollowingsNum($userId)
                ]);
            }
        }
    }

    /*
     * Seach users
     */
    public function search()
    {
        if ($this->request->is('post')) {
            $searchQuery = $this->request->data['searchQuery'];
            if ($searchQuery == '') {
                $searchQuery = '_ALL';
            }
            return $this->redirect([
                'controller' => 'Users',
                'action' => 'results',
                $searchQuery
            ]);
        }
    }

    /*
     * Show the search results
     */
    public function results($searchQuery)
    {
        $this->set('searchQuery', $searchQuery);
        $authUser = $this->request->session()->read('Auth.User');
        if ($authUser !== null) {
            $this->set('isAuthorized', true);
            $this->set('authUserId', $authUser['id']);
        } else {
            $this->set('isAuthorized', false);
        }

        // 空文字の時の処理
        if ($searchQuery == '_ALL') {
            $results = $this->Users->getAllUsersWithRelations();
            if ($results == null) {
                $this->set('hasResults', false);
            } else {
                $this->set([
                    'hasResults' => true,
                    'results' => $this->paginate($results)
                ]);
            }
        } else {
            $results = $this->Users->getPartialMatches($searchQuery);
            if ($results == null) {
                $this->set('hasResults', false);
                return $this->redirect($this->referer());
            } else {
                $this->set([
                    'hasResults' => true,
                    'results' => $this->paginate($results)
                ]);
            }
        }
    }
}

