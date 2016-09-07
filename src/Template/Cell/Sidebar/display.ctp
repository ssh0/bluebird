<section id="sidebar-profile">
    <div id="profile-fullname"><?php echo($fullname); ?></div>
    <div id="profile-username"><?php echo('@' . $username); ?></div>
    <div class='cl'></div>
    <div id="profile-tweets">つぶやき</div>
    <div id="profile-followers">フォロワー</div>
    <div id="profile-following">フォロー</div>

    <div class='cl'></div>
    <div id="profile-tweets-num">
        <?php echo $this->Html->link(
            $tweetsNum, [
                'controller' => 'Users',
                'action' => 'view',
                $username
            ]); ?>
    </div>
    <div id="profile-followers-num">
        <?php echo $this->Html->link(
            $followersNum, [
                'controller' => 'Users',
                'action' => 'followers',
                $username
            ]); ?>
    </div>
    <div id="profile-following-num">
        <?php echo $this->Html->link(
            $followingsNum, [
                'controller' => 'Users',
                'action' => 'following',
                $username
            ]); ?>
    </div>
</section>
