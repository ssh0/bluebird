<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

class UsersController extends AppController
{

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
        $username = $this->Auth->user('username');
        return $this->redirect([
            'controll' => 'Users',
            'action' => 'view',
            $username
        ]);
    }

    public function view($username)
    {
        $tweets_ = $this->Users->find()
            ->contain(['Tweets'])
            ->where(['username' => $username])
            ->first();
        if ($tweets_ == null) {
            $tweets_exist = false;
        } else {
            $tweets_exist = true;
        }
        $this->set('tweets_exist', $tweets_exist);

        if ($tweets_exist) {
            $tweets = $this->Users->find()
                ->contain(['Tweets'])
                ->where(['username' => $username])
                ->order(['timestamp' => 'DESC']);
            $this->set('tweets', $tweets);

            $count = $this->Users->find('all')
                ->contain(['Tweets'])
                ->where(['username' => $username]);
            $this->set('count', $count->count());
        }
        else {
            $this->set('count', 0);
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
    public function followers()
    {
        $user = $this->Auth->user();

        $followers = $this->Users->find()
            ->contain(['Follows'])
            ->where(['Follows.to' => $user['id']])
            ->order(['Users.created' => 'DESC']);

        $followers_check = $this->Users->find()
            ->contain(['Follows'])
            ->where(['Follows.to' => $user['id']])
            ->order(['Users.created' => 'DESC']);

        if ($followers_check->first() == null) {
            $hasfollowers = false;
        } else {
            $hasfollowers = true;
        }

        $this->set('hasfollowers', $hasfollowers);
        $this->set('followers', $followers);
    }
}

