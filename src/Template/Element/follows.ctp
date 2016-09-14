<div class="follow" id="<?= $followId ?>" >
    <div class="follow-name">
        <div class="follow-fullname"><?= h($fullname) ?></div>
        <div class="follow-username"><?php echo $this->Html->link(
        '@' . $username, [
            'controller' => 'Users',
            'action' => 'view',
            $username
        ]); ?></div>
    </div>
    <div class="follow-created"><?php 
if ($timestamp !== '') {
        echo $timestamp->i18nFormat(
        'Y年M月d日 HH時mm分ss秒',
        'Asia/Tokyo',
        'ja-JP'
    );} ?></div>
    <div class="cl"></div>
    <div class="follow-tweet"><?php echo nl2br($this->Text->autoLink($content)); ?></div>
    <div class="follow-button"><?php echo $this->element(
        'follow_button', [
            'isAuthorized' => $isAuthorized,
            'follow' => $follow,
            'followId' => $followId,
            'userId' => $userId,
            'authUserId' => $authUserId
        ]); ?></div>
</div>
