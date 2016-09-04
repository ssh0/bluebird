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
