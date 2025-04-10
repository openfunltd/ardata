<?php
$distinct_areas = $this->distinct_areas;
?>
<?= $this->partial('common/header') ?>
<?= $this->partial('partial/breadcrumb', ['breadcrumbs' => $this->breadcrumbs]) ?>
<div>請選擇縣市/選區：</div>
<?php foreach ($distinct_areas as $area) { ?>
  <div>
    <a href="<?= $this->escape($area->next_url) ?>"><?= $this->escape($area->name) ?></a>
  </div>
<?php } ?>
<?= $this->partial('common/footer') ?>
