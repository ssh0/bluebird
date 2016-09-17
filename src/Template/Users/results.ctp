<?= $this->append('script', $this->Html->script('follow.js')) ?>
<div id="content-full">
    <?php if ($searchQuery == '_ALL'):?>
        <h2> 友だちを見つけて、フォローしましょう！</h2>
        <h4>Bluebirdに登録済みの友だちを検索できます。</h4></br>
    <?php else: ?>
        <h3><?= h($searchQuery); ?>の検索結果</h3>
    <?php endif; ?>
    <div class="row">
        <?= $this->Form->create(null, [
            'url' => [
                'controller' => 'Users',
                'action' => 'search'
            ]
        ]) ?>
        <?= $this->Form->input('searchQuery', [
            'label' => '誰を検索しますか？',
            'placeholder' => 'ユーザ名や名前で検索'
        ]) ?>
        <?= $this->Form->button(__('検索')); ?>
        <?= $this->Form->end() ?>
    </div>
    <hr/>
    <div class="row">
        <?php // debug($results); ?>
        <?php if (! $hasResults): ?>
            <h3>対象のユーザは見つかりません。</h3>
        <?php else: ?>
            <div class="follows">
                <?php foreach ($results as $user): ?>
                <?php if ($user->tweet == null) {
                    $content = '';
                    $timestamp = '';
                } else {
                    /* debug($user); */
                    $content = $user->tweet->content;
                    $timestamp = $user->tweet->timestamp;
                } ?>
                <?= $this->element('follows', [
                    'isAuthorized' => $isAuthorized,
                    'authUserId' => $authUserId,
                    'userId' => $user->id,
                    'username' => $user->username,
                    'fullname' => $user->fullname,
                    'timestamp' => $user->created,
                    'content' => $content,
                    'follow' => $user
                ])?>
                <?php endforeach ?>
                <div id="page_prev"><?= $this->Paginator->prev() ?></div>
                <div id="page_next"><?= $this->Paginator->next() ?></div>
                <div id="page_nums"><?= $this->Paginator->numbers() ?></div>
            </div>
        <?php endif; ?>
    </div>
</div>

