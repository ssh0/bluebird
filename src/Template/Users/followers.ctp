<?= $this->append('script', $this->Html->script('follow.js')) ?>
<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasFollowers): ?>
            <h3><?= h($fullname) ?>にはまだフォロワーがいません。</h3></br>
            <?php
                if ($isAuthorized) {
                    echo $this->Html->link('> 友達を検索する', [
                        'controller' => 'Users',
                        'action' => 'search'
                    ]
                );
                }
            ?>
        <?php else: ?>
            <h3><?= h($fullname) ?>は<?= $followers_num ?>人にフォローされています。</h3>
        <div class="follows">
            <?php foreach ($followers as $follower): ?>
            <?php if ($follower->tweet == null) {
                $content = '';
                $timestamp = '';
            } else {
                /* debug($follower); */
                $content = $follower->tweet->content;
                $timestamp = $follower->tweet->timestamp;
            } ?>
            <?= $this->element('follows', [
                'isAuthorized' => $isAuthorized,
                'authUserId' => $authUserId,
                'followId' => $follower->followed->id,
                'userId' => $follower->id,
                'username' => $follower->username,
                'fullname' => $follower->fullname,
                'timestamp' => $timestamp,
                'content' => $content,
                'follow' => $follower
            ])?>
            <?php endforeach ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if ($hasFollowers): ?>
        <div class="row">
            <div id="page_prev"><?= $this->Paginator->prev() ?></div>
            <div id="page_next"><?= $this->Paginator->next() ?></div>
            <div id="page_nums"><?= $this->Paginator->numbers() ?></div>
        </div>
    <?php endif; ?>
</div>

