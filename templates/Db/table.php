<?php
/* vim: set expandtab tabstop=2 shiftwidth=2 softtabstop=0: */
/**
 *
 */
?>
<div class="users index content">
  <h3><a href="/db/tables/<?= $dbName ?>"><?= $dbName ?></a> <?= $tableName ?></h3>
  <h4>SHOW FULL COLUMNS FROM <?= $tableName ?>;</h4>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <?php foreach ($info['columns_head'] as $head): ?>
          <th><?= $head ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($info['columns'] as $item): ?>
        <tr>
          <?php foreach ($info['columns_head'] as $head): ?>
          <th><?= $item[$head] ?></th>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br />

  <h4>SHOW INDEX FROM <?= $tableName ?>;</h4>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <?php foreach ($info['index_head'] as $head): ?>
          <th><?= $head ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($info['index'] as $item): ?>
        <tr>
          <?php foreach ($info['index_head'] as $head): ?>
          <th><?= $item[$head] ?></th>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br />

  <h4>SHOW TABLE STATUS WHERE Name='<?= $tableName ?>';</h4>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <?php foreach ($info['status_head'] as $head): ?>
          <th><?= $head ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($info['status'] as $item): ?>
        <tr>
          <?php foreach ($info['status_head'] as $head): ?>
          <th><?= $item[$head] ?></th>
          <?php endforeach; ?>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
  <br />

  <h4>SHOW CREATE TABLE <?= $tableName ?>;</h4>
  <pre>
<?= $info['create'][0]['Create Table'] ?>
  </pre>
</div>
<br />
<br />
