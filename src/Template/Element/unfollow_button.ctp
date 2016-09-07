<?php
if ($isAuthorized) {
    $unfollowButton = $this->Form->create(null, [
        'url' => [
            'controller' => 'Follows',
            'action' => 'unfollow',
            $followingId
        ],
        'onsubmit' => 'return confirm(
            "このユーザーをフォローから解除しますか?"
        )' 
    ]) . $this->Form->submit('hide-16.png', [
        'title' => 'フォロー解除'
    ]) . $this->Form->end();
} else {
    $unfollowButton = '';
}
echo $unfollowButton;

