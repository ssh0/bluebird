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
        $this->Auth->allow('add', 'addsuccess');
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
        $tweets_check = $this->Users->find()
            ->contain(['Tweets'])
            ->where(['username' => $username])
            ->first();
        if ($tweets_check->tweet == null) {
            $tweets_exist = false;
        } else {
            $tweets_exist = true;
        }
        $this->set('tweets_exist', $tweets_exist);

        if ($tweets_exist) {
            $tweets = $this->Users->find()
                ->contain('Tweets')
                ->where(['username' => $username])
                ->order(['timestamp' => 'DESC']);
            $this->set('tweets', $this->paginate($tweets));
        }
    }

    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data, [
                'fieldList' => [
                    'fullname', 'username', 'password', 'mail', 'is_public'
                ]
            ]);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('ユーザ登録が完了しました。'));
                /* $this->Auth->setUser($user); */
                return $this->redirect([
                    'controller' => 'Pages',
                    'action' => 'addsuccess',
                    $user['fullname']
                ]);
            }
            $this->Flash->error(__('ユーザ登録に失敗しました。'));
        }
        $this->set('user', $user);
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
                $id = $this->Auth->user()['id'];
                $query = $this->Users->query();
                $query->update()
                    ->set(['last_login' => date('Y-m-d H:i:s')])
                    ->where(['id' => $id])
                    ->execute();
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(
                __('入力が正しくありません。もう一度試してください。', [
                'key' => 'auth'])
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
        // get user
        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        if ($user == null) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        }

        $followers_check = $this->Users->find()
            ->contain(['followed'])
            ->where(['followed.to_user_id' => $user->id]);

        if ($followers_check->first() == null) {
            $hasfollowers = false;
        } else {
            $hasfollowers = true;
        }
        $this->set('hasfollowers', $hasfollowers);

        // create 'get followers' query
        $followers = $this->Users->find()
            ->contain(['followed'])
            ->where(['followed.to_user_id' => $user->id])
            ->order(['created' => 'DESC']);
        $this->set('followers', $this->paginate($followers));
    }

    /**
     * Following
     */
    public function following($username)
    {
        // get user
        $user = $this->Users->find()
            ->where(['Users.username' => $username])
            ->first();

        if ($user == null) {
            $this->Flash->error(__('存在しないユーザ名です。'));
            return $this->redirect([
                'controller' => 'Tweets',
                'action' => 'index'
            ]);
        }

        $followings_check = $this->Users->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $user->id]);

        if ($followings_check->first() == null) {
            $hasfollowings = false;
        } else {
            $hasfollowings = true;
        }
        $this->set('hasfollowings', $hasfollowings);

        // create 'get followers' query
        $followings = $this->Users->find()
            ->contain(['following'])
            ->where(['following.from_user_id' => $user->id])
            ->order(['created' => 'DESC']);
        $this->set('followings', $this->paginate($followings));
    }
}

