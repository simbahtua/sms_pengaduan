<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Controller Service for admin
 */
class Service extends Admin_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->date = date('Y-m-d');
    }
    
    function updateInboxStatus() {
        $id = $this->input->post('message_id');
        $status = $this->input->post('status');
        
        if($status == 'readed') {
            $set_status = 'readed = 1 , read_count = read_count + 1';
        }elseif($status == 'replied') {
            $set_status = 'replied = 1 , reply_count = reply_count + 1';
        }elseif($status == 'responded') {
            $set_status = 'responded = 1 , respons_count = respons_count + 1';
        }else {
            $set_status = '';
        }
        if($set_status != '') {            
            $sql = 'update message_in set '.$set_status.' where id = '.$id;
            $this->db->simple_query($sql);
        }
    }   
    

    function get_inbox_data() {

        /** AJAX Handle */
        $requestData = $_REQUEST;
        $params = isset($_POST) ? $_POST : array();


        $params['table'] = 'message_in';
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

        $total_column = count($columns);
        $where_detail = '';

        $params['select'] = 'id , ' . implode(', ', $columns);

        if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search = $_POST['search']['value'];
            for ($i = 0; $i < $total_column; $i++) {
                $where_detail .= $columns[$i] . ' LIKE "%' . $search . '%"';

                if ($i < $total_column - 1) {
                    $where_detail .= ' OR ';
                }
            }
        }
        /**
         * Search Individual Kolom
         * pencarian dibawah kolom
         */
        for ($i = 0; $i < $total_column; $i++) {
            $searchCol = $requestData['columns'][$i]['search']['value'];
            if ($searchCol != '') {
                $where_detail = $columns[$i] . ' LIKE "%' . $searchCol . '%" ';
                break;
            }
        }

        if ($where_detail != '') {
            $params['where_detail'] = $where_detail;
        }


        $sort = '';
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }
        if ($sort == '') {
            $sort = 'id';
        }
        $sortorder = 'desc';
        $params['sortname'] = rtrim($sort, ', ');
        $params['sortorder'] = '';
        $params['rp'] = isset($_POST['length']) ? $_POST['length'] : 10;

        $params['page'] = $_POST['start'] > 0 ? ($_POST['start'] / $params['length']) + 1 : 1;

        $query = $this->app_lib->get_query_data($params);

        header("Content-type: application/json");
        $json_data = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $query['total'],
            'recordsFiltered' => $query['total'],
            'data' => array()
        );

        $action = '';
        foreach ($query['data']->result() as $row) {
            $is_readed_image = ($row->readed == 0) ? 'icons8-Urgent.png' : 'icons8-Read.png';
            $is_reply_image = ($row->replied == 0) ? 'cross.png' : 'tick.png';
            $is_respons_image = ($row->responded == 0) ? 'cross.png' : 'tick.png';

            $read_status = '<img src="' . base_url() . '/assets/icons/' . $is_readed_image . '"/>';
            $reply_status = '<img src="' . base_url() . '/assets/icons/' . $is_reply_image . '"/>';
            $respons_status = '<img src="' . base_url() . '/assets/icons/' . $is_respons_image . '"/>';

            $action = ' <div class="btn-group">
                            <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown"">PILIH AKSI &nbsp;<span class="caret"></span></button>
                            <ul class="dropdown-menu" role="menu">
                                <li><a data-toggle="modal" data-target="#replysms" data-senderphone ="'.$row->sender.'" data-id="'.$row->id.'" data-indatetime ="'.$row->in_datetime.'" data-content = "'.$row->content.'" data-readed="'.$row->readed.'">BACA SMS</button></li>
                                <li><a data-toggle="modal" data-target="#replysms" data-senderphone ="'.$row->sender.'" data-id="'.$row->id.'" data-indatetime ="'.$row->in_datetime.'" data-content = "'.$row->content.'" data-readed="'.$row->readed.'">BALAS SMS</button></li>
                                <!--<li><a data-toggle="modal" data-target="#respons-sms" data-senderphone ="'.$row->sender.'" data-id="'.$row->id.'" data-indatetime ="'.$row->in_datetime.'" data-content = "'.$row->content.'" data-readed="'.$row->readed.'">TINDAK LANJUTI SMS</button></li>-->
                            </ul>
                        </div>
                    ';

            $entry = array(
                convert_date($row->in_datetime, 'id', 'num', '-'),
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
    
    
    function insert_outbox() {
        
        $output = array();
        $data = array();
        $output['status'] = 'failed';
        
        $data['in_id'] = $this->input->post('in_id');
        $data['receiver'] = $this->input->post('receiver');
        $data['content'] = $this->input->post('content');
        $data['notes'] = $this->input->post('notes');
        $data['out_type'] = ($this->input->post('out_type') == 'reply' || $this->input->post('out_type') == 'respons') ? $this->input->post('out_type') : 'else';//        
        $data['user_id'] = $this->session->userdata('user_id');
        $data['out_datetime'] = date('Y-m-d H:i:s');
        
        
        if(!empty($data['content'])) {
            $params['command'] = 'sendsms';
            $params['tipe'] = 'reguler';
            $params['nohp'] = $data['receiver'];
            $params['pesan'] = $data['content'];
            $sendMessage = $this->app_lib->zenziva_service($params);
            
            if($sendMessage->message->text == 'Success') {
                $data['z_outbox_id'] = $sendMessage->message->messageId;
                $insert_id = $this->db->insert('message_out', $data);
                if($insert_id) {
                    $output['status'] = 'success';
                }else {
                    $output['status'] = 'failed';
                }
            }
        } 
        echo json_encode($output);
    }
    
    function get_outbox_data() {
        $this->lang->load('sms', 'ina');

        /** AJAX Handle */
        $requestData = $_REQUEST;
        $params = isset($_POST) ? $_POST : array();


        $params['table'] = 'message_out';
        $params['id-table'] = 'id';

        /**
         * Kolom yang ditampilkan
         */
        $columns = array(
            'out_datetime',
            'receiver',
            'content',
            'notes',            
            'status',
        );

        $total_column = count($columns);
        $where_detail = '';

        $params['select'] = 'id , ' . implode(', ', $columns);

        if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search = $_POST['search']['value'];
            for ($i = 0; $i < $total_column; $i++) {
                $where_detail .= $columns[$i] . ' LIKE "%' . $search . '%"';

                if ($i < $total_column - 1) {
                    $where_detail .= ' OR ';
                }
            }
        }
        /**
         * Search Individual Kolom
         * pencarian dibawah kolom
         */
        for ($i = 0; $i < $total_column; $i++) {
            $searchCol = $requestData['columns'][$i]['search']['value'];
            if ($searchCol != '') {
                $where_detail = $columns[$i] . ' LIKE "%' . $searchCol . '%" ';
                break;
            }
        }

        if ($where_detail != '') {
            $params['where_detail'] = $where_detail;
        }


        $sort = '';
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }
        if ($sort == '') {
            $sort = 'id';
        }
        $sortorder = 'desc';
        $params['sortname'] = rtrim($sort, ', ');
        $params['sortorder'] = '';
        $params['rp'] = isset($_POST['length']) ? $_POST['length'] : 10;

        $params['page'] = $_POST['start'] > 0 ? ($_POST['start'] / $params['length']) + 1 : 1;

        $query = $this->app_lib->get_query_data($params);

        header("Content-type: application/json");
        $json_data = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $query['total'],
            'recordsFiltered' => $query['total'],
            'data' => array()
        );

        $action = '';
        foreach ($query['data']->result() as $row) {
            $status = $this->lang->line($row->status);
            
            $entry = array(
                convert_date($row->out_datetime, 'id', 'num', '-'),
                $row->receiver,
                $row->content,
                $row->notes,
                $status,
            );
            $json_data['data'][] = $entry;
        }

        echo json_encode($json_data);
    }
}
