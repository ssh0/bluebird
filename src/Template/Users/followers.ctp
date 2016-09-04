<?= $this->element('sidebar-profile'); ?>
<div id="content">
    <div class="row">
        <?php if (! $hasfollowers): ?>
            <h3>まだフォロワーはいません。</h3>
        <?php else: ?>
            <h3><?= h($fullname) ?>は<?= $followers_num ?>人にフォローされています。</h3>
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Name', 'Created', '']);
            foreach ($followers as $follower) {
                $username = $follower->username;
                $fullname = $follower->fullname;
                /* 日本時間(日付も表示)で表示 */
                $created = $follower->created->i18nFormat(
                    'Y年M月d日 HH時mm分ss秒',
                    'Asia/Tokyo',
                    'ja-JP'
                );
                /* -> 2016年8月29日 21時42分55秒 */

                // create follow button
                if ($isAuthorized) {
                    $follow_button = $this->Form->create(null, [
                        'url' => [
                            'controller' => 'Follows',
                            'action' => 'addFollow',
                            $follower->id
                        ],
                        'onsubmit' => 'return confirm(
                            "このユーザーをフォローしますか?"
                        )' 
                    ]) . $this->Form->submit('plus-16.png', [
                        'alt' => 'フォロー追加'
                    ]) . $this->Form->end();
                } else {
                    $follow_button = '';
                }

                echo $this->Html->tableCells([
                    [
                        $fullname . $this->Html->link('@' . $username, [
                            'controller' => 'Users',
                            'action' => 'view',
                            $username
                        ]),
                        $created,
                        $follow_button
                    ]
                ]);
            }
            print("</table><br />\n");
        ?>
        <?php endif; ?>
        <?= $this->Paginator->numbers() ?>
    </div>
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->next('Next »') ?>
</div>

