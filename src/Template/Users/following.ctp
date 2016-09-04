<?= $this->element('sidebar-profile'); ?>
<div id="content">
    <div class="row">
        <?php if (! $hasfollowings): ?>
            <h3>まだ誰もフォローしていません。</h3>
        <?php else: ?>
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Name', 'Last login']);
            foreach ($followings as $following) {
                $username = $following->username;
                $fullname = $following->fullname;
                /* 日本時間で表示 */
                $created = $following->created->nice('Asia/Tokyo', 'ja-JP');
                /* 現在との相対的な時間 */
                /* $created = $following->created->timeAgoInWords([ */
                /*     'accuracy' => 'minute' */
                /* ]); */
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
        <?= $this->Paginator->numbers() ?>
        <?php endif; ?>
    <?= $this->Paginator->prev('« Previous') ?>
    <?= $this->Paginator->next('Next »') ?>
    </div>
</div>

