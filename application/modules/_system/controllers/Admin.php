<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Admin
 *
 * @author esoft
 */
class Admin extends Admin_Controller {

    public function __construct() {
        parent::__construct();

        //  $this->load->library('ion_auth');
         $this->load->library(array('ion_auth','form_validation'));
		 $this->load->helper('language');
         $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

         $this->lang->load(array('auth','ion_auth'));
    }

    function profile() {
        $this->load->helper('form');
        $data['breadcrumps'] = array(
            'Dashboard' => 'admin/dashboard',
            'Systems' => '#',
            'Profil Admin' => 'admin/_system/profile'
        );
        $data['user'] = $this->ion_auth->user()->row();

        $data['image_width'] = 96;
        $data['image_height'] = 96;

        $data['message'] = $this->session->flashdata('message');

        themes('admin', '_system/admin_profile_view', $data);
    }

    function user_groups() {
        $groups = $this->ion_auth->groups()->result();

        $data['groups'] = $groups;

        print_r($data);
    }

    function password() {
        $this->load->helper('form');

        $data['breadcrumps'] = array(
            'Dashboard' => 'admin/dashboard',
            'Systems' => '#',
            'Ubah Password' => 'admin/_system/password'
        );
        themes('admin', '_system/change_password_view', $data);
    }

    function act_password() {
        $this->form_validation->set_rules('old_pass', $this->lang->line('change_password_validation_old_password_label'), 'required');
		$this->form_validation->set_rules('new_pass', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
		$this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
		{
            $div_open = '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            $div_close = '</div>';

            $this->session->set_flashdata('confirmation', $div_open . validation_errors() . $div_close);

        } else {
            $identity = $this->session->userdata('identity');

			$change = $this->ion_auth->change_password($identity, $this->input->post('old_pass'), $this->input->post('new_pass'));

			if ($change) {
				//if the password was successfully changed
                $div_open = '<div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                $div_close = '</div>';
				$this->session->set_flashdata('confirmation', $div_open . $this->ion_auth->messages() . $div_close);
			} else {
                $div_open = '<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                $div_close = '</div>';
				$this->session->set_flashdata('confirmation', $div_open . $this->ion_auth->errors() . $div_close);
			}
        }
        redirect('admin/_system/password');
    }

    function act_profile() {
        $this->image_width = 96;
        $this->image_height = 96;

        $dir_target = 'assets/images/users/';
        $this->allowed_file_type = 'jpg|jpeg|gif|png';

        $this->load->library('form_validation');
        $this->load->library('upload');
        $this->load->library('image_lib');
        $this->form_validation->set_rules('username', '<b>Nama User</b>', 'required');
        $this->form_validation->set_rules('first_name', '<b>Nama Depan</b>', 'required');

        if ($this->form_validation->run($this) == FALSE) {
            $div_open = '<div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
            $div_close = '</div>';
            $this->session->set_flashdata('confirmation', $div_open . validation_errors() . $div_close);

        } else {
            $data = array(
					'username' => $this->input->post('username'),
					'first_name' => $this->input->post('first_name'),
					'last_name'  => $this->input->post('last_name'),
					'email'    => $this->input->post('email'),
					'phone'      => $this->input->post('phone'),
				);
            $administrator_old_image = $this->input->post('old_image');

            if ($this->upload->fileUpload('image', $dir_target, $this->allowed_file_type)) {
                $upload = $this->upload->data();

                $size = getimagesize($upload['full_path']);
                $width = $size[0];
                $height = $size[1];

                if ($width != $this->image_width || $height != $this->image_height) {
                    $this->image_lib->resizeImage($upload['full_path'], $this->image_width, $this->image_height);
                    $this->image_lib->cropImage($upload['full_path'], $this->image_width, $this->image_height);
                }

                $image_filename = url_title($this->session->userdata('username')) . '-' . date("YmdHis") . strtolower($upload['file_ext']);
                rename($upload['full_path'], $upload['file_path'] . $image_filename);

                //delete old file
                if ($administrator_old_image != '' && file_exists($dir_target . $administrator_old_image)) {
                    @unlink($dir_target . $administrator_old_image);
                }

                $data['avatar'] = $image_filename;

                $d_session = array('avatar' => $image_filename);
            }

            if($this->ion_auth->update($this->session->userdata('user_id'), $data))
		    {
                $d_session['identity'] = $this->input->post('username');
                $d_session['username'] = $this->input->post('username');
                $d_session['email'] = $this->input->post('email');
                $this->session->set_userdata($d_session) ;

                $div_open = '<div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                $div_close = '</div>';
				$this->session->set_flashdata('confirmation', $div_open . $this->ion_auth->messages() . $div_close);
		    }
		    else
		    {
                $div_open = '<div class="alert alert-danger" role="alert">
                    <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                $div_close = '</div>';
				$this->session->set_flashdata('confirmation', $div_open . $this->ion_auth->errors() . $div_close);

		    }
        }
        redirect('admin/_system/profile');
    }

    function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}

}
