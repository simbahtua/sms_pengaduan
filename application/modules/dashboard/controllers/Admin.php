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
        
        // echo 'OK';
        // print_r($this->session->userdata());
        // die;
        $data = array();

        themes('admin','dashboard/dashboard_main_view', $data);
    }
}
