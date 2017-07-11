<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 *
 */
class App_lib
{
    var $CI;
    function __construct()
    {
        $this->CI = & get_instance();
        $this->CI->load->database();
    }

    function get_users_groups_menu($group_id) {
    	$add_where = '';
    	if($group_id != 1) {
    		$add_where = array('group_id' => $group_id);
    	}

    	$this->CI->db->select('menu.id, menu.parent_id, menu.name, menu.order_by, menu.class, menu.link');
    	$this->CI->db->where('is_active',1);
    	($add_where == '') ? '' : $this->CI->db->where($add_where);
    	$this->CI->db->order_by('menu.parent_id ASC', 'menu.order_by ASC');
    	$this->CI->db->join('users_menu as menu','menu.id = menu_id','inner');
    	$query = $this->CI->db->get('group_privileges');
    	die($this->CI->db->last_query());

    }

    function get_query_data($params) {
        extract($this->get_query_condition($params));
        $sql = "
            SELECT SQL_CALC_FOUND_ROWS * FROM(
                SELECT  $select
                FROM $table
                $join
                $where_detail
                $group_by_detail
            ) result
            $where
            $group_by
            $sort
            $limit
        ";


        $query = $this->CI->db->query($sql);
        $total = $this->CI->db->query('SELECT FOUND_ROWS() as total')->row()->total;
        $output['data'] = $query;
        $output['total'] = $total;
        return $output;
    }

    function get_query_condition($params) {
        $arr_condition = array();

        $arr_condition['parent_select'] = "*";

        if (isset($params['parent_select'])) {
            $arr_condition['parent_select'] = $params['parent_select'];
        }

        $arr_condition['table'] = "";
        if (isset($params['table'])) {
            $arr_condition['table'] = $params['table'];
        }

        $arr_condition['select'] = "*";
        if (isset($params['select'])) {
            $arr_condition['select'] = $params['select'];
        }

        $arr_condition['join'] = "";
        if (isset($params['join'])) {
            $arr_condition['join'] = $params['join'];
        }

        $arr_condition['where_detail'] = " WHERE 1 ";
        if (isset($params['where_detail'])) {
            $arr_condition['where_detail'] .= "AND " . $params['where_detail'];
        }

        $arr_condition['group_by_detail'] = "";
        if (isset($params['group_by_detail'])) {
            $arr_condition['group_by_detail'] = "GROUP BY " . $params['group_by_detail'];
        }

        $arr_condition['where'] = " WHERE 1 ";
        if (isset($params['query']) && $params['query'] != false && $params['query'] != '') {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " LIKE '%" . mysql_real_escape_string($params['query']) . "%' ";
        } elseif (isset($params['optionused']) && $params['optionused'] == 'true') {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " = '" . $params['option'] . "' ";
        } elseif ((isset($params['date_start']) && $params['date_start'] != false) && (isset($params['date_end'])) && $params['date_end'] != false) {
            $arr_condition['where'] .= "AND DATE(" . $params['qtype'] . ") BETWEEN '" . mysql_real_escape_string($params['date_start']) . "' AND '" . mysql_real_escape_string($params['date_end']) . "' ";
        } elseif ((isset($params['num_start']) && $params['num_start'] != false) && (isset($params['num_end'])) && $params['num_end'] != false) {
            $arr_condition['where'] .= "AND " . $params['qtype'] . " BETWEEN '" . mysql_real_escape_string($params['num_start']) . "' AND '" . mysql_real_escape_string($params['num_end']) . "' ";
        }

        if (isset($params['where'])) {
            $arr_condition['where'] .= "AND " . $params['where'];
        }

        $arr_condition['group_by'] = "";
        if (isset($params['group_by'])) {
            $arr_condition['group_by'] = "GROUP BY " . $params['group_by'];
        }

        $arr_condition['sort'] = "";
        if (isset($params['sortname']) && isset($params['sortorder'])) {
            $arr_condition['sort'] = "ORDER BY " . $params['sortname'] . " " . $params['sortorder'];
        }

        $arr_condition['limit'] = "";
        if (isset($params['rp'])) {
            $offset = (($params['page'] - 1) * $params['rp']);
            $arr_condition['limit'] = "LIMIT $offset, " . $params['rp'];
        }

        return $arr_condition;
    }

    function get_zenziva_config() {
        $this->CI->db->order_by('id', 'desc');
        $this->CI->db->limit(1);
        $query = $this->CI->db->get('zenziva_cnf');
        return $query;
    }


    /**
    *   params command
    *   params command


    */
    function zenziva_service($params = array()) {

        if(!empty($params) || count($params) > 0) {
            $add_command = $params['command'] . '.php';
        }else {
            $add_command = 'credit.php';
        }

        $zenziva_config = $this->get_zenziva_config()->row();

        $params['userkey'] = $zenziva_config->userkey;
        $params['passkey'] = $zenziva_config->keyword;

        $url = "http://pengaduan.zenziva.co.id/api/".$add_command;

        $curlHandle = curl_init();
        curl_setopt($curlHandle, CURLOPT_URL, $url);
        curl_setopt($curlHandle, CURLOPT_POSTFIELDS, http_build_query($params));
        curl_setopt($curlHandle, CURLOPT_HEADER, 0);
        curl_setopt($curlHandle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlHandle, CURLOPT_TIMEOUT, 30);
        curl_setopt($curlHandle, CURLOPT_POST, 1);
        $response = curl_exec($curlHandle);

$xml_string = <<<XML
$response
XML;
        curl_close($curlHandle);

        $sXML = simplexml_load_string($xml_string,"SimpleXMLElement", LIBXML_NOCDATA);

        return $sXML;

    }

    function get_one($table_name = '', $fieldname = null, $where = null, $fieldsort = null, $sort = 'asc') {
        $this->CI->db->select($fieldname);
        if ($where != null) {
            $this->CI->db->where($where);
        }
        if ($fieldsort == null) {
            $fieldsort = $fieldname;
        }
        $this->CI->db->order_by($fieldsort, $sort);
        $this->CI->db->offset(0);
        $this->CI->db->limit(1);
        $query = $this->CI->db->get($table_name);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $result = $row->$fieldname;
        } else {
            $result = '';
        }
        return $result;
    }

    function insert_data($table_name, $data) {
        $this->CI->db->insert($table_name, $data);
        return $this->CI->db->insert_id();
    }

    function insert_ignore_data($table_name, $data) {
        $this->CI->db->insert_ignore($table_name, $data);
        return $this->CI->db->insert_id();
    }

    function update_data($table_name, $fieldname, $value_id, $data) {
        $this->CI->db->where($fieldname, $value_id);
        $this->CI->db->update($table_name, $data);
    }

    function delete_data($table_name, $fieldname, $value_id) {
        $this->CI->db->where($fieldname, $value_id);
        $this->CI->db->delete($table_name);
    }

    function get_detail_data($table_name, $fieldname, $value_id) {
        $this->CI->db->where($fieldname, $value_id);
        return $this->CI->db->get($table_name);
    }
}


    /* End of file App_lib.php */
    /* Location: ./system/application/libraries/App_lib.php */
