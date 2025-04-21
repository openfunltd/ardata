<?php

class ElectionController extends MiniEngine_Controller
{
    public function indexAction()
    {
        $limit = filter_input(INPUT_GET, 'limit' ,FILTER_SANITIZE_STRING) ?? 10;
        $page = filter_input(INPUT_GET, 'page' ,FILTER_SANITIZE_STRING) ?? 1;

        $data = self::requestData($limit, $page);

        $this->view->data = $data;
    }

    private static function requestData($limit, $page)
    {
        $query = self::buildQuery($limit, $page);
        $ret = Elastic::dbQuery("/{prefix}election/_search", 'GET', json_encode($query));
        return self::transformData($ret);
    }

    private static function buildQuery($limit, $page)
    {
        $query = (object) [
            "from" => ($page - 1) * $limit,
            "size" => $limit,
            "aggs" => (object) [],
        ];

        foreach (self::AGG_FIELDS as $variable => $field) {
            $query->aggs->{$variable . '_option'} = [
                'terms' => [
                    'field' => $field,
                    'size' => 1000,
                    'order' => ['_key' => 'desc'],
                ],
            ];
        }

        return $query;
    }

    private static function transformData($ret)
    {
        $data = (object)[
            'filters' => (object) [],
            'rows' => (object) [],
        ];

        $aggs = $ret->aggregations;
        foreach (self::AGG_FIELDS as $variable => $field) {
            $options = $aggs->{$variable . '_option'}->buckets;
            $options = array_map(function ($option) {
                $item = (object) [];
                $item->key = $option->key;
                $item->count = $option->doc_count;
                return $item;
            }, $options);
            $options = array_filter($options, function ($option) {
                return $option->key != '';
            });
            $data->filters->{$variable . '_options'} = $options;
        }

        $rows = $ret->hits->hits;
        $rows = array_map(function ($row) {
            return $row->_source;
        }, $rows);
        $data->rows = $rows;

        return $data;
    }

    const AGG_FIELDS = [
        'year' => 'electionYear.keyword',
        'election' => 'electionName.keyword',
        'area' => 'electionArea.keyword',
        'declare_serial' => 'yearOrSerial',
    ];
}
