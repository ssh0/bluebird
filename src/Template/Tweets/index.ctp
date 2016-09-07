<?php if ($authUser !== null): ?>
<?php $sidebar = $this->cell('Sidebar::display', [$authUser['username']]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <div class="tweets">
            <?= $this->Form->create(null, [
                'url' => [
                    'controller' => 'Tweets',
                    'action' => 'posts'
                ]
            ]) ?>
            <?= $this->Form->textarea('content', [
                'placeholder' => 'いまどうしてる？',
                'rows' => 2,
                'maxlength' => 140
            ]) ?>
            <?= $this->Form->button(__('投稿する')); ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
<?php else: ?>
<div id="content-full">
<?php endif; ?>

<?php if ($tweetsExist) ?>
    <div class="row">
        <div class="tweets">
            <?php foreach ($tweets as $tweet): ?>
            <?= $this->element('tweets', [
                'authUser' => $authUser,
                'tweetId' => $tweet->id,
                'username' => $tweet->user->username,
                'fullname' => $tweet->user->fullname,
                'content' => $tweet->content,
                'timestamp' => $tweet->timestamp
            ]); ?>
            <?php endforeach ?>
        </div>
    </div>
    <div class="row">
        <div id="page_prev">
        <?= $this->Paginator->prev() ?>
        </div>
        <div id="page_next">
        <?= $this->Paginator->next() ?>
        </div>
        <div id="page_nums">
        <?= $this->Paginator->numbers() ?>
        </div>
    </div>
</div>
