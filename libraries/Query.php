<?php

class Query
{
    public static function getElectionCandidates($paths)
    {
        $filtered_data = [
            'filter' => [
                'bool' => [
                    'must' => [
                        ['terms' => ['path.keyword' => $paths]],
                    ],
                ],
            ],
            'aggs' => [
                'distinct_candidates' => [
                    'terms' => [
                        'field' => '擬參選人／政黨.keyword',
                        'size' => 100,
                    ],
                ],
            ],
        ];
        $ret = Elastic::dbQuery("/{prefix}record/_search", 'GET', json_encode([
            'size' => 0,
            'aggs' => ['filtered_data' => $filtered_data],
        ]));

        $candidates = $ret->aggregations->filtered_data->distinct_candidates->buckets;
        $candidates = array_map(function ($candidate) {
            return $candidate->key;
        }, $candidates);

        return $candidates;
    }

    public static function getElectionPaths($year, $election, $area)
    {
        $query = [
            'bool' => [
                'must' => [
                    ['term' => ['electionYear.keyword' => $year]],
                    ['term' => ['electionName.keyword' => $election]],
                ],
            ],
        ];
        if (isset($area)) {
            $query['bool']['must'][] = ['term' => ['electionArea.keyword' => $area]];
        }

        $ret = Elastic::dbQuery("/{prefix}election/_search", 'GET', json_encode([
            'size' => 100,
            'query' => $query,
        ]));

        $elections = $ret->hits->hits;
        $paths = array_map(function ($election) {
            return $election->_source->path;
        }, $elections);

        return $paths;
    }

    public static function getElectionAreas($year, $election)
    {
        $filtered_data = [
            'filter' => [
                'bool' => [
                    'must' => [
                        ['term' => ['electionYear.keyword' => $year]],
                        ['term' => ['electionName.keyword' => $election]],
                    ],
                ],
            ],
            'aggs' => [
                'distinct_areas' => [
                    'terms' => [
                        'field' => 'electionArea.keyword',
                        'size' => 100,
                    ],
                ],
            ],
        ];
        $ret = Elastic::dbQuery("/{prefix}election/_search", 'GET', json_encode([
            'size' => 0,
            'aggs' => ['filtered_data' => $filtered_data],
        ]));

        $distinct_areas = $ret->aggregations->filtered_data->distinct_areas->buckets;
        $distinct_areas = array_map(function ($area) use ($year, $election) {
            $next_url = sprintf("/election/candidate?year=%s&election=%s&area=%s", $year, $election, $area->key);
            return (object) [
                'name' => $area->key,
                'next_url' => $next_url,
            ];
        }, $distinct_areas);

        return $distinct_areas;
    }
}
