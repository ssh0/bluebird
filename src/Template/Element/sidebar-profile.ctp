<div id="sidebar-profile">
    <ul class="Profile">
    <li><?php echo($fullname . '@' . $username); ?></li>
    <li><?= $followings_num ?><?php echo $this->Html->link(
        'フォローしている', [
            'controller' => 'Users',
            'action' => 'following',
            $username
        ]); ?></li>
        <li><?= $followers_num ?><?php echo $this->Html->link(
        'フォローされている', [
            'controller' => 'Users',
            'action' => 'followers',
            $username
        ]); ?></li>
    <li><?php echo $this->Html->link(
        'つぶやき' . $tweets_num, [
            'controller' => 'Users',
            'action' => 'view',
            $username
        ]); ?></li>
    </ul>
</div>
