<?php
$data = $this->data;
$filters = $data->filters;
$rows = $data->rows;
?>
<?= $this->partial('common/header') ?>
<div class="content-header">
  <h1>選舉查詢</h1>
</div>
<div class="content px-2">
  <div class="container-fulid">
    <div class="row">
      <div class="col-md-3">
        <?= $this->partial('partial/election_filter', ['filters' => $filters]) ?>
      </div>
      <div class="col-md-9">
        <?= $this->partial('partial/election_table', ['rows' => $rows]) ?>
      </div>
    </div>
  </div>
</div>
<?= $this->partial('common/footer') ?>
<script src="/static/js/election_filter.js"></script>
