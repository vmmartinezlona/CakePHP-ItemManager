<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<!-- <?= $this->Html->script('jquery.min.js') ?>
 -->
 <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<div class="users index content">
    <?= $this->Html->link(__('New User'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Users') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('is_active') ?></th>
                    <th><?= $this->Paginator->sort('isAdmin') ?></th>

                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= h($user->username) ?></td>
                    <td><?= h($user->email) ?></td>
                    <td><?= $user->isActive ? 
                        $this->Form->button('Yes', [
                            'class' => 'yes-btn ', 
                            'onclick' => 'changeUserStatus(' . $user->id . ', "active")']) : 
                        $this->Form->button('No', ['onclick' => 'changeUserStatus(' . $user->id . ', "active")']) ?></td>
                    <td><?= $user->is_admin ? 
                        $this->Form->button('Yes', [
                            'class' => 'yes-btn',
                            'onclick' => 'changeUserStatus(' . $user->id . ', "admin")']) : 
                        $this->Form->button('No', ['onclick' => 'changeUserStatus(' . $user->id . ', "admin")']) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
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

<script>

    function changeUserStatus(userId, action) {
        console.log(userId, action);
        var targetUrl =  '<?= $this->Url->build('/users/index', []) ?>';
        var resultUrl = window.location.href + `?id=${userId}&action=${action}`;
        $.ajax({
            url: targetUrl,
            type: 'GET',
            contentType: 'application/json; charset=utf-8',
            data: { "id": userId, "action": action},
            success: function(data){
                console.log('success');
                window.location.replace(resultUrl);
            }
        });
    }  
</script>