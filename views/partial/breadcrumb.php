<?php
$breadcrumbs = $this->breadcrumbs;
?>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <?php foreach ($breadcrumbs as $idx => $crumb) { ?>
      <li class="breadcrumb-item <?= $this->if(($idx + 1 == count($breadcrumbs)), 'active') ?>" aria-current="page">
        <?php if (isset($crumb['url'])) { ?>
          <a href="<?= $this->escape($crumb['url']) ?>"><?= $this->escape($crumb['text']) ?></a>
        <?php } else { ?>
          <?= $this->escape($crumb['text']) ?>
        <?php } ?>
      </li>
    <?php } ?>
  </ol>
</nav>
