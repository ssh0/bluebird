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
                        $username = $user->username;
                        $fullname = $user->fullname;
                        /* 日本時間(日付も表示)で表示 */
                        $created = $user->created->i18nFormat(
                            'Y年M月d日 HH時mm分ss秒',
                            'Asia/Tokyo',
                            'ja-JP'
                        );
                        /* -> 2016年8月29日 21時42分55秒 */

                        // create follow button
                        if (! $isAuthorized) {
                            $follow_button = '';
                        } else {
                            $isFollowedAlready = false;
                            foreach ($user->follows_to as $user_followed) {
                                if ($user_followed->from_user_id == $authUserId) {
                                    $isFollowedAlready = true;
                                    break;
                                }
                            }
                            if ($isFollowedAlready) {
                                $follow_button = '既にフォローしています。';
                            } else {
                                $follow_button = $this->Form->create(null, [
                                    'url' => [
                                        'controller' => 'Follows',
                                        'action' => 'addFollow',
                                        $user->id
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
    <?php if ($hasResults): ?>
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

