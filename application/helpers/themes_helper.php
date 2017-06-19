
<?php
    if ( ! function_exists('themes'))
    {
        function  themes($user, $view='', $data=array())
        {
           $CI = &get_instance();

           switch ($user) {
               case 'admin':
                   $CI->config->load('template');
                   $themes_config = $CI->config->item($user);
                   $template_folder = $themes_config['folder'];
                    if($view == 'login') {
                        $template_files = 'template_login';
                    }else {
                        $CI->load->model('ion_auth_model');
                        $group_id = $CI->ion_auth_model->get_users_groups();
                        // $arr_admin_menu = $CI->app_lib->get_users_groups_menu($group_id);
                        $template_files = 'template';
                    }

               break;

               default:
                   $template_folder = 'template/public/';
                   $template_files = 'template';
                   break;
           }

           $data['themes_url'] = $CI->config->item('base_url') . $template_folder.'/';
           $data['content_view'] = $view;
           $CI->load->custom_view($template_folder.'/' , $template_files, $data);

        }
    }
/* End of file themes_helper.php */
/* Location: ./system/application/helpers/themes_helper.php */
