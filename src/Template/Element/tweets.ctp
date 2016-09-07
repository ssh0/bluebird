<div class="tweet">
    <div class="tweet-name">
        <div class="tweet-fullname"><?= h($fullname) ?></div>
        <div class="tweet-username"><?php echo $this->Html->link(
        '@' . $username, [
            'controller' => 'Users',
            'action' => 'view',
            $username
        ]); ?></div>
    </div>
    <div class="tweet-created"><?php echo $timestamp->i18nFormat(
        'Y年M月d日 HH時mm分ss秒',
        'Asia/Tokyo',
        'ja-JP'
    ); ?></div>
    <div class="cl"></div>
    <div class="tweet-content"><?php echo nl2br($this->Text->autoLink($content)); ?></div>
    <div class="tweet-removebutton"><?php echo $this->element(
        'remove_tweet_button', [
            'authUser' => $authUser,
            'username' => $username,
            'tweetId' => $tweetId
        ]); ?></div>
</div>
