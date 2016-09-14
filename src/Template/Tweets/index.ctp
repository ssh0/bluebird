<?= $this->append('css', $this->Html->css('load-piano.css')) ?>
<?= $this->append('script', $this->Html->script('tweets_index.js')) ?>
<?= $this->append('script', $this->Html->script('remove_tweet.js')) ?>
<?php if ($authUser !== null): ?>
<?php $sidebar = $this->cell('Sidebar::display', [$authUser['username']]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <div id="tweet_form">
            <?= $this->Form->create() ?>
            <?= $this->Form->textarea('content', [
                'placeholder' => 'いまどうしてる？',
                'rows' => 2,
                'maxlength' => 140
            ]) ?>
            <?= $this->Form->button(__('投稿する'), [
                'type' => 'button',
                'id' => 'tweet_button'
            ]) ?>
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
            ]
        ); ?>
            <?php endforeach ?>
        </div>
        <div id="loading">
            <div class="cssload-piano">
                    <div class="cssload-rect1"></div>
                    <div class="cssload-rect2"></div>
                    <div class="cssload-rect3"></div>
            </div>
        </div>
        <div id="content_end_message"><p>これより以前のツイートは存在しません。</p></div>
    </div>
</div>
