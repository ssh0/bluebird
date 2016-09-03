<div class="users form">
<?= $this->Flash->render('auth') ?>
<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('ユーザ名とパスワードを入力してください。') ?></legend>
        <?= $this->Form->input('username', array(
            'label' => array(
                'text' => 'ユーザ名'
            ))) ?>
        <?= $this->Form->input('password', array(
            'label' => array(
                'text' => 'パスワード'
            ))) ?>
            <?= $this->Form->button(__('ログイン')); ?>
    </fieldset>
<?= $this->Form->end() ?>
</div>
