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

        $data['breadcrumps'] = array(
            'Dashboard' => 'admin/dashboard',
        );

        $data['extra_footer'] = '<script type="text/javascript" src="'.base_url().'plugins/owl/owl.carousel.min.js"></script>';
        themes('admin','dashboard/dashboard_main_view', $data);
    }


}
