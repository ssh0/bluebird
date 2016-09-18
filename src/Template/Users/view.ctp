<?= $this->append('script', $this->Html->script('remove_tweet.js')) ?>
<?php if (! $userExist): ?>
    <div id="content-full">
        <h3>存在しないユーザ名です。</h3>
    </div>
<?php else: ?>
    <?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
    <?= $sidebar ?>
    <div id="content">
        <div class="row">
            <?php if (! $tweetsExist): ?>
                <h3>ツイートはありません。</h3>
            <?php else: ?>
                <?php $authUser = $this->request->session()->read('Auth.User'); ?>
                <div class="tweets">
                    <?php foreach ($tweets as $tweet): ?>
                        <?= $this->element('tweets', [
                            'authUser' => $authUser,
                            'tweetId' => $tweet->tweet->id,
                            'username' => $tweet->username,
                            'fullname' => $tweet->fullname,
                            'content' => $tweet->tweet->content,
                            'timestamp' => $tweet->tweet->timestamp
                        ]); ?>
                    <?php endforeach ?>
                    <div id="pagination">
                        <?= $this->Paginator->prev() ?>
                        <?= $this->Paginator->next() ?>
                        <div class="page_nums"><?= $this->Paginator->numbers() ?></div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
<?php endif; ?>
