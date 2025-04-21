<?php
$rows = $this->rows;
?>
<!-- 資料 -->
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title fw-bold">資料</h3>
  </div>
  <div class="card-body">
    <table class="table table-bordered table-sm table-hover">
      <thead>
        <tr>
          <th>選舉名稱</th>
          <th>縣市別</th>
          <th>申報序號</th>
          <th>查看會計報告</th>
          <th>會計報告書下載</th>
          <th>收支結算表下載</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row) { ?>
        <tr>
          <td><?= $this->escape($row->electionName) ?></td>
          <td><?= $this->escape($row->electionArea) ?></td>
          <td><?= $this->escape($row->yearOrSerial) ?></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
