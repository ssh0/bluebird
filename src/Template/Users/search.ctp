<div id="content-full">
    <h2> 友だちを見つけて、フォローしましょう！</h2>
    <h4>Bluebirdに登録済みの友だちを検索できます。</h4></br>
    <div class="row">
        <?= $this->Form->create(null, [
            'url' => [
                'controller' => 'Users',
                'action' => 'search'
            ]
        ]) ?>
        <?= $this->Form->input('search_query', [
            'label' => '誰を検索しますか？',
            'placeholder' => 'ユーザ名や名前で検索'
        ]) ?>
        <?= $this->Form->button(__('検索')); ?>
        <?= $this->Form->end() ?>
    </div>
</div>

