<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Total items</th>
                <th><?= $itemsCount ?></th>
            </tr>
            <tr>
                <th>Average price</th>
                <th>$<?= $this->Number->format($averagePrice) ?></th>
            </tr>
        </thead>
    </table>
</div>

<br><br><br>

<h3>Items percents:</h3>
<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('percent') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($itemsPercent as $key => $value): ?>
            <tr>
                <td><?= h($key) ?></td>
                <th><?= $this->Number->toPercentage($value);?></th>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br><br><br>

<h3>Last items:</h3>
<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th><?= $this->Paginator->sort('name') ?></th>
                <th><?= $this->Paginator->sort('type_id') ?></th>
                <th><?= $this->Paginator->sort('price') ?></th>
                <th><?= $this->Paginator->sort('photo') ?></th>
                <th><?= $this->Paginator->sort('vendor_id') ?></th>
                <th><?= $this->Paginator->sort('vendor_logo') ?></th>   
                <th><?= $this->Paginator->sort('tag_id') ?></th>             
            </tr>
        </thead>
        <tbody>
        <?php foreach($lastItems as $item): ?>
          <tr>
                <td><?= h($item->name) ?></td>
                <td><?= $item->has('Types') ? $this->Html->link($item->Types['name'], ['controller' => 'types', 'action' => 'view', $item->Types['type_id']]) : 'N/A' ?></td>
                <td>$<?= $this->Number->format($item->price) ?></td>
                <td><?= $this->Html->image('uploads/items/' . $item->photo, ['class' => 'index-images', 'escape' => false]) ?></td>
                <td><?= $item->has('Vendors') ? $this->Html->link($item->Vendors['name'], ['controller' => 'vendors', 'action' => 'view', $item->Vendors['vendor_id']]) : 'N/A' ?></td>
                <td><?= $this->Html->image('uploads/vendors/' . $item->Vendors['logo'], ['class' => 'index-images', 'escape' => false]) ?></td>
                <td><?= h($item->Tags['name']) ?></td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
