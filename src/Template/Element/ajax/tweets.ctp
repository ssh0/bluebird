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
