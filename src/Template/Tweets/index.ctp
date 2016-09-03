<div id="content">
    <?php if (! $auth_user == null): ?>
    <?= $this->element('sidebar-profile'); ?>
        <div class="row">
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
        <hr/>
    <?php endif; ?>
    <div class="row">
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Username', 'Content', 'Timestamp', 'delete']);
        ?>
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
        <?php print("</table><br />\n"); ?>
    </div>
</div>
