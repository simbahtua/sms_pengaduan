<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class _cron extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->date = date('Y-m-d');

        // $this->forward_to = array('085716838002','085643932008');
        $this->forward_to = array('085643932008');
    }

    /* FUnction getInbox
     * untuk mengambil semua data inbox message dari server zenziva_service
     * params $status default 'all' => nilai status = all , unread, read
     * Params start_date & end_date untuk range tanggal data sms yang akan di ambil
     */

    function getInbox($status = 'all', $start_date = '', $end_date = '') {

        $output = array();
        if ($start_date == '') {
            $start_date = $end_date = $this->date;
        }
        $params['command'] = 'inboxgetbydate';
        $params['from'] = $start_date;
        $params['to'] = $end_date;
        $params['status'] = $status;
        $inbox = $this->app_lib->zenziva_service($params);

        if (!empty($inbox)) {
            if($inbox->message->text != 'Null') {
                $save = $this->save_inbox($inbox, true);
                if($save == '') {
                    $output['status'] = false;
                }else {
                    $output['status'] = true;
                }
            }
        }
        else {
            $output['status'] = false;
        }

        echo json_encode($output);
    }

    /*
     * function read_inbox digunakan untuk mengambil sms dari servis zenziva yang statusnya belum dibaca
     */

    function read_inbox() {
        $output = array();
        $params['command'] = 'readsms';
        $inbox = $this->app_lib->zenziva_service($params);

        if(!empty($inbox)) {
            if ($inbox->message->text == 'Message empty') {
            $output['status'] = false;
        } else {
                $save = $this->save_inbox($inbox);
                if ($save == '') {
                    $output['status'] = false;
                } else {
                    $output['status'] = true;
                }
            }
        }else{
            $output['status'] = false;
        }
        echo json_encode($output);
    }

    // fungsi simpan sms yang baru
    function save_inbox($data = array(), $merge_date = false) {

        // $forward_to  = array();
        $forward_to = $this->get_forward_receiver();
        $status = '';
        if (!empty($data)) {
            $prev_date = '';
            $prev_date_query = '';
            $in_count = $spam_count  = 0;
            $in = $spam = 0;

            $arr_daily_data = array();
            foreach ($data->message as $row) {
                $is_spam = true;

                $message_content = $row->isiPesan;
                if (preg_match("/#aduan#/", $message_content)) {
                    $is_spam = false;
                }

                $table = ($is_spam) ? 'message_spam': 'message_in';

                $insert_data['inbox_id'] = $row->id;
                $insert_data['sender'] = $row->dari;
                if( $merge_date ) {
                    $message_date = $row->tgl;
                    $insert_data['in_datetime'] = $row->tgl . ' ' . $row->waktu;
                }else {
                    $in_datetime = explode(' ', $row->waktu);
                    $message_date = $in_datetime[0];
                    $insert_data['in_datetime'] = $row->waktu;
                }

                $insert_data['content'] = preg_replace('/#aduan#/', '', $message_content);

                $insert_id = $this->app_lib->insert_ignore_data($table, $insert_data);
                if($insert_id != 0) {
                    if(strtotime($prev_date) != strtotime($message_date)) {
                        $prev_date = $message_date;
                        if($is_spam) {
                            $in_count = 0; $spam_count = 1;
                        }else {
                            $in_count = 1; $spam_count = 0;
                        }
                    }else{
                        if($is_spam) {
                            $spam_count++;
                        }else {
                            $in_count++;
                        }
                    }

                    $arr_daily_data[strtotime($message_date)]['in'] = $in_count;
                    $arr_daily_data[strtotime($message_date)]['spam'] = $spam_count;
                }

                // forward sms
                if(!empty($forward_to)) {
                    foreach ($forward_to as $key => $value) {
                        $params['command'] = 'sendsms';
                        $params['tipe'] = 'reguler';
                        $params['nohp'] =  $value;
                        $params['pesan'] = preg_replace('/#aduan#/', '', $message_content);
                        $resp = $this->app_lib->zenziva_service($params);
                    }
                }
                
            }

            if(!empty($arr_daily_data)) {
                $status = 'update';
                foreach ($arr_daily_data as $key => $value) {
                    $date = date('Y-m-d', $key);
                    $arr_date = explode('-', $date);
                    $is_exist = $this->app_lib->get_one('inbox_report', 'id', 'message_date = '.$key);

                    if($is_exist) {
                        $sql = 'UPDATE inbox_report SET in_count = in_count +' .$value['in'] . ', spam_count = spam_count +'.$value['spam'] .'
                         WHERE message_date =  '.$key;
                    }else {
                        $sql = 'INSERT INTO inbox_report SET in_count = ' .$value['in'] . ', spam_count = '.$value['spam'] .'
                         , message_date =  '.$key. ',message_day = '.$arr_date[2]. ',message_month = '.$arr_date[1]. ',message_year = '.$arr_date[0];
                    }
                    $this->db->query($sql);
                }
            }
        }
        return $status;
    }

    //fungsi auto reply format salah
    function autoreply($receiver, $message, $inbox_id) {

        $params['command'] = 'sendsms';
        $params['tipe'] = 'reguler';
        $params['nohp'] = '"' . $receiver . '"';
        $params['pesan'] = $message;
        $resp = $this->app_lib->zenziva_service($params);

        $insert_data = array();
        if ($resp->status == 1) {
            $insert_data['status'] = 'sending';
            $insert_data['in_id'] = $inbox_id;
            $insert_data['receiver'] = $receiver;
            $insert_data['content'] = $message;
            $insert_data['out_datetime'] = date('Y-m-d');
            $insert_data['z_outbox_id'] = $resp->messageId;

            $this->db->insert('message_out', $insert_data);
        }
    }

    function checkouboxstatus() {
        $q_params['table'] = 'message_out';
        $q_params['select'] = 'z_outbox_id';
        $q_params['where_detail'] = 'status = "sending"';
        $progress_message = $this->app_lib->get_query_data($q_params);
        if ($progress_message['total'] > 0) {
            foreach ($progress_message['data']->result() as $row) {
                $data = array();
                $param['command'] = 'report';
                $param['id'] = $row->z_outbox_id;
                $resp = $this->app_lib->zenziva_service($param);
                if(!empty($resp->message->status)) {
                    $data['status'] = $resp->message->status;
                    $this->db->where('z_outbox_id', $param['id']);
                    $this->db->update($q_params['table'], $data);
                }
            }
        }
    }

    function getallaoutbox() {
        $params['command'] = 'outboxgetall';
        $resp = $this->app_lib->zenziva_service($params);
        echo '<pre>';
        print_r($resp);
    }


    function get_forward_receiver() {
        $data = array();
        $this->db->select('phone');
        $this->db->where('forwarded', 1);
        $query = $this->db->get('users');
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row->phone;
            }
        }

        // die($data);
        // print_r($data);
        return $data;
    }

}
