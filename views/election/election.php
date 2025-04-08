<?php
$year = $this->year;
$ret = Elastic::dbQuery("/{prefix}election/_search", 'GET', json_encode([
    'size' => 0,
    'aggs' => [
        'desired_year' => [
            'filter' => [
                'term' => [
                    'electionYear.keyword' => $year,
                ],
            ],
            'aggs' => [
                'distinct_elections' => [
                    'terms' => [
                        'field' => 'electionName.keyword',
                        'size' => 100,
                    ],
                ],
            ],
        ],
    ],
]));

$distinct_elections = $ret->aggregations->desired_year->distinct_elections->buckets;
$distinct_elections = array_map(function ($election) {
    return $election->key;
}, $distinct_elections);
?>
<?= $this->partial('common/header') ?>
<div>請選擇選舉：</div>
<?php foreach ($distinct_elections as $election) { ?>
  <div>
    <a href="/election/area?year=<?= $this->escape($year) ?>&election=<?= $this->escape($election) ?>">
      <?= $this->escape($election) ?>
    </a>
  </div>
<?php } ?>
<?= $this->partial('common/footer') ?>
