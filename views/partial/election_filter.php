<?php
$filters = $this->filters;
$year_options = $filters->year_options;
$election_options = $filters->election_options;
$area_options = $filters->area_options;
$declare_serial_options = $filters->declare_serial_options;
?>
<style>
  .filter.card-body {
    max-height: 200px; 
    overflow-y: auto;
  }
</style>
<!-- 篩選 -->
<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title fw-bold">篩選</h3>
  </div>
  <div class="card-body">
    <!-- 選舉年度 -->
    <div class="form-group">
      <label>選舉年度</label>
      <div class="card">
        <div class="card-body filter py-1">
          <?php foreach ($year_options as $option) { ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox">
              <label class="form-check-label"><?= $this->escape($option->key) ?></label>
              <span class="badge bg-success"><?= $this->escape($option->count) ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- end of 選舉年度 -->
    
    <!-- 選舉名稱 -->
    <div class="form-group">
      <label>選舉名稱</label>
      <div class="card">
        <div class="card-body filter py-1">
          <?php foreach ($election_options as $option) { ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox">
              <label class="form-check-label"><?= $this->escape($option->key) ?></label>
              <span class="badge bg-success"><?= $this->escape($option->count) ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- end of 選舉名稱 -->

    <!-- 縣市/選區 -->
    <div class="form-group">
      <label>縣市/選區</label>
      <div class="card">
        <div class="card-body filter py-1">
          <?php foreach ($area_options as $option) { ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox">
              <label class="form-check-label"><?= $this->escape($option->key) ?></label>
              <span class="badge bg-success"><?= $this->escape($option->count) ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- end of 縣市/選區 -->
    
    <!-- 申報序號 -->
    <div class="form-group">
      <label>申報序號</label>
      <div class="card">
        <div class="card-body filter py-1">
          <?php foreach ($declare_serial_options as $option) { ?>
            <div class="form-check">
              <input class="form-check-input" type="checkbox">
              <label class="form-check-label"><?= $this->escape($option->key) ?></label>
              <span class="badge bg-success"><?= $this->escape($option->count) ?></span>
            </div>
          <?php } ?>
        </div>
      </div>
    </div>
    <!-- end of 申報序號 -->
    
  </div>
</div>
<!-- end of 篩選 -->
