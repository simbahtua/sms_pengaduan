<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 *
 */
class Admin_Controller extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->CI =& get_instance();

        //ini buat clear cache agar kalo setelah logout tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        $this->CI->module_url = base_url() . 'admin/' . $this->CI->router->fetch_module();

        $this->load->library(array('ion_auth'));


        if( !$this->ion_auth->logged_in() ) {
            //show_error('Shove off, this is for admins.');
            $referer = rawurlencode('http://' . $_SERVER['HTTP_HOST'] . preg_replace('@/+$@', '', $_SERVER['REQUEST_URI']) . '/');
            $origin = isset($_SERVER['HTTP_REFERER']) ? rawurlencode($_SERVER['HTTP_REFERER']) : $referer;
            $redirect = 'login?redirect_url=' . $origin;
            redirect($redirect);

        } 
        // elseif($this->access_control->privilege()) {
        //     $this->session->set_flashdata('confirmation', '<div class="error alert alert-danger">Anda tidak diotorisasi untuk halaman tersebut.</div>');
        //     redirect('admin/dashboard');
        // }
        else {
            return TRUE;
        }

    }
}


/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */
