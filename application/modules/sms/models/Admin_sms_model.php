<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Admin_sms_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_sms_data($params) {
        $columns = implode(', ', $params['col-display']) . ', ' . $params['id-table'];

        //$join = $params['join'];

        $sql  = "SELECT {$columns} FROM {$params['table']}";


        $data = $this->db->query($sql);

        $rowCount = $data->num_rows();

        $data->free_result();

        // pengkondisian aksi seperti next, search dan limit
        $columnd = $params['col-display'];
        $count_c = count($columnd);

        // search
        $search = $params['search']['value'];

        /**
         * Search Global
         * pencarian global pada pojok kanan atas
         */
        $where = '';
        if ($search != '') {
            for ($i=0; $i < $count_c ; $i++) {
                $where .= $columnd[$i] .' LIKE "%'. $search .'%"';

                if ($i < $count_c - 1) {
                    $where .= ' OR ';
                }
            }
        }

        /**
         * Search Individual Kolom
         * pencarian dibawah kolom
         */
        for ($i=0; $i < $count_c; $i++) {
            $searchCol = $params['columns'][$i]['search']['value'];
            if ($searchCol != '') {
                $where = $columnd[$i] . ' LIKE "%' . $searchCol . '%" ';
                break;
            }
        }

        /**
         * pengecekan Form pencarian
         * pencarian aktif jika ada karakter masuk pada kolom pencarian.
         */
        if ($where != '') {
            $sql .= " WHERE " . $where;

        }

        // sorting
        $sql .= " ORDER BY {$columnd[$params['order'][0]['column']]} {$params['order'][0]['dir']}";

        // limit
        $start  = $params['start'];
        $length = $params['length'];

        $sql .= " LIMIT {$start}, {$length}";

        $list = $this->db->query($sql);

        return $list;
    }
}
