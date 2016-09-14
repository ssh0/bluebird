<?php
if (! $isAuthorized) {
    $followButton = '';
} else {
    $isFollowedAlready = false;
    foreach ($follow->follows_to as $userFollowed) {
        if ($userFollowed->from_user_id == $authUserId) {
            $isFollowedAlready = true;
            break;
        }
    }
    if ($isFollowedAlready) {
        /* $followButton = '既にフォローしています。'; */
        $followButton = $this->Html->image(
            'hide-16.png', [
                'title' => 'フォロー解除',
                'class' => 'unfollow'

            ]
        );
    } else {
        $followButton = $this->Html->image(
            'plus-16.png', [
                'title' => 'フォロー追加',
                'class' => 'addfollow'
            ]
        );
    }
}
echo $followButton;

