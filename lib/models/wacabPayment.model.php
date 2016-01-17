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
            5 => 'a.name',
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
            "SELECT count(*) FROM " . $this->table
        )->fetchField());

        $searchstring = '%' . $data['search']['value'] . '%';

        $results = $this->query(
            "SELECT p.*, a.name AS app_name FROM " . $this->table . " p LEFT JOIN wacab_apps a ON p.app_id = a.id
            WHERE p.order LIKE ? OR p.description LIKE ?
            ORDER BY " . $columns[intval($order['column'])] . " " . $this->escape($order['dir']) . "
            LIMIT " . intval($data['start']) . ", " . intval($data['length']), $searchstring, $searchstring

        );
        $results->fetchAll();


        $counts = $this->query(
            "SELECT COUNT(p.id) AS count, SUM(p.pay) AS sum FROM " . $this->table . " p LEFT JOIN wacab_apps a ON p.app_id = a.id
            WHERE p.order LIKE ? OR p.description LIKE ?", $searchstring, $searchstring
        )->fetchAssoc();

        $response['recordsFiltered'] = $counts['count'];
        $response['sum'] = $counts['sum'];

        foreach ($results AS $i => $result) {
            $response['data'][] = array(
                'Date' => $result['date'],
                'Before' => $result['before'],
                'Pay' => $result['pay'],
                'After' => $result['after'],
                'Order' => $result['order'],
                'App' => $result['app_id'],
                'Description' => $result['description'],
            );
        }
        return $response;
    }
}


//, SUM(p.pay) AS sum