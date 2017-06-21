<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class Page extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Page_model');
    }

    function index() {
        $this->home();

    }
    
    
    function home() {
        $data['query'] = $this->Page_model->get_list_inbox();
        
        themes('public','page/page_view', $data);
    }
    
    function about_us(){
        $data['query'] = $this->Page_model->get_list_inbox();
        
        themes('public','page/page_about_us_view', $data);
    }
    
    function contact_us(){
        $data['query'] = $this->Page_model->get_list_inbox();
        
        themes('public','page/page_contact_us_view', $data);
    }

}
