<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasFollowers): ?>
            <h3><?= h($fullname) ?>にはまだフォロワーがいません。</h3></br>
            <?php
                if ($isAuthorized) {
                    echo $this->Html->link('> 友達を検索する', [
                        'controller' => 'Users',
                        'action' => 'search'
                    ]
                );
                }
            ?>
        <?php else: ?>
            <h3><?= h($fullname) ?>は<?= $followers_num ?>人にフォローされています。</h3>
            <?php
                echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
                echo $this->Html->tableHeaders(['Name', 'Created', '']);
                foreach ($followers as $follower) {
                    echo $this->Html->tableCells([
                        [
                            $follower->fullname . $this->Html->link(
                                '@' . $follower->username, [
                                    'controller' => 'Users',
                                    'action' => 'view',
                                    $follower->username
                                ]),
                            $follower->created->i18nFormat(
                                'Y年M月d日 HH時mm分ss秒',
                                'Asia/Tokyo',
                                'ja-JP'
                            ),
                            $this->element('follow_button', [
                                'isAuthorized' => $isAuthorized,
                                'follower' => $follower,
                                'authUserId' => $authUserId
                            ])
                        ]
                    ]);
                }
                print("</table><br />\n");
            ?>
        <?php endif; ?>
    </div>
    <?php if ($hasFollowers): ?>
        <div class="row">
            <div id="page_prev">
            <?= $this->Paginator->prev() ?>
            </div>
            <div id="page_next">
            <?= $this->Paginator->next() ?>
            </div>
            <div id="page_nums">
            <?= $this->Paginator->numbers() ?>
            </div>
        </div>
    <?php endif; ?>
</div>

