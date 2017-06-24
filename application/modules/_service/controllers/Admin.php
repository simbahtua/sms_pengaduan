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
    
    function test() {
        $params['command'] = 'credit';
        $params['tipe'] = 'reguler';
        $params['nohp'] = '6285716838002';
        $params['pesan'] = 'cobain dulu gan';
        
        $send_message = $this->app_lib->zenziva_service($params);
        
        print_r($send_message);
    }
}
