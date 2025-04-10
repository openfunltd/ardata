<?php

class ElectionController extends MiniEngine_Controller
{
    public static $breadcrumb_root = [
        ['text' => 'Home', 'url' => '/'],
        ['text' => '依選舉查詢', 'url' => '/election/year'],
    ];

    public function yearAction()
    {
        $this->view->breadcrumbs = self::$breadcrumb_root;
    }

    public function electionAction()
    {
        $year = filter_input(INPUT_GET, 'year' ,FILTER_SANITIZE_STRING) ?? null;

        if (is_null($year)) {
            header('HTTP/1.1 400 Bad Request');
            echo "<h1>400 Bad Request</h1>";
            echo "<p>Need year</p>";
            exit;
        }

        $this->view->year = $year;
        $this->view->breadcrumbs = array_merge(self::$breadcrumb_root, [
            ['text' => $year . '年度'],
        ]);
    }

    public function areaAction()
    {
        $year = filter_input(INPUT_GET, 'year' ,FILTER_SANITIZE_STRING) ?? null;
        $election = filter_input(INPUT_GET, 'election' ,FILTER_SANITIZE_STRING) ?? null;

        if (is_null($year) or is_null($election)) {
            header('HTTP/1.1 400 Bad Request');
            echo "<h1>400 Bad Request</h1>";
            echo "<p>Need year and election</p>";
            exit;
        }

        $distinct_areas = Query::getElectionAreas($year, $election);

        //全國性選舉沒有 area 區分 example: 總統副總統選舉
        if (count($distinct_areas) == 1) {
           $this->redirect("/election/candidate?year={$year}&election={$election}"); 
        }

        $this->view->distinct_areas = $distinct_areas;
        $this->view->breadcrumbs = array_merge(self::$breadcrumb_root, [
            ['text' => $year . '年度', 'url' => "/election/election?year={$year}"],
            ['text' => $election],
        ]);
    }

    public function candidateAction()
    {
        $year = filter_input(INPUT_GET, 'year' ,FILTER_SANITIZE_STRING) ?? null;
        $election = filter_input(INPUT_GET, 'election' ,FILTER_SANITIZE_STRING) ?? null;
        $area = filter_input(INPUT_GET, 'area' ,FILTER_SANITIZE_STRING) ?? null;

        if (is_null($year) or is_null($election)) {
            header('HTTP/1.1 400 Bad Request');
            echo "<h1>400 Bad Request</h1>";
            echo "<p>Need at least year and election</p>";
            exit;
        }

        $this->view->year = $year;
        $this->view->election = $election;
        $this->view->area = $area;
        if (isset($area)) {
            $this->view->breadcrumbs = array_merge(self::$breadcrumb_root, [
                ['text' => $year . '年度', 'url' => "/election/election?year={$year}"],
                ['text' => $election, 'url' => "/election/area?year={$year}&election={$election}"],
                ['text' => $area],
            ]);
        } else {
            $this->view->breadcrumbs = array_merge(self::$breadcrumb_root, [
                ['text' => $year . '年度', 'url' => "/election/election?year={$year}"],
                ['text' => $election],
            ]);
        }
    }
}
