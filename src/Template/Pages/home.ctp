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
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Network\Exception\NotFoundException;

/* $this->layout = false; */

$cakeDescription = 'Bluebird - twitter-mock application';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>
    </title>
    <?= $this->Html->meta('icon') ?>
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
</head>
<body class="home">
    <header>
    </header>
    <div id="content">
        <div class="row">
                <?= $this->Form->create(null, [
                    'url' => ['controller' => 'Tweets',
                    'action' => 'posts']
                ]) ?>
                <fieldset>
                    <h2>いまなにしてる？</h2>
                    <?= $this->Form->textarea('content') ?>
                    <?= $this->Form->button(__('投稿する')); ?>
                </fieldset>
            <?= $this->Form->end() ?>
        </div>
        <hr/>
        <div class="row">
            <?= debug($tweets) ?>
            <?php if (isset($tweets)) {
                while($row = $tweets->fetch_object()) {
                    $id = htmlspecialchars($row->id);
                    $content = htmlspecialchars($row->content);
                    $timestamp = htmlspecialchars($row->timestamp);
                    print("    <tr><td>$id</td><td>$content</td><td>$timestamp</td></tr>\n");
                }
                print("</table><br />\n");
                }
            ?>
        </div>

    </div>
</body>
</html>
