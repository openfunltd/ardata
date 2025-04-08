<?php
$year = $this->year;
$election = $this->election;
$area = $this->area;

$paths = Query::getElectionPaths($year, $election, $area);
$candidates = Query::getElectionCandidates($paths);
$candidates = array_map(function ($candidate) use ($year, $election, $area){
    if (is_null($area)) {
        $next_url = sprintf("/record?year=%s&election=%s&candidate=%s", $year, $election, $candidate);
    } else {
        $next_url = sprintf("/record?year=%s&election=%s&area=%s&candidate=%s", $year, $election, $area, $candidate);
    }
    return (object) [
        'name' => $candidate,
        'next_url' => $next_url,
    ];
}, $candidates);
?>
<?= $this->partial('common/header') ?>
<div>擬參選人/政黨：</div>
<?php foreach ($candidates as $candidate) { ?>
  <div>
    <a href="<?= $this->escape($candidate->next_url) ?>"><?= $this->escape($candidate->name) ?></a>
  </div>
<?php } ?>
<?= $this->partial('common/footer') ?>
