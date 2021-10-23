<?php
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=0: */
/**
 *
 */
?>
<div class="users index content">
<form action="/db/tables" method="post">
<div class="users">
  <div class="row">
    <div class="column column-25">
  <select id="dbname" name="dbname">
<?php foreach ($dbs as $key => $db): ?>
    <option value="<?= $dbs[$key]['Database'] ?>"
      <?php if ($dbs[$key]['Database'] == $dbName): ?>
        selected="selected"
      <?php endif ?>
    ><?= $dbs[$key]['Database'] ?></option>
<?php endforeach ?>
  </select>
    </div>
    <div class="column column-20">
      <input type="submit" name="DB" value="選択">
    </div>
    <?= $this->element('csrf') ?>
  </div>
</div>
</form>

    <h4>SHOW TABLE STATUS FROM <?= $dbName ?>;</h4>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
          <td>view</td>
          <?php foreach ($info['status_head'] as $head): ?>
          <th><?= $head ?></th>
          <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($info['status'] as $item): ?>
                <tr>
                  <td><?= $this->Html->link('📄', ['controller' => $item['Name'], 'action' => 'view'], ['title' => 'show baked page']) ?></td>
                  <td><?= $this->Html->Link($item['Name'], ['action' => 'table', $item['Name'], $dbName], ['title' => 'show table define']) ?></td>
                  <td><?= $item['Comment'] ?></td>
                  <td align="right"><?= number_format($item['Rows']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
  <br />
</div>
