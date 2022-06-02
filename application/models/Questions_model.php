<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Question_model extends CI_Model {
	function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    } 

    public function get_all_categories($categories = array()) {
    	echo 'all_good';
    	// if(isset($categories['status']) && isset($categories['post'])){
     //        $id = html_escape($details['post']);
     //        $data['status'] = (html_escape($details['status']) == "true") ? '1' : '0';
     //        $this->db->where('id', $id);
     //        $this->db->update('report_log', $data);
     //        echo "sucess";
     //    }else{
     //        echo "failled";
     //    }
    }
}
?>