<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Vendor $vendor
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $vendor->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Vendor'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="vendor form content">
            <?= $this->Form->create($vendor) ?>
            <fieldset>
                <legend><?= __('Edit Vendor') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('logo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
