<?= $this->element('sidebar-profile'); ?>
<div id="content">
    <div class="row">
        <?php if (! $hasfollowings): ?>
            <h3>まだ誰もフォローしていません。</h3>
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
                        'alt' => 'フォロー解除'
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
        <?= $this->Paginator->numbers() ?>
        <?php endif; ?>
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->next('Next »') ?>
    </div>
</div>

