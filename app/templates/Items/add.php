<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item $item
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Items'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="items form content">
            <?= $this->Form->create($item) ?>
            <fieldset>
                <legend><?= __('Add Item') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('vendor_id', ['options' => $vendors, 'empty' => true]);
                    echo $this->Form->control('type_id', ['options' => $types, 'empty' => true]);
                    echo $this->Form->control('serial_number');
                    echo $this->Form->control('price');
                    echo $this->Form->control('weight');
                    echo $this->Form->control('color');
                    echo $this->Form->control('release_date', ['empty' => true]);
                    echo $this->Form->control('photo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
