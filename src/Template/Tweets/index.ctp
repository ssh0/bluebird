<?php if (! $auth_user == null): ?>
    <?= $this->element('sidebar-profile'); ?>
    <div id="content">
<?php else: ?>
    <div id="content-full">
<?php endif; ?>
    <?php if (! $auth_user == null): ?>
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
    <?php endif; ?>
    <div class="row">
    <div class="tweets">
        <?php foreach ($tweets as $tweet): ?>
        <?= $this->element('tweets', [
            'auth_user' => $auth_user,
            'tweet_id' => $tweet->id,
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
