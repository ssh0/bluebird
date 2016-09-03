<div id="content">
    <div class="row">
        <?php if (! $hasfollowings): ?>
            <h3>まだ誰もフォローしていません。</h3>
        <?php else: ?>
        <?php
            echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
            echo $this->Html->tableHeaders(['Name', 'Last login']);
            foreach ($followings as $following) {
                $user_id = $following->to;
                $username = $following->user->username;
                $fullname = $following->user->fullname;
                /* 日本時間で表示 */
                /* $created = $tweet->timestamp->nice('Asia/Tokyo', 'ja-JP'); */
                /* 現在との相対的な時間 */
                $created = $following->user->created->timeAgoInWords([
                    'accuracy' => 'minute'
                ]);
                echo $this->Html->tableCells([
                    ["$user_id : $fullname <a href=\"../users/$username\">@$username</a>",
                    "$created"]
                ]);
            }
            print("</table><br />\n");
        ?>
        <?php endif; ?>
    </div>
</div>
