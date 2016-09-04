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
                if (! $isAuthorized) {
                    $follow_button = '';
                } else {
                    foreach ($follower->follows_to as $user_followed) {
                        if ($user_followed->from_user_id == $auth_user_id) {
                            $isFollowedAlready = true;
                            break;
                        }
                        $isFollowedAlready = false;
                    }
                    if ($isFollowedAlready) {
                        $follow_button = '既にフォローしています。';
                    } else {
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
                            'alt' => 'フォロー追加',
                            'title' => 'フォロー追加'
                        ]) . $this->Form->end();
                    }
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
    </div>
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
</div>

