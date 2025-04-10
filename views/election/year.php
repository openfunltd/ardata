<?php
$ret = Elastic::dbQuery("/{prefix}election/_search", 'GET', json_encode([
    'size' => 0,
    'aggs' => [
        'distinct_years' => [
            'terms' => [
                'field' => 'electionYear.keyword',
                'size' => 100,
                'order' => [
                    '_key' => 'desc'
                ],
            ],
        ],
    ],
]));

$distinct_years = $ret->aggregations->distinct_years->buckets;
$distinct_years = array_map(function ($year) {
    return $year->key;
}, $distinct_years);
?>
<?= $this->partial('common/header') ?>
<?= $this->partial('partial/breadcrumb', ['breadcrumbs' => $this->breadcrumbs]) ?>
<div>請選擇選舉年度：</div>
<?php foreach ($distinct_years as $year) { ?>
  <div>
    <a href="/election/election?year=<?= $this->escape($year) ?>"><?= $this->escape($year) ?></a>
  </div>
<?php } ?>
<?= $this->partial('common/footer') ?>
