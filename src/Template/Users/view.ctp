<?= $this->element('sidebar-profile'); ?>
<div id="content">
    <div class="row">
        <?php if (! $tweets_exist): ?>
            <h3>ツイートはありません。</h3>
        <?php else: ?>
            <?php
                $auth_user = $this->request->session()->read('Auth.User');
                echo PHP_EOL, '<table cellpadding="0" cellspacing="0" class="db-table">', PHP_EOL;
                echo $this->Html->tableHeaders(['Username', 'Content', 'Timestamp', 'delete']); ?>
            <?php foreach ($tweets as $tweet): ?>
                <?= $this->element('tweets', [
                    'auth_user' => $auth_user,
                    'tweet_id' => $tweet->tweet->id,
                    'username' => $tweet->username,
                    'fullname' => $tweet->fullname,
                    'content' => $tweet->tweet->content,
                    'timestamp' => $tweet->tweet->timestamp
                ]); ?>
            <?php endforeach ?>
        <?php print("</table><br />\n"); ?>
        <?php endif ?>
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

