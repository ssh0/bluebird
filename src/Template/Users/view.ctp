<?php if ($user_exist): ?>
    <?php $sidebar = $this->cell('Sidebar::display', [$username]); ?>
    <?= $sidebar ?>
    <div id="content">
        <div class="row">
            <?php if (! $tweets_exist): ?>
                <h3>ツイートはありません。</h3>
            <?php else: ?>
                <?php $auth_user = $this->request->session()->read('Auth.User'); ?>
                <div class="tweets">
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
                </div>
            <?php endif ?>
            </div>
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
<?php else: ?>
<div id="content-full">
    <h3>存在しないユーザ名です。</h3>
</div>
<?php endif; ?>
