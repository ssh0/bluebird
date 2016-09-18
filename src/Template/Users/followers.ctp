<?= $this->append('script', $this->Html->script('follow.js')) ?>
<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasFollowers): ?>
            <h3><?= h($fullname) ?>にはまだフォロワーがいません。</h3></br>
            <?php if ($isAuthorized) {
                echo $this->Html->link('> 友達を検索する', [
                    'controller' => 'Users',
                    'action' => 'search'
                ]
            );
            } ?>
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
                        'userId' => $follower->id,
                        'username' => $follower->username,
                        'fullname' => $follower->fullname,
                        'timestamp' => $timestamp,
                        'content' => $content,
                        'follow' => $follower
                    ])?>
                <?php endforeach ?>
                <div id="pagination">
                    <?= $this->Paginator->prev() ?>
                    <?= $this->Paginator->next() ?>
                    <div class="page_nums"><?= $this->Paginator->numbers() ?></div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

