<div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Total items</th>
                <th><?= $itemsCount ?></th>
            </tr>
            <tr>
                <th>Average price</th>
                <th><?= $averagePrice ?></th>
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
                <td><?= h($value) ?>%</td>
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
                <th><?= $this->Paginator->sort('vendor_id') ?></th>
                <th><?= $this->Paginator->sort('type_id') ?></th>
                <th><?= $this->Paginator->sort('price') ?></th>
                <th><?= $this->Paginator->sort('photo') ?></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($lastItems as $item): ?>
          <tr>
                <td><?= h($item->name) ?></td>
                <td><?= $item->has('Vendors') ? $this->Html->link($item->Vendors['name'], ['controller' => 'vendors', 'action' => 'view', $item->Vendors['vendor_id']]) : 'N/A' ?></td>
                <td><?= $item->has('Types') ? $this->Html->link($item->Types['name'], ['controller' => 'types', 'action' => 'view', $item->Types['type_id']]) : 'N/A' ?></td>
                <!-- Vendor photo -->
                <td><?= $this->Number->format($item->price) ?></td>
                <td><?= h($item->photo) ?></td>
                <!-- tags -->
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
</div>
