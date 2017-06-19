<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class _cron extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    // function getInbox() {
    //     $params['command'] = 'inboxgetbydate';
    //     $params['from'] = '2017-06-19';
    //     $params['to'] = '2017-06-19';
    //     $params['status'] = 'all';
    //     $inbox = $this->app_lib->zenziva_service($params);
    //
    //     $this->save_inbox($inbox);
    // }

    //get all un-read message
    function read_inbox() {
        $params['command'] = 'readsms';
        $inbox = $this->app_lib->zenziva_service($params);
        if($inbox->message->text == 'Message empty') {
            echo 'ga ada sms baru';
        }else {
            $this->save_inbox($inbox);
        }

    }


    // fungsi simpa sms yang baru
    function save_inbox($data=array()) {

        if (! empty($data)) {

            foreach ($data->message as $row) {
                $insert_data = array();
                // $is_valid = false;
                $is_valid_format = 0;
                if( preg_match('#aduan#',$row->isiPesan)) {
                    $is_valid = true;
                    $insert_data['in_type'] = 1;
                }
                $insert_data['inbox_id'] = $row->id;
                $insert_data['sender'] = $row->dari;
                $insert_data['in_datetime'] = $row->tgl . ' '. $row->waktu;
                $insert_data['content'] = $row->isiPesan;

                $inbox_id = $this->db->insert('message_in', $insert_data);

            }
        }
    }

    //fungsi auto reply format salah
    function autoreply($receiver, $message, $inbox_id) {

        // die($receiver);
        $params['command'] = 'sendsms';
        $params['tipe'] = 'reguler';
        $params['nohp'] = '"' . $receiver. '"';
        $params['pesan'] = $message;
        $resp = $this->app_lib->zenziva_service($params);

        $insert_data = array();
        if($resp->status == 1){
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
        $params['command'] = 'report';
        // $params['id'] = '6765df08291243ec8de4ded5aaecee0e';
        $params['id'] = 1;
        $resp = $this->app_lib->zenziva_service($params);
        print_r($resp);
    }


    function getallaoutbox() {
        $params['command'] = 'outboxgetall';
        // $params['id'] = '6765df08291243ec8de4ded5aaecee0e';
        $resp = $this->app_lib->zenziva_service($params);
        echo '<pre>';
        print_r($resp);
    }

}
