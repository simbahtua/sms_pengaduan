<?php

class Admin extends Admin_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper('form');
        $this->load->helper('language');
        $this->lang->load(array('auth','ion_auth'));
    }

    function index() {
        $this->user('show');

    }

    function user($act='show') {
        if($act == 'show'){
            $this->show_users();
        }
    }

    function show_users() {
        $data['title'] = 'Data Administrator';
        $data['breadcrumps'] = array(
            'Dashboard' => 'admin/dashboard',
            'Admin' => '#',
            'User' => 'admin/administrator/user/show'
        );

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

        $active_groups = $this->ion_auth->active_groups();

        $opt_group = array();
        $opt_group[null] = '-- PILIH GROUP --';
        if ($active_groups->num_rows() > 0) {
            foreach ($active_groups->result() as $row) {
                $opt_group[$row->id] = $row->name;
            }
        }
        $data['opt_group'] = $opt_group;
        $identity_column = $this->config->item('identity','ion_auth');
        $data['identity_column'] = $identity_column;
        themes('admin','administrator/user_list_view', $data);
    }

    function group($act='show') {
        $users = $this->ion_auth->groups();

        echo '<pre>';
        print_r($users->result());
    }

    function act_add_user() {
        // print_r($_POST);
        // die;

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        // $this->data['identity_column'] = $identity_column;

        // validate form input
        // $this->form_validation->set_rules('groups', $this->lang->line('edit_user_validation_groups_label'), 'required');
        // $this->form_validation->set_rules('username', $this->lang->line('create_user_validation_username_label'), 'required');
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        // $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
       
        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'valid_email');
        
        if($this->input->post('forwarded') == 1) {
            $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'required|trim');
        }else {
            $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        }
        
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[conf_password]');
        $this->form_validation->set_rules('conf_password', $this->lang->line('create_user_validation_password_confirm_label'), 'required');


        if( ! ($this->form_validation->run() ) ) {
            $div_open = '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            $div_close = '</div>';

            echo json_encode(array("status" => false, 'message' => $div_open . validation_errors() . $div_close));
        }else {

            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                // 'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
                'forwarded'      => $this->input->post('forwarded'),
            );

            if($this->ion_auth->register($identity, $password, $email, $additional_data)) {
                // $this->session->set_flashdata('message', $this->ion_auth->messages());
                // redirect("admin/administrator/user");
                echo json_encode(array("status" => true));
            }else {
                // echo json_encode(array("status" => true));
                $div_open = '<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                $div_close = '</div>';
                // $this->session->set_flashdata('confirmation', $div_open . $this->ion_auth->errors() . $div_close);
                echo json_encode(array("status" => false, 'message' => $div_open . $this->ion_auth->errors() . $div_close));
            }
        }
    }
}
?>
