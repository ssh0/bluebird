<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Bluebird - twitter like toy app';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>

    <script src="https://code.jquery.com/jquery-3.1.0.min.js"
        integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s="
        crossorigin="anonymous"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-bar expanded" data-topbar role="navigation">
        <ul class="title-area large-3 medium-4 columns">
            <li class="name">
                <h1><?php echo $this->Html->link(
                    'Bluebird', [
                        'controller' => 'Tweets',
                        'action' => 'index',
                    ]); ?></h1>
            </li>
        </ul>
        <div class="top-bar-section">
            <ul class="right">
            <li><?php echo $this->Html->link(
                'ホーム', [
                    'controller' => 'Tweets',
                    'action' => 'index',
                ]); ?></li>
                <?php
                    $auth_user = $this->request->session()->read('Auth.User');
                ?>
                <?php if ($auth_user == null): ?>
                    <li><?php echo $this->Html->link(
                        'ユーザ登録', [
                            'controller' => 'Users',
                            'action' => 'add',
                        ]); ?></li>
                    <li><?php echo $this->Html->link(
                    'ログイン', [
                        'controller' => 'Users',
                        'action' => 'login',
                    ]); ?></li>
                <?php else: ?>
                    <li><?php echo $this->Html->link(
                       $auth_user['fullname'] . ' @' . $auth_user['username'], [
                            'controller' => 'Users',
                            'action' => 'view',
                            $auth_user['username']
                        ]); ?></li>
                    <li><?php echo $this->Html->link(
                       '友達を検索', [
                            'controller' => 'Users',
                            'action' => 'search',
                        ]); ?></li>
                    <li><?php echo $this->Html->link(
                       'ログアウト', [
                            'controller' => 'Users',
                            'action' => 'logout',
                        ]); ?></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <?= $this->Flash->render() ?>
    <div class="container clearfix">
        <?= $this->fetch('content') ?>
    </div>
    <footer>
    </footer>
</body>
</html>
