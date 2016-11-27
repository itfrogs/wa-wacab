<?php
class wacabPaymentModel extends waModel
{
    protected $table = 'wacab_payment';

    public function getDataTable($data)
    {
        $columns = array(
            0 => 'p.date',
            1 => 'p.before',
            2 => 'p.pay',
            3 => 'p.after',
            4 => 'p.order',
            5 => 'a.app_id',
            6 => 'p.description',
        );

        $response = array();
        $response['data'] = array();
        $response['status'] = 'ok';
        foreach ($data AS $key => $value) {
            $response[$key] = $value;
        }

        $order = reset($data['order']);

        if (empty($order['column'])) {

        }

        $response['recordsTotal'] = intval($this->query(
            "SELECT count(*) FROM " . $this->table . " "
        )->fetchField());

        $searchstring = '%' . $data['search']['value'] . '%';

        $time_interval = ' AND ( ';

        if (strlen($data['startdate']) > 10) {
            $time_interval .= ' p.date >= "' . $data['startdate'] . '" ';
        }
        else {
            $time_interval .= ' 1 ';
        }

        if (strlen($data['enddate']) > 10) {
            $time_interval .= ' AND p.date < "' . $data['enddate'] . '" ';
        }
        else {
            $time_interval .= ' AND 1 ';
        }

        $time_interval .= ' ) ';

        if ($data['no_minus'] == 1) {
            $no_minus = ' AND p.pay >= 0 ';
        }
        else {
            $no_minus = '';
        }

        //var_dump($time_interval);

        $results = $this->query(
            "SELECT p.*, a.app_id AS app_name FROM " . $this->table . " p LEFT JOIN wacab_apps a ON p.apps_id = a.id "
            ." WHERE (p.order LIKE ? OR p.description LIKE ?) " . $time_interval . $no_minus
            ." ORDER BY " . $columns[intval($order['column'])] . " " . $this->escape($order['dir'])
            ." LIMIT " . intval($data['start']) . ", " . intval($data['length']), $searchstring, $searchstring

        );
        $results->fetchAll();


        $counts = $this->query(
            "SELECT COUNT(p.id) AS count, SUM(p.pay) AS sum FROM " . $this->table
            ." p LEFT JOIN wacab_apps a ON p.apps_id = a.id "
            ."WHERE (p.order LIKE ? OR p.description LIKE ?) " . $time_interval . $no_minus, $searchstring, $searchstring
        )->fetchAssoc();

        $response['recordsFiltered'] = $counts['count'];
        $response['sum'] = round($counts['sum'], 2);

        foreach ($results AS $i => $result) {
            $response['data'][] = array(
                'Date' => $result['date'],
                'Before' => $result['before'],
                'Pay' => $result['pay'],
                'After' => $result['after'],
                'Order' => $result['order'],
                'App' => $result['apps_id'],
                'Description' => $result['description'],
            );
        }
        return $response;
    }
}


//, SUM(p.pay) AS sum