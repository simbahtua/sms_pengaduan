<?php

/**
 *
 */
 defined('BASEPATH') OR exit('No direct script access allowed');
class Auth extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        // $this->load->model('_system/systems_model');
        $this->load->library('ion_auth');
        // $this->load->database();
        $this->load->helper('language');
        // $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
    }

    public function index() {
        $this->login();
    }


    function login() {

        //ini buat clear cache agar kalo setelah login tidak bisa di back lewat button back di browser
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

        if ($this->ion_auth->logged_in())
        {
            redirect('admin/dashboard', 'refresh');
        }else {
            $this->load->helper('form');
            if (isset($_GET['redirect_url']) && trim($_GET['redirect_url']) != '') {
                $data['redirect_url'] = $_GET['redirect_url'];
            } else {
                $data['redirect_url'] = '';
            }
            themes('admin','login', $data);
        }

    }

    function authenticate() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', '<b>Username</b>', 'trim|htmlspecialchars|required');
        $this->form_validation->set_rules('password', '<b>Password</b>', 'trim|htmlspecialchars|required');

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        if ($this->form_validation->run() == true) {

            //check for "remember me";
           $remember = (bool) $this->input->post('remember');

           if ($this->ion_auth->login($this->input->post('username'), $this->input->post('password'), $remember))
           {
               redirect('admin/dashboard');

           }
           else
           {
               // if the login was un-successful
               // redirect them back to the login page
              $this->session->set_flashdata('message', $this->ion_auth->errors());
              redirect('login');

           }


        } else {
         $this->session->set_flashdata('username', $this->input->post('username'));
            $this->session->set_flashdata('message', validation_errors());
          
            redirect('login');

        }

    }

    function logout() {
      $this->data['title'] = "Logout";
		// log the user out
  		$logout = $this->ion_auth->logout();

		// redirect them to the login page
      $this->session->set_flashdata('message', $this->ion_auth->messages());
		  redirect('login');
    }


}
