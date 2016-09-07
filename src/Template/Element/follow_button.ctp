<?php
if (! $isAuthorized) {
    $followButton = '';
} else {
    $isFollowedAlready = false;
    foreach ($follower->follows_to as $userFollowed) {
        if ($userFollowed->from_user_id == $authUserId) {
            $isFollowedAlready = true;
            break;
        }
    }
    if ($isFollowedAlready) {
        $followButton = '既にフォローしています。';
    } else {
        $followButton = $this->Form->create(null, [
            'url' => [
                'controller' => 'Follows',
                'action' => 'addFollow',
                $follower->id
            ],
            'onsubmit' => 'return confirm(
                "このユーザーをフォローしますか?"
            )' 
        ]) . $this->Form->submit('plus-16.png', [
            'title' => 'フォロー追加'
        ]) . $this->Form->end();
    }
}
echo $followButton;

