<?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
<?= $sidebar ?>
<div id="content">
    <div class="row">
        <?php if (! $hasfollowings): ?>
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
                $username = $following->username;
                $fullname = $following->fullname;
                /* 日本時間(日付も表示)で表示 */
                $created = $following->created->i18nFormat(
                    'Y年M月d日 HH時mm分ss秒',
                    'Asia/Tokyo',
                    'ja-JP'
                );
                /* -> 2016年8月29日 21時42分55秒 */

                // create unfollow button
                if ($isAuthorized) {
                    $unfollow_button = $this->Form->create(null, [
                        'url' => [
                            'controller' => 'Follows',
                            'action' => 'unfollow',
                            $following->id
                        ],
                        'onsubmit' => 'return confirm(
                            "このユーザーをフォローから解除しますか?"
                        )' 
                    ]) . $this->Form->submit('hide-16.png', [
                        'alt' => 'フォロー解除',
                        'title' => 'フォロー解除'
                    ]) . $this->Form->end();
                } else {
                    $unfollow_button = '';
                }

                echo $this->Html->tableCells([
                    [
                        $fullname . $this->Html->link('@' . $username, [
                            'controller' => 'Users',
                            'action' => 'view',
                            $username
                        ]),
                        $created,
                        $unfollow_button
                    ]
                ]);
            }
            print("</table><br />\n");
        ?>
        <?php endif; ?>
    </div>
    <?php if ($hasfollowings): ?>
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

