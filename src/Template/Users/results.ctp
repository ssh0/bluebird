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
            <?php if (! $hasResults): ?>
                <h3>対象のユーザは見つかりません。</h3>
            <?php else: ?>
                <?php
                    echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
                    echo $this->Html->tableHeaders(['Name', 'Created', '']);
                    foreach ($results as $user) {
                        echo $this->Html->tableCells([
                            [
                                $user->fullname . $this->Html->link(
                                    '@' . $user->username, [
                                        'controller' => 'Users',
                                        'action' => 'view',
                                        $user->username
                                    ]),
                                $user->created->i18nFormat(
                                    'Y年M月d日 HH時mm分ss秒',
                                    'Asia/Tokyo',
                                    'ja-JP'
                                ),
                                $this->element('follow_button', [
                                    'isAuthorized' => $isAuthorized,
                                    'follower' => $user,
                                    'authUserId' => $authUserId
                                ])
                            ]
                        ]);
                    }
                    print("</table><br />\n");
                ?>
            <?php endif; ?>
    </div>
    <?php if ($hasResults): ?>
        <div class="row">
            <div id="page_prev"><?= $this->Paginator->prev() ?></div>
            <div id="page_next"><?= $this->Paginator->next() ?></div>
            <div id="page_nums"><?= $this->Paginator->numbers() ?></div>
        </div>
    <?php endif; ?>
</div>

