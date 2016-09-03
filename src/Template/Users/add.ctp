<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('入力フォーム') ?></legend>
        <?= $this->Form->input('fullname', array(
            'label' => array(
                'text' => '呼び名(ニックネームも可)'
            ))) ?>
        <?= $this->Form->input('username', array(
            'label' => array(
                'text' => 'ユーザ名'
            ))) ?>
        <?= $this->Form->input('password', array(
            'label' => array(
                'text' => 'パスワード'
            ))) ?>
        <?= $this->Form->input('password2', array(
            'type' => 'password',
            'label' => array(
                'text' => 'パスワード(確認)'
            ))) ?>
        <?= $this->Form->input('mail', array(
            'label' => array(
                'text' => 'メールアドレス'
            ))) ?>
        <?= $this->Form->input('is_public', array(
            'type' => 'checkbox',
            'label' => array(
                'text' => 'つぶやきを公開設定にする'
            ))) ?>
    </fieldset>
<?= $this->Form->button(__('アカウント作成')); ?>
<?= $this->Form->end() ?>
</div>
