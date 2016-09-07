<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasFollowings): ?>
            <h3><?= h($fullname) ?>はまだ誰もフォローしていません。</h3>
            <?php
                if ($isAuthorized) {
                    echo $this->Html->link('> 友達を検索する', [
                        'controller' => 'Users',
                        'action' => 'search'
                    ]);
                }
            ?>
        <?php else: ?>
            <h3><?= h($fullname) ?>は<?= $followings_num ?>人をフォローしています。</h3>
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Name', 'Created', '']);
            foreach ($followings as $following) {
                echo $this->Html->tableCells([
                    [
                        $following->fullname . $this->Html->link(
                            '@' . $following->username, [
                                'controller' => 'Users',
                                'action' => 'view',
                                $following->username
                            ]),
                        $following->created->i18nFormat(
                            'Y年M月d日 HH時mm分ss秒',
                            'Asia/Tokyo',
                            'ja-JP'
                        ),
                        $this->element('unfollow_button', [
                            'isAuthorized' => $isAuthorized,
                            'followingId' => $following->id
                        ])
                    ]
                ]);
            }
            print("</table><br />\n");
        ?>
        <?php endif; ?>
    </div>
    <?php if ($hasFollowings): ?>
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

