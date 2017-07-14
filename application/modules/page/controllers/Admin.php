<?php

/**
 *
 */
class Admin extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index() {
        echo date('Y-m-d', 1497805200);
    }
}
