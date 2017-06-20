<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Frontend extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Frontend_model');
    }

    function index() {
        $this->home();

    }
    
    
    function home() {
        $data['query'] = $this->Frontend_model->get_list_inbox();
        
        themes('public','frontend/frontend_view', $data);
    }

}
