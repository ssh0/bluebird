<div class="users form">
<?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('入力フォーム') ?></legend>
        <?= $this->Form->input('fullname', [
            'label' => [
                'text' => '呼び名(ニックネームも可)'
            ],
            'placeholder' => '4~20字で入力'
        ]) ?>
        <?= $this->Form->input('username', [
            'label' => [
                'text' => 'ユーザ名'
            ],
            'placeholder' => '4~20字で入力'
        ]) ?>
        <?= $this->Form->input('password', [
            'label' => [
                'text' => 'パスワード'
            ],
            'placeholder' => '4~20字の英数字を入力'
        ]) ?>
        <?= $this->Form->input('password2', [
            'type' => 'password',
            'label' => [
                'text' => 'パスワード(確認)'
            ],
            'placeholder' => '上のパスワードと同じものを入力'
        ]) ?>
        <?= $this->Form->input('mail', [
            'label' => [
                'text' => 'メールアドレス'
            ],
            'placeholder' => 'メールアドレスを入力'
        ]) ?>
        <?= $this->Form->input('is_public', [
            'type' => 'checkbox',
            'label' => [
                'text' => 'つぶやきを公開設定にする'
            ]
        ]) ?>
    </fieldset>
<?= $this->Form->button(__('アカウント作成')); ?>
<?= $this->Form->end() ?>
</div>
