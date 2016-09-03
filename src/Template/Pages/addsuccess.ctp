<div id="content">
        <h2>Blubirdに参加しました。</h2>
        <p><?= $fullname ?>はBluebirdに参加されました。</p>
        <p>ログインをクリックしてログインしつぶやいてください。</p>
        <?php
            echo $this->Html->link(
                'ログイン',
                ['controller' => 'Users', 'action' => 'login'],
                ['class' => 'button', 'target' => '_top']
            );
        ?>
</div>

