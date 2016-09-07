<?php
if ($authUser['username'] == $username) {
    $removeButton = $this->Form->create(null, [
        'url' => [
            'controller' => 'Tweets',
            'action' => 'remove',
            $tweetId
            ],
            'onsubmit' => 'return confirm(
                "このツイートを削除してもよろしいですか?"
            )'
        ]) . $this->Form->submit('trash-16.png', [
            'title' => 'ツイートを削除'
        ]) . $this->Form->end();
} else {
    $removeButton = '';
}

echo $removeButton;

