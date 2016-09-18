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
        $followButton = '<i class="fa fa-bell-slash-o fbutton" id=unfollow:' .
            $userId . '></i>';
    } else {
        $followButton = '<i class="fa fa-user-plus fbutton" id=addfollow:' .
            $userId . '></i>';
    }
}
echo $followButton;
