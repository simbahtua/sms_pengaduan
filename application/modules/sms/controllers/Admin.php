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
        // $this->load->model('sms/admin_sms_model');

    }

    function index() {
        die('a');
        $this->inbox();

    }

    function inbox() {
        $data['title'] = 'DATA INBOX SMS';

        $data['extra_header'] = '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/css/dataTables.bootstrap.min.css").'"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css").'"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/extensions/Responsive/css/responsive.bootstrap.min.css").'"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/extensions/Responsive/css/responsive.dataTables.min.css").'"/>';


        // $data['extra_header'] = '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/css/dataTables.bootstrap.css").'" />';
        $data['extra_footer'] = '<script type="text/javascript" src="'.base_url("plugins/datatable/js/jquery.dataTables.min.js").'"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="'.base_url("plugins/datatable/js/dataTables.bootstrap.min.js").'"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="'.base_url("plugins/datatable/extensions/FixedHeader/js/dataTables.fixedHeader.min.js").'"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="'.base_url("plugins/datatable/extensions/Responsive/js/dataTables.responsive.min.js").'"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="'.base_url("plugins/datatable/extensions/Responsive/js/responsive.bootstrap.min.js").'"></script>';


        $data['service_url'] = $this->module_url.'/get_inbox_data';



        themes('admin','sms/admin_inbox_view', $data);
    }

    function outbox() {
        $data['title'] = 'DATA OUTBOX SMS';
        //$data['extra_header'] = '<link rel="stylesheet" href="'.base_url().'plugins/dTables/media/css/dataTables.bootstrap.css">';
        // $data['extra_header'] .= '<script type="text/javascript" src="'.base_url().'plugins/dTables/media/js/">';
        $data['service_url'] = $this->module_url.'/get_sms_data/out';

        themes('admin','sms/admin_outbox_view', $data);

    }

    function get_inbox_data() {

        /** AJAX Handle */
    	if(
    		isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    		!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    		)
    	{
            // $requestData= $_REQUEST;
            // print_r($requestData);
            // die;
        }
        // echo '<pre>';
        // print_r($_POST);
        // die;

        $requestData= $_REQUEST;
        //  $datatables  = $_POST;

        // echo '<pre>';
        // print_r($requestData);
        // die;

        $params['table']    = 'message_in';
        $params['id-table'] = 'id';

        /**
         * Kolom yang ditampilkan
         */

         $columns = array(
                        'in_datetime',
                        'sender',
                        'content',
                        'readed',
                        // 'read_count',
                        'replied',
                        // 'reply_count',
                        'responded',
                        // 'respons_count',
                        // 'inbox_id'
                      );

                    //   print_r($columns);
                    //   die;
         $total_column = count($columns);
         $where_detail = '';

         $params['select'] = 'id , ' .implode(', ', $columns) ;

          if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
              $search = $_POST['search']['value'];
              for ($i=0; $i < $total_column ; $i++) {
                  $where_detail .= $columns[$i] .' LIKE "%'. $search .'%"';

                  if ($i < $total_column - 1) {
                      $where_detail .= ' OR ';
                  }
              }
           }
           /**
            * Search Individual Kolom
            * pencarian dibawah kolom
            */
           for ($i=0; $i < $total_column; $i++) {
               $searchCol = $requestData['columns'][$i]['search']['value'];
               if ($searchCol != '') {
                   $where_detail = $columns[$i] . ' LIKE "%' . $searchCol . '%" ';
                   break;
               }
           }
        //    die;
           //
        //
        if($where_detail !='') {
            $params['where_detail'] = $where_detail;
        }


       $sort = '';
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }

        if($sort == '') {
            $sort = 'id';
        }
        $sortorder = 'desc';
        $params['sortname'] = rtrim($sort, ', ');
        $params['sortorder'] = '';
        $params['rp'] = isset($_POST['length']) ? $_POST['length'] : 10;
        // $params['page'] = isset($_POST['start']) ? $_POST['start']+1 : 1;
        $params['page'] = $_POST['start'] > 0 ? ($_POST['start']/$params['length'])+1 : 1;

        $query = $this->app_lib->get_query_data($params);

        header("Content-type: application/json");
        $json_data = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $query['total'],
                        'recordsFiltered' =>$query['total'],
                        'data' => array()
                    );
        $action = '';
        foreach ($query['data']->result() as $row) {
            $is_readed_image = ($row->readed == 0) ? 'icons8-Urgent.png' : 'icons8-Read.png';
            $is_reply_image = ($row->replied == 0) ? 'cross.png' : 'tick.png';
            $is_respons_image = ($row->responded == 0) ? 'cross.png' : 'tick.png';

            $read_status = '<img src="'.base_url().'/assets/icons/'.$is_readed_image.'"/>';
            $reply_status = '<img src="'.base_url().'/assets/icons/'.$is_reply_image.'"/>';
            $respons_status = '<img src="'.base_url().'/assets/icons/'.$is_respons_image.'"/>';

            $entry = array(
                $row->in_datetime,
                $row->sender,
                $row->content,
                $read_status,
                $reply_status,
                $respons_status,
                $action
            );
            $json_data['data'][] = $entry;
        }

        echo json_encode($json_data);
    }

}
