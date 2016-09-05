<div class="tweet">
<?php
$content = nl2br($this->Text->autoLink($content));
/* 日本時間(日付も表示)で表示 */
$created = $timestamp->i18nFormat(
    'Y年M月d日 HH時mm分ss秒',
    'Asia/Tokyo',
    'ja-JP'
);
/* -> 2016年8月29日 21時42分55秒 */

if ($auth_user['username'] == $username) {
    $remove_button = $this->Form->create(null, [
        'url' => [
            'controller' => 'Tweets',
            'action' => 'remove',
            $tweet_id
            ],
            'onsubmit' => 'return confirm(
                "このツイートを削除してもよろしいですか?"
            )'
        ]) . $this->Form->submit('trash-16.png', [
            'alt' => 'ツイートを削除',
            'title' => 'ツイートを削除'
        ]) . $this->Form->end();
} else {
    $remove_button = '';
}

?>
<div class="tweet-name">
    <div class="tweet-fullname"><?= h($fullname) ?></div>
    <div class="tweet-username"><?php echo $this->Html->link(
    '@' . $username, [
        'controller' => 'Users',
        'action' => 'view',
        $username
    ]); ?></div>
</div>
<div class="tweet-created"><?php echo $created; ?></div>
<div class="cl"></div>
<div class="tweet-content"><?php echo $content; ?></div>
<div class="tweet-removebutton"><?php echo $remove_button; ?></div>
</div>
