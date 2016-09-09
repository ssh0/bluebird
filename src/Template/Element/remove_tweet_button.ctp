<?php
if ($authUser['username'] == $username) {
    $removeButton = $this->Html->image(
        'trash-16.png', [
            'title' => 'ツイートを削除'
        ]
    );
} else {
    $removeButton = '';
}

echo $removeButton;

