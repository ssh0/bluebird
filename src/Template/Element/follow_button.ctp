<?php
if ((! $isAuthorized) or ($follow->id == $authUserId)) {
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
        $followButton = $this->Html->image(
            'hide-16.png', [
                'title' => 'フォロー解除',
                'alt' => 'フォロー解除',
                'class' => 'fbutton',
                'id' => 'unfollow:' . $userId
            ]
        );
    } else {
        $followButton = $this->Html->image(
            'plus-16.png', [
                'title' => 'フォロー追加',
                'alt' => 'フォロー追加',
                'class' => 'fbutton',
                'id' => 'addfollow:' . $userId
            ]
        );
    }
}
echo $followButton;
