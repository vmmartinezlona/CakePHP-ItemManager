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
            <?= $this->Html->link(__('Edit Vendor'), ['action' => 'edit', $vendor->vendor_id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Vendor'), ['action' => 'delete', $vendor->vendor_id], ['confirm' => __('Are you sure you want to delete # {0}?', $vendor->vendor_id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Vendors'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Vendor'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="vendors view content">
            <h3><?= h($vendor->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($vendor->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Logo') ?></th>
                    <td><?= $this->Html->image('uploads/vendors/' . $vendor->logo, ['class' => 'index-images', 'escape' => false]) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
