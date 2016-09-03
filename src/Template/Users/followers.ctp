<div id="content">
    <div class="row">
    <?= $this->element('sidebar-profile'); ?>
        <?php if (! $hasfollowers): ?>
            <h3>まだフォロワーはいません。</h3>
        <?php else: ?>
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Name', 'Created']);
            foreach ($followers as $follower) {
                $username = $follower->username;
                $fullname = $follower->fullname;
                /* 日本時間で表示 */
                $created = $follower->created->nice('Asia/Tokyo', 'ja-JP');
                /* 現在との相対的な時間 */
                /* $created = $follower->created->timeAgoInWords([ */
                /*     'accuracy' => 'minute' */
                /* ]); */
                /* $created = 'dummy'; */
                echo $this->Html->tableCells([
                    ["$fullname" . $this->Html->link('@' . $username, [
                        'controller' => 'Users',
                        'action' => 'view',
                        $username
                    ]),
                    "$created"]
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

