<h1>
    Items tagged with
    <?= $this->Text->toList(h($tags), 'or') ?>
</h1>

<section>
<?php foreach ($items as $item): ?>
    <article>
        <!-- Use the HtmlHelper to create a link -->
        <h4><?= $this->Html->link(
            $item->title,
            ['controller' => 'Items', 'action' => 'view', $item->id]
        ) ?></h4>
        <span><?= h($item->created) ?></span>
    </article>
<?php endforeach; ?>
</section>