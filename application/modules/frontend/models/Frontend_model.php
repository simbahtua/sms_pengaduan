<?php

class Frontend_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_list_inbox() {
        $query = $this->db->get('message_in', 10);
        return $query->result();
    }

}
