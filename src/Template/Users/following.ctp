<?= $this->append('script', $this->Html->script('follow.js')) ?>
<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasFollowings): ?>
            <h3><?= h($fullname) ?>はまだ誰もフォローしていません。</h3>
            <?php
                if ($isAuthorized) {
                    echo $this->Html->link('> 友達を検索する', [
                        'controller' => 'Users',
                        'action' => 'search'
                    ]);
                }
            ?>
        <?php else: ?>
            <h3><?= h($fullname) ?>は<?= $followings_num ?>人をフォローしています。</h3>
            <div class="follows">
                <?php foreach ($followings as $following): ?>
                    <?php if ($following->tweet == null) {
                        $content = '';
                        $timestamp = '';
                    } else {
                        $content = $following->tweet->content;
                        $timestamp = $following->tweet->timestamp;
                    } ?>
                    <?= $this->element('follows', [
                        'isAuthorized' => $isAuthorized,
                        'authUserId' => $authUserId,
                        'userId' => $following->id,
                        'username' => $following->username,
                        'fullname' => $following->fullname,
                        'timestamp' => $timestamp,
                        'content' => $content,
                        'follow' => $following
                    ])?>
                <?php endforeach ?>
                <div id="page_prev"><?= $this->Paginator->prev() ?></div>
                <div id="page_next"><?= $this->Paginator->next() ?></div>
                <div id="page_nums"><?= $this->Paginator->numbers() ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

