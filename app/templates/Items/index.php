<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Item[]|\Cake\Collection\CollectionInterface $items
 */
?>
<div class="items index content">
    <?php if(!$isAdmin){
        echo $this->Html->link(__('New Item'), ['action' => 'add'], ['class' => 'button float-right']);
        } 
    ?>
    <h3><?= __('Items') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('vendor_id') ?></th>
                    <th><?= $this->Paginator->sort('type_id') ?></th>
                    <th><?= $this->Paginator->sort('serial_number') ?></th>
                    <th><?= $this->Paginator->sort('price') ?></th>
                    <th><?= $this->Paginator->sort('weight') ?></th>
                    <th><?= $this->Paginator->sort('color') ?></th>
                    <th><?= $this->Paginator->sort('release_date') ?></th>
                    <th><?= $this->Paginator->sort('photo') ?></th>
                    <th><?= $this->Paginator->sort('created_date') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= h($item->name) ?></td>
                    <td><?= $item->has('Vendors') ? $this->Html->link($item->Vendors['name'], ['controller' => 'vendors', 'action' => 'view', $item->Vendors['vendor_id']]) : 'N/A' ?></td>
                    <td><?= $item->has('Types') ? $this->Html->link($item->Types['name'], ['controller' => 'types', 'action' => 'view', $item->Types['type_id']]) : 'N/A' ?></td>
                    <td><?= h($item->serial_number) ?></td>
                    <td><?= $this->Number->format($item->price) ?></td>
                    <td><?= $this->Number->format($item->weight) ?></td>
                    <td><?= h($item->color) ?></td>
                    <td><?= h($item->release_date) ?></td>
                    <td><?= h($item->photo) ?></td>
                    <td><?= h($item->created_date) ?></td>
                    <td><?= $this->Number->format($item->user_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $item->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $item->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $item->id], ['confirm' => __('Are you sure you want to delete # {0}?', $item->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
