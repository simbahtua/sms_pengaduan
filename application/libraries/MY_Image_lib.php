<?php

/*
 * Image_lib Extended Libraries
*/

// -----------------------------------------------------------------------------

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Image_lib extends CI_Image_lib {

    function __construct() {
        parent::__construct();
    }

    /**
     * Resize Image
     *
     */
    //resizeImage(image_source, image_destination, new_image_width, new_image_height);
    function resizeImage($path, $new_width, $new_height) {
        $config['image_library'] = 'GD2';
        $config['source_image'] = $path;
        $config['create_thumb'] = FALSE;
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $new_width;
        $config['height'] = $new_height;

        $this->initialize($config);
        $this->resize();
    }

    // --------------------------------------------------------------------

    /**
     * Cropping Center Image
     *
     */
    //cropImage(image_source, new_image_width, new_image_height);
    function cropImage($path, $new_width, $new_height) {
        $size = getimagesize($path);
        $width = $size[0];
        $height = $size[1];
        $x_center = $width / 2;
        $y_center = $height / 2;
        $x_axis = $x_center - ($new_width / 2);
        $y_axis = $y_center - ($new_height / 2);

        $config['image_library'] = 'GD2';
        $config['source_image'] = $path;
        $config['maintain_ratio'] = FALSE;
        $config['width'] = $new_width;
        $config['height'] = $new_height;
        $config['x_axis'] = $x_axis;
        $config['y_axis'] = $y_axis;

        $this->initialize($config);
        $this->crop();
    }

}

?>
