<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index() {
        $this->inbox();

    }

    function inbox() {
        $data['title'] = 'DATA INBOX SMS';
        $data['extra_header'] = '<link rel="stylesheet"type="text/css" href="'.base_url().'plugins/dTables/media/css/dataTables.bootstrap.css" />';
        $data['extra_header'] = '<script type="text/javascript" src="'.base_url().'plugins/dTables/media/js/jquery.dataTables.min.js"></script>';
        //
        
        themes('admin','message/admin_message_view', $data);
    }

    function outbox() {
        $data['title'] = 'DATA OUTBOX SMS';
        $data['extra_header'] = '<link rel="stylesheet" href="'.base_url().'plugins/dTables/media/css/dataTables.bootstrap.css">';
        // $data['extra_header'] .= '<script type="text/javascript" src="'.base_url().'plugins/dTables/media/js/">';

        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="'.base_url().'plugins/dTables/extensions/responsive/css/responsive.bootstrap.css">';
        $data['extra_header'] .= '<script type="text/javascript" language="javascript" src="'.base_url().'plugins/dTables/extensions/responsive/js/dataTables.responsive.min.js"></script>
        ';

        $data['extra_footer'] = '<script type="text/javascript" src="'.base_url().'plugins/dTables/media/js/jquery.dataTables.min.js"></script>';
        $data['extra_footer'] = '<script type="text/javascript" src="'.base_url().'plugins/jQuery/jquery-3.2.1.min.js"></script>';

        themes('admin','message/admin_message_view', $data);

    }

    function get_data_inbox() {
        $params = isset($_POST) ? $_POST : array();
        $columns = array(
                    'sender',
                    'in_datetime',
                    'content',
                    'readed',
                    'replied',
                    'responded',
                );

        // search
        // if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
        //     $params['where_detail'] = "network_code LIKE '%".$this->db->escape_str($_POST['search']['value'])."%'
        //      OR member_name LIKE '%".$this->db->escape_str($_POST['search']['value'])."%'";
        // }

        $sort = '';
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }
        $params['sortname'] = rtrim($sort, ', ');
        $params['sortorder'] = '';
        $params['rp'] = isset($_POST['length']) ? $_POST['length'] : 10;
        // $params['page'] = isset($_POST['start']) ? $_POST['start']+1 : 1;
        $params['page'] = $_POST['start'] > 0 ? ($_POST['start']/$params['length'])+1 : 1;
        $params['table'] = 'message_in';
        $params['where_detail'] = 'in_type = 1';

        $query = $this->app_lib->get_query_data($params);
        header("Content-type: application/json");
        $json_data = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $query['total'],
                        'recordsFiltered' => $query['total'],
                        'data' => array()
                    );
        foreach ($query->result() as $row) {

            $entry = array(
                $row->sender,
                $row->in_datetime,
                $row->content,
                $row->readed,
                $row->replied,
                $row->responded,
            );
            $json_data['data'][] = $entry;
        }

        echo json_encode($json_data);
    }
}
