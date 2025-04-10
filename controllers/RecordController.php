<?php

class RecordController extends MiniEngine_Controller 
{
    public function indexAction()
    {
        $year = filter_input(INPUT_GET, 'year' ,FILTER_SANITIZE_STRING) ?? null;
        $election = filter_input(INPUT_GET, 'election' ,FILTER_SANITIZE_STRING) ?? null;
        $area = filter_input(INPUT_GET, 'area' ,FILTER_SANITIZE_STRING) ?? null;
        $candidate = filter_input(INPUT_GET, 'candidate', FILTER_SANITIZE_STRING) ?? null;
        $serial = filter_input(INPUT_GET, 'serial', FILTER_SANITIZE_STRING) ?? 1;
        $limit = filter_input(INPUT_GET, 'limit', FILTER_SANITIZE_STRING) ?? 100;
        $page = filter_input(INPUT_GET, 'page', FILTER_SANITIZE_STRING) ?? 1;

        if (is_null($year) or is_null($election)) {
            header('HTTP/1.1 400 Bad Request');
            echo "<h1>400 Bad Request</h1>";
            echo "<p>Need at least year, election, candidate</p>";
            exit;
        }

        $this->view->year = $year;
        $this->view->election = $election;
        $this->view->area = $area;
        $this->view->candidate = $candidate;
        $this->view->serial= $serial;
        $this->view->limit = $limit;
        $this->view->page = $page;

        $breadcrumb_root = [
            ['text' => 'Home', 'url' => '/'],
            ['text' => '依選舉查詢', 'url' => '/election/year'],
        ];
        if (isset($area)) {
            $breadcrumbs = [
                ['text' => $year . '年度', 'url' => "/election/election?year={$year}"],
                ['text' => $election, 'url' => "/election/area?year={$year}&election={$election}"],
                ['text' => $area, 'url' => "/election/candidate?year={$year}&election={$election}&area={$area}"],
                ['text' => $candidate],
            ];
        } else {
            $breadcrumbs = [
                ['text' => $year . '年度', 'url' => "/election/election?year={$year}"],
                ['text' => $election, 'url' => "/election/area?year={$year}&election={$election}"],
                ['text' => $candidate],
            ];
        }
        $this->view->breadcrumbs = array_merge($breadcrumb_root, $breadcrumbs);
    }
}
