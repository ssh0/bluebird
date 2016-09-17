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
        $authUser = $this->request->session()->read('Auth.User');
        if (! $authUser == null) {
            return $this->redirect([
                'controll' => 'Users',
                'action' => 'view',
                $authUser['username']
            ]);
        }
        return $this->redirect([
            'controll' => 'Tweets',
            'action' => 'index'
        ]);
    }

    public function view($username)
    {
        $userExist = $this->Users->contain($username);
        $this->set('userExist', $userExist);

        if ($userExist) {
            $user = $this->Users->getArrayBy($username);
            $tweetsExist = $this->Users->hasTweets($user['id']);
            $this->set([
                'tweetsExist' => $tweetsExist,
                'username' => $user['username'],
                'fullname' => $user['fullname'],
            ]);

            if ($tweetsExist) {
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
                    'controller' => 'Users',
                    'action' => 'addsuccess',
                    $user['fullname']
                ]);
            } else {
                $this->Flash->error(__('ユーザ登録に失敗しました。'));
            }
        }
    }

    /**
     * Register success
     */
    public function addsuccess($fullname)
    {
        $this->set('fullname', $fullname);
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
        $authUser = $this->Auth->user();
        if ($this->Users->isAuthorized($authUser, $username)) {
            $this->set('isAuthorized', true);
            $this->set('authUserId', $authUser['id']);
        } else {
            $this->set('isAuthorized', false);
            $this->set('authUserId', null);
        }

        if (! $this->Users->contain($username)) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        }

        $user = $this->Users->getArrayBy($username);
        $userId = $user['id'];

        if (! $this->Users->hasFollowers($userId)) {
            $this->set([
                'fullname' => $user['fullname'],
                'username' => $user['username'],
                'hasFollowers' => false
            ]);
            return;
        }

        $this->set([
            'user_id' => $userId,
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'hasFollowers' => true,
            'followers' => $this->paginate($this->Users->getAllFollowers($userId)),
            'followers_num'=> $this->Users->getFollowersNum($userId)
        ]);
    }

    /**
     * Following
     */
    public function following($username)
    {
        $authUser = $this->Auth->user();
        if ($this->Users->isAuthorized($authUser, $username)) {
            $this->set('isAuthorized', true);
            $this->set('authUserId', $authUser['id']);
        } else {
            $this->set('isAuthorized', false);
            $this->set('authUserId', null);
        }

        if (! $this->Users->contain($username)) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        }

        $user = $this->Users->getArrayBy($username);
        $userId = $user['id'];
        if (! $this->Users->hasFollowings($userId)) {
            $this->set([
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'hasFollowings' => false
            ]);
            return;
        }

        $this->set([
            'user_id' => $userId,
            'fullname' => $user['fullname'],
            'username' => $user['username'],
            'hasFollowings' => true,
            'followings' => $this->paginate($this->Users->getAllFollowings($userId)),
            'followings_num'=> $this->Users->getFollowingsNum($userId)
        ]);
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
        $authUser = $this->Auth->user();
        if ($authUser !== null) {
            $this->set('isAuthorized', true);
            $this->set('authUserId', $authUser['id']);
        } else {
            $this->set('isAuthorized', false);
            $this->set('authUserId', null);
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
            } else {
                $this->set([
                    'hasResults' => true,
                    'results' => $this->paginate($results)
                ]);
            }
        }
    }
}

