<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Type $type
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Type'), ['action' => 'edit', $type->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Type'), ['action' => 'delete', $type->id], ['confirm' => __('Are you sure you want to delete # {0}?', $type->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Type'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Type'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="type view content">
            <h3><?= h($type->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($type->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($type->id) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Items') ?></h4>
                <?php if (!empty($type->items)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Vendor Id') ?></th>
                            <th><?= __('Type Id') ?></th>
                            <th><?= __('Serial Number') ?></th>
                            <th><?= __('Price') ?></th>
                            <th><?= __('Weight') ?></th>
                            <th><?= __('Color') ?></th>
                            <th><?= __('Release Date') ?></th>
                            <th><?= __('Photo') ?></th>
                            <th><?= __('Tags') ?></th>
                            <th><?= __('Created Date') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($type->items as $items) : ?>
                        <tr>
                            <td><?= h($items->id) ?></td>
                            <td><?= h($items->name) ?></td>
                            <td><?= h($items->vendor_id) ?></td>
                            <td><?= h($items->type_id) ?></td>
                            <td><?= h($items->serial_number) ?></td>
                            <td><?= h($items->price) ?></td>
                            <td><?= h($items->weight) ?></td>
                            <td><?= h($items->color) ?></td>
                            <td><?= h($items->release_date) ?></td>
                            <td><?= h($items->photo) ?></td>
                            <td><?= h($items->tags) ?></td>
                            <td><?= h($items->created_date) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Items', 'action' => 'view', $items->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Items', 'action' => 'edit', $items->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Items', 'action' => 'delete', $items->id], ['confirm' => __('Are you sure you want to delete # {0}?', $items->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
