<?php
$content = nl2br($this->Text->autoLink($content));
/* $created = $tweet->timestamp; */
/* 日本時間で表示 */
/* $created = $tweet->timestamp->nice('Asia/Tokyo', 'ja-JP'); */
/* 現在との相対的な時間 */
$created = $timestamp->timeAgoInWords([
    'accuracy' => 'minute'
]);

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
            'alt' => 'ツイートを削除'
        ]) . $this->Form->end();
} else {
    $remove_button = '';
}

echo $this->Html->tableCells([
    [
        "$fullname " . $this->Html->link('@' . $username, [
            'controller' => 'Users',
            'action' => 'view',
            $username
        ]),
        ["$content", ['style' => 'word-wrap:break-word;']],
        "$created",
        "$remove_button"
    ]
]);

