<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Admin extends Admin_Controller {

    function __construct() {
        parent::__construct();
        // $this->locad->model('sms/admin_sms_model');
    }

    function index() {
        $this->inbox();
    }

    function inbox() {
        $data['title'] = 'DATA INBOX SMS';

        $data['extra_header'] = '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/css/dataTables.bootstrap.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/Responsive/css/responsive.bootstrap.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/Responsive/css/responsive.dataTables.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/ColReorder/css/colReorder.bootstrap.min.css") . '"/>';

        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/css/dataTables.bootstrap.css") . '" />';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/dropzone/dropzone.css") . '" />';
        $data['extra_header'] .= '<script type="text/javascript" src="' . base_url("plugins/dropzone/dropzone.min.js") . '"></script>';


        $data['extra_footer'] = '<script type="text/javascript" src="' . base_url("plugins/datatable/js/jquery.dataTables.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/js/dataTables.bootstrap.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/Responsive/js/dataTables.responsive.min.js") . '"></script>';

        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/Responsive/js/responsive.bootstrap.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/ColReorder/js/dataTables.colReorder.min.js") . '"></script>';
//        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/dropzone/dropzone.min.js") . '"></script>';


        $data['service_url'] = base_url('service/get_inbox_data');

        themes('admin', 'sms/admin_inbox_view', $data);
    }

    function outbox() {
        $data['title'] = 'DATA OUTBOX SMS';
        $data['extra_header'] = '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/css/dataTables.bootstrap.min.css") . '"/>';
        // $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="'.base_url("plugins/datatable/extensions/FixedHeader/css/fixedHeader.bootstrap.min.css").'"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/Responsive/css/responsive.bootstrap.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/Responsive/css/responsive.dataTables.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/extensions/ColReorder/css/colReorder.bootstrap.min.css") . '"/>';
        $data['extra_header'] .= '<link rel="stylesheet" type="text/css" href="' . base_url("plugins/datatable/css/dataTables.bootstrap.css") . '" />';

        $data['extra_footer'] = '<script type="text/javascript" src="' . base_url("plugins/datatable/js/jquery.dataTables.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/js/dataTables.bootstrap.min.js") . '"></script>';
        // $data['extra_footer'] .= '<script type="text/javascript" src="'.base_url("plugins/datatable/extensions/FixedHeader/js/dataTables.fixedHeader.min.js").'"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/Responsive/js/dataTables.responsive.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/Responsive/js/responsive.bootstrap.min.js") . '"></script>';
        $data['extra_footer'] .= '<script type="text/javascript" src="' . base_url("plugins/datatable/extensions/ColReorder/js/dataTables.colReorder.min.js") . '"></script>';

        $data['service_url'] = base_url('service/get_outbox_data');

        themes('admin', 'sms/admin_outbox_view', $data);
    }



}
