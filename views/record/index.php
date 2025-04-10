<?php
$year = $this->year;
$election = $this->election;
$area= $this->area;
$candidate = $this->candidate;
$limit = $this->limit;
$page = $this->page;
$serial = $this->serial;

$elections = Query::getElections($year, $election, $area);
$records = Query::getRecords($elections, $serial, $candidate, $limit, $page);
$serials = [];
foreach ($elections as $e) {
    $serials[] = $e->_source->yearOrSerial;
}

$total = $records->total;
$rows = $records->rows;

$fields = [
    '序號', '擬參選人／政黨', '選舉名稱', '申報序號／年度', '交易日期', '收支科目', '捐贈者／支出對象', '身分證／統一編號',
    '收入金額', '支出金額', '捐贈方式', '存入專戶日期', '返還/繳庫', '支出用途', '金錢類', '地址', '聯絡電話',
    '應揭露之支出對象', '支出對象之內部人員姓名', '支出對象之內部人員職稱', '政黨之內部人員姓名', '政黨之內部人員職稱',
    '關係', '更正註記', '資料更正日期',
];

$serial_html = '';
foreach ($serials as $idx => $s) {
    if ($idx != 0) {
        $serial_html .= ' | ';
    }
    if ($s == $serial) {
        $serial_html .= '<span class="fw-bold">' . FilingSerial::toZh($s) .'</span>';
    } else {
        $serial_html .= '<span>' . FilingSerial::toZh($s) .'</span>';
    }
}

?>
<style>
  .font-size-small {
    font-size: 10px !important;
  }
</style>
<?= $this->partial('common/header') ?>
<div class="container">
  <div class="row">
    <?= $this->escape($candidate) ?>
    <?php if (isset($area)) { ?>
      | <?= $this->escape($area) ?>
    <?php } ?>
    | <?= $this->escape($election) ?>

  </div>
  <div class="row">
    <p class="px-0 my-0">申報序號：<?= $serial_html ?></p>
  </div>
  <div class="row">
    每頁 <?= $this->escape($limit) ?> 筆
    | 第 <?= $this->escape($page) ?> 頁
    | 共 <?= $this->escape($total) ?> 筆
  </div>
  <div class="row">
    <table class="table table-striped table-bordered table-sm">
      <thead>
        <tr>
          <?php foreach ($fields as $field) { ?>
            <th class="font-size-small" scope="col"><?= $this->escape($field) ?></th>
          <?php } ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($rows as $row) { ?>
          <tr>
            <?php foreach ($fields as $field) { ?>
              <td class="font-size-small"><?= $this->escape($row->{$field}) ?></th>
            <?php } ?>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->partial('common/footer') ?>
