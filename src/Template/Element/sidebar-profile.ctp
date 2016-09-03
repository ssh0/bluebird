<div id="side-nav">
    <ul class="Profile">
    <li><?php echo($fullname . '@' . $username); ?></li>
        <li>ツイート<?php echo $this->Html->link(
        $tweets_num, [
            'controller' => 'Users',
            'action' => 'view',
            $username
        ]); ?></li>
        <li>フォロー<?php echo $this->Html->link(
        $followings_num, [
            'controller' => 'Users',
            'action' => 'following',
            $username
        ]); ?></li>
        <li>フォロワー<?php echo $this->Html->link(
        $followers_num, [
            'controller' => 'Users',
            'action' => 'followers',
            $username
        ]); ?></li>
    </ul>
</div>
