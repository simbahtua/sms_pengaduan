<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * Controller Service for admin
 */

class Service extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->date = date('Y-m-d');
    }

    function updateInboxStatus() {
        $id = $this->input->post('message_id');
        $status = $this->input->post('status');

        if ($status == 'readed') {
            $field_update = 'read_count';
            $set_status = 'readed = 1 , read_count = read_count + 1';
        } elseif ($status == 'replied') {
            $set_status = 'replied = 1 , reply_count = reply_count + 1';
            $field_update = 'reply_count';
        } elseif ($status == 'responded') {
            $set_status = 'responded = 1 , respons_count = respons_count + 1';
            $field_update = 'respons_count';
        } else {
            $set_status = '';
        }
        if ($set_status != '') {
            $sql = 'update message_in set ' . $set_status . ' where id = ' . $id;
            $this->db->simple_query($sql);
        }

        if ($this->input->post('prev_status') == 0) {
            $sql = 'UPDATE inbox_report SET ' . $field_update . ' = ' . $field_update . ' + 1 WHERE message_date = "' . $this->input->post('indate') . '"';
            $this->db->simple_query($sql);
        }
    }

    function get_inbox_data() {
        /** AJAX Handle */
        $requestData = $_REQUEST;
        $params = isset($_POST) ? $_POST : array();

        $params['table'] = 'message_in';
        /**
         * Kolom yang ditampilkan
         */
        $columns = array(
            'in_datetime',
            'sender',
            'content',
            'readed',
            'replied',
            'responded',
        );

        $total_column = count($columns);
        $where_detail = '';

        $params['select'] = 'id ,date(in_datetime) as indate ,' . implode(', ', $columns);

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
         */

        for ($i = 0; $i < $total_column; $i++) {
            $searchCol = $requestData['columns'][$i]['search']['value'];
            if ($searchCol != '') {
                $where_detail .= $columns[$i] . ' LIKE "%' . $searchCol . '%" AND ';
            }
        }

        if ($where_detail != '') {
            $params['where_detail'] = rtrim($where_detail, ' AND ');
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
                             <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown""><span class="caret"></span>&nbsp;PILIH AKSI &nbsp;</button>
                             <ul class="dropdown-menu" style="margin-left: -70px;">
                                 <li><a type="button" data-toggle="modal" data-target="#replysms" data-senderphone ="' . $row->sender . '" data-id="' . $row->id . '" data-indatetime ="' . strtotime($row->indate) . '" data-content = "' . $row->content . '" data-readed="' . $row->readed . '" data-replied ="' . $row->replied . '" data-responded="' . $row->responded . '">BACA SMS</a></li>
                                 <li><a type="button" data-toggle="modal" data-target="#replysms" data-senderphone ="' . $row->sender . '" data-id="' . $row->id . '" data-indatetime ="' . strtotime($row->indate) . '" data-content = "' . $row->content . '" data-readed="' . $row->readed . '" data-replied ="' . $row->replied . '" data-responded="' . $row->responded . '">BALAS SMS</a></li>
                                 <li><a type="button" data-toggle="modal" data-target="#respond-sms" data-senderphone ="' . $row->sender . '" data-id="' . $row->id . '" data-indatetime ="' . strtotime($row->indate) . '" data-content = "' . $row->content . '" data-readed="' . $row->readed . '" data-replied ="' . $row->replied . '" data-responded="' . $row->responded . '">TINDAK LANJUT</a></li>
                                 <li><a type="button" onclick="delete_message('.$row->id.')">HAPUS INBOX</a></li>
                                 <li><a href="'.base_url('print/'. strtotime($row->in_datetime)).'" target="_blank">PRINT</a></li>

                             </ul>
                         </div>
                     ';
//            $action = ' <div class="btn-group">
//                            <button type="button" class="btn btn-success btn-sm" data-toggle="dropdown""><span class="caret"></span>&nbsp;PILIH AKSI &nbsp;</button>
//                            <ul class="dropdown-menu" style="margin-left: -70px;">
//                                <li><a type="button" data-toggle="modal" data-target="#replysms" data-senderphone ="' . $row->sender . '" data-id="' . $row->id . '" data-indatetime ="' . strtotime($row->indate) . '" data-content = "' . $row->content . '" data-readed="' . $row->readed . '" data-replied ="' . $row->replied . '" data-responded="' . $row->responded . '">BACA SMS</a></li>
//                                <li><a type="button" data-toggle="modal" data-target="#replysms" data-senderphone ="' . $row->sender . '" data-id="' . $row->id . '" data-indatetime ="' . strtotime($row->indate) . '" data-content = "' . $row->content . '" data-readed="' . $row->readed . '" data-replied ="' . $row->replied . '" data-responded="' . $row->responded . '">BALAS SMS</a></li>
//                            </ul>
//                        </div>
//                    ';

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

    function send_sms($arr_data) {

        $zenziva_message_id = '';
        $params['command'] = 'sendsms';
        $params['tipe'] = 'reguler';
        $params['nohp'] = $arr_data['receiver'];
        $params['pesan'] = $arr_data['content'];
        $sendMessage = $this->app_lib->zenziva_service($params);

        if (!empty($sendMessage) && $sendMessage->message->text == 'Success') {
            $zenziva_message_id = $sendMessage->message->messageId;
        }

        return $zenziva_message_id;
    }

    function act_reply() {
        $output = array();
        $data = array();
        $send_sms = 'failed';

        $data['in_id'] = $this->input->post('in_id');
        $data['receiver'] = $this->input->post('receiver');
        $data['content'] = $this->input->post('content');
        $data['notes'] = $this->input->post('notes');
        $data['out_type'] = ($this->input->post('out_type') == 'reply' || $this->input->post('out_type') == 'respons') ? $this->input->post('out_type') : 'else'; //
        $data['user_id'] = $this->session->userdata('user_id');
        $data['out_datetime'] = date('Y-m-d H:i:s');
        if (!empty($data['content'])) {
            $zenziva_id = $this->send_sms($data);
            if($zenziva_id != '') {
                $data['z_outbox_id'] = $zenziva_id;
                $this->db->insert('message_out', $data);
                $send_sms = 'success';
            }
        } else {
            $send_sms = 'failed';
        }

        echo json_encode($send_sms);
    }

    function get_outbox_data() {
        $this->lang->load('sms');

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
                $where_detail .= $columns[$i] . ' LIKE "%' . $searchCol . '%" AND ';
            }
        }

        if ($where_detail != '') {
            $params['where_detail'] = rtrim($where_detail, ' AND ');
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

    function dashboard_info() {
        $date = date('Y-m-d');
        $monthYear = date('Y-m');
        $arr_date = explode('-', $date);

        $sms_credit = $this->app_lib->zenziva_service(array('command' => 'credit'));

        if (!empty($sms_credit)) {
            $info = (array)$sms_credit->credit;

            $output['credit']['value'] = $info['value'];
            $output['credit']['activedate'] = $info['activedate'];
        } else {
            $output['credit']['value'] = " - ";
            $output['credit']['activedate'] = " - ";
        }

        $output['all'] = $this->get_summary_sms();
        $output['daily'] = $this->get_summary_sms(array('message_date' => strtotime($date)));
        $output['monthly'] = $this->get_summary_sms(array('message_month' => intval(date('m')), 'message_year' => intval(date('Y'))));


        echo json_encode($output);
    }

    function get_summary_sms($where = '') {
        $where_detail = '';
        if ($where != '') {
            if (is_array($where)) {
                foreach ($where as $cond => $val) {
                    $where_detail .= $cond . '=' . $val . ' AND ';
                }
                $where_detail = rtrim($where_detail, ' AND ');
            } else {
                $where_detail = $where;
            }
            $params['where_detail'] = $where_detail;
        }

        $params['select'] = 'IFNULL(SUM(in_count),0) as in_count,
        IFNULL(SUM(read_count),0) as read_count, IFNULL(SUM(reply_count),0) as reply_count,
        IFNULL(SUM(respons_count),0) as respons_count';
        $params['table'] = 'inbox_report';

        $data = $this->app_lib->get_query_data($params);
        return $data['data']->row();
    }

    function get_unshown_message() {
        $this->db->select('id');
        $this->db->where('is_shown', 0);
        $unshown = $this->db->count_all_results('message_in');

        $sql = 'UPDATE message_in SET is_shown = 1 WHERE is_shown = 0';
        $this->db->simple_query($sql);
        echo json_encode($unshown);
    }

    function act_respond() {
        $status = 'failed';
        $dir_target = 'assets/images/responds/';
        $this->allowed_file_type = 'jpg|jpeg|gif|png';

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

            $save_respond = true;
            $is_sms = ($this->input->post('is_sms')) ? $this->input->post('is_sms') : 0;
            $data['in_id'] = $this->input->post('in_id');
            $data['is_sms'] = $is_sms;
            $data['detail_aduan'] = $this->input->post('notes');
            $data['respond_sms'] = $this->input->post('content');
            $data['respond_text'] = $this->input->post('desc');
            $data['user_id'] = $this->session->userdata('user_id');
            $data['respond_datetime'] = date('Y-m-d H:i:s');

            if ($is_sms && $data['respond_sms'] != '') {
                $arr_data = array(
                    'receiver' => $this->input->post('receiver'), 'content' => $this->input->post('content'), 'out_type' => 'respond'
                );
                $save_respond = $this->send_sms($arr_data);
            }else{
                if($data['respond_text'] == '') {
                    $save_respond = false;
                }
            }

            if ($save_respond) {
                if (!empty($_FILES)) {

                    $config['upload_path'] = $dir_target;
                    $config['allowed_types'] = 'gif|jpg|png|ico';
                    $this->load->library('upload');

                    $file_count = count($_FILES['file']['name']);
                    $data['respond_images'] = '';

                    for ($i = 0; $i < $file_count; $i++) {
                        $_FILES['userfile']['name'] = $_FILES['file']['name'][$i];
                        $_FILES['userfile']['type'] = $_FILES['file']['type'][$i];
                        $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'][$i];
                        $_FILES['userfile']['error'] = $_FILES['file']['error'][$i];
                        $_FILES['userfile']['size'] = $_FILES['file']['size'][$i];

                        if ($this->upload->fileUpload('userfile', $dir_target, $this->allowed_file_type)) {
                            $upload = $this->upload->data();
                            $image_filename = 'respond-' . $this->input->post('in_id') . '-' . date("YmdHis") . '-' . $i . strtolower($upload['file_ext']);
                            rename($upload['full_path'], $upload['file_path'] . $image_filename);
                            if ($i > 0) {
                                $data['respond_images'] .='#' . $image_filename;
                            } else {
                                $data['respond_images'] = $image_filename;
                            }
                        }
                    }
                }
                $insert_id = $this->db->insert('responds', $data);

                if ($insert_id) {
                    $status = 'success';
                } else {
                    $status = 'failed';
                }
            }
        }

        echo json_encode($status);
    }

    function check_outbox_status() {
        $this->db->select('z_outbox_id, status,id');
        $this->db->where('is_updated', 0);
        $query = $this->db->get('message_out');
        if($query->num_rows() >0 ){
            foreach ($query->result() as $key => $sms_id ) {

                $params['command'] = 'report';
                $params['id'] = $sms_id->z_outbox_id;
                $zenziva_status = $this->app_lib->zenziva_service($params);
                if(!empty($zenziva_status) && $zenziva_status->message->status != $sms_id->status) {
                    $update = 'UPDATE message_out set status = "'.$zenziva_status->message->status.'" ,is_updated = 1 WHERE id = '.$sms_id->id;
                    $this->db->query($update);
                }
            }
        }
    }

    function act_delete() {
        $inbox_id = $this->input->post('id');
        $response = array();

        $detail = $this->app_lib->get_detail_data('message_in', 'id', $inbox_id);
        if($detail->num_rows() > 0) {

            $row = $detail->row();
            $date_time = explode(' ', $row->in_datetime);
            $date = $date_time[0];
            $read_status = $row->readed;
            $reply_status = $row->replied;
            $responds_status = $row->responded;

            $this->app_lib->delete_data('message_in','id', $inbox_id);

            // Update summary inbox_id
            $sql_update = 'UPDATE inbox_report SET in_count = in_count - 1';
            if($read_status == 1) {
                $sql_update .= ', read_count = read_count -1';
            }
            if($reply_status == 1) {
                $sql_update .= ', reply_count = reply_count -1';
            }
            if($responds_status == 1) {
                $sql_update .= ', respons_count = respons_count -1';
            }

            $sql_update .= ' WHERE message_date = "'.strtotime($date).'"';
            $updated = $this->db->query($sql_update);

            if($updated) {
                $this->app_lib->delete_data('message_in','id', $inbox_id);
                $response['status'] = true;
                $response['message'] = 'Pesan Aduan Berhasil Dihapus';
            }else {
                $response['status'] = false;
                $response['message'] = 'Pesan Aduan gagal dihapus';
            }

        }else {
            $response['status'] = false;
            $response['message'] = 'Data Tidak Ditemukan';
        }
        echo json_encode($response);
    }

    function print_inbox() {
        $data = array();
        $data['arr_breadcrumbs'] = array(
            'SMS' => '#',
            'Inbox' => 'admin/sms/inbox',
            'Cetak Inbox' => '',
        );

        $indatetime = $this->uri->segment(2);

        if($indatetime != ''){
            if( is_numeric($indatetime) && (int)$indatetime == $indatetime ) {
                $indatetime = date('Y-m-d H:i:s' , $indatetime);
            }
        }

        $detail = $this->app_lib->get_detail_data("message_in", "in_datetime", $indatetime);
        if($detail->num_rows() > 0) {
            $data['detail'] = $detail->row();
        }
        themes('blank', 'sms/admin_print_inbox', $data);
    }


    function getUsers() {
        $params = isset($_POST) ? $_POST : array();
        $columns = array(
                    'username',
                    'name',
                    // 'last_name',
                    'email',
                    'phone',
                    'forward_status',
                    'last_login',
                    'description'
                );

        $params['select'] = 'users.id as userID,CONCAT(first_name,last_name )as name,username , email,phone, forwarded,
        (CASE forwarded
        WHEN 0 THEN "TIDAK"
        ELSE "YA"
        END
        ) as forward_status, avatar, last_login, description';

        $where_detail = '' ;
        $total_column = count($columns);

        if (isset($_POST['search']) && isset($_POST['search']['value']) && $_POST['search']['value'] != '') {
            $search = $_POST['search']['value'];
            for ($i = 0; $i < $total_column; $i++) {
                $where_detail .= $columns[$i] . ' LIKE "%' . $search . '%"';
                if ($i < $total_column - 1) {
                    $where_detail .= ' OR ';
                }
            }
        }

        if ($where_detail != '') {
            $params['where'] = rtrim($where_detail, ' AND ');
        }
        $sort = '';
        foreach ($_POST['order'] as $cols) {
            $sort .= $columns[$cols['column']] . ' ' . $cols['dir'] . ', ';
        }
        if ($sort == '') {
            $sort = 'userID';
        }
        $sortorder = 'desc';
        $params['sortname'] = rtrim($sort, ', ');
        $params['sortorder'] = '';
        $params['rp'] = isset($_POST['length']) ? $_POST['length'] : 10;

        $params['page'] = $_POST['start'] > 0 ? ($_POST['start'] / $params['length']) + 1 : 1;

        $params['table'] = 'users';
        $params['join'] = 'INNER JOIN users_groups ON user_id = users.id
        INNER JOIN groups ON groups.id = group_id
        ';

        $query = $this->app_lib->get_query_data($params);

        header("Content-type: application/json");
        $json_data = array(
                        'draw' => $_POST['draw'],
                        'recordsTotal' => $query['total'],
                        'recordsFiltered' => $query['total'],
                        'data' => array()
                    );
        foreach ($query['data']->result() as $row) {
            //add html for action
           $action = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_person('."'".$row->userID."'".')"><i class="glyphicon glyphicon-pencil"></i></a> <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_person('."'".$row->userID."'".')"><i class="glyphicon glyphicon-trash"></i></a>';

            $entry = array(
                $row->username,
                $row->name,
                // $row->last_name,
                $row->email,
                $row->phone,
                $row->forward_status,
                // $row->avatar,
                ($row->last_login == '') ? ' - ' : date('Y-m-d H:i:s', $row->last_login),
                $row->description,
                $action
            );


            $json_data['data'][] = $entry;
        }

        echo json_encode($json_data);

    }

    function getUsersGroup() {

    }

}
