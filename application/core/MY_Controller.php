<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";

/**
 * Description of my_controller
 *
 * @author http://roytuts.com
 */
class MY_Controller extends MX_Controller {
	var $CI;

    function __construct() {
        parent::__construct();
        $this->CI =& get_instance();
        
        if (version_compare(CI_VERSION, '2.1.0', '<')) {
            $this->load->library('security');
        }

        $this->CI->arr_flashdata = $this->session->all_flashdata();
    }

}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */
