<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    } 

    public function get_admin_details() {
        return $this->db->get_where('users', array('role_id' => 1));
    }

    public function get_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        $this->db->where(array('role_id' => 2));
        // $this->db->where('is_instructor', 0);
        return $this->db->get('users');
    }

    public function get_only_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        $this->db->where(array('role_id' => 2, 'is_instructor' => '0'));
        // $this->db->where('is_instructor', 0);
        return $this->db->get('users');
    }
    
    public function get_insructors_list($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        $this->db->where(array('role_id' => 2, 'is_instructor' => '1'));
        // $this->db->where('is_instructor', 0);
        return $this->db->get('users');
    }

    public function get_all_user($user_id = 0) {
        if ($user_id > 0) {
            $this->db->where('id', $user_id);
        }
        return $this->db->get('users');
    }

    public function add_user() {
        $validity = $this->check_duplication('on_create', $this->input->post('email'));
        if ($validity == false) {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }else {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));
            $data['email'] = html_escape($this->input->post('email'));
            $data['password'] = sha1(html_escape($this->input->post('password')));
            $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
            $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_link);
            $data['biography'] = $this->input->post('biography');
            $data['role_id'] = 2;
            $data['date_added'] = strtotime(date("Y-m-d H:i:s"));
            $data['wishlist'] = json_encode(array());
            $data['watch_history'] = json_encode(array());
            $data['status'] = 1;
            // Add paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Add Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);

            $this->db->insert('users', $data);
            $user_id = $this->db->insert_id();
            $this->upload_user_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('user_added_successfully'));
        }
    }

    public function check_duplication($action = "", $email = "", $user_id = "") {
        $duplicate_email_check = $this->db->get_where('users', array('email' => $email));

        if ($action == 'on_create') {
            if ($duplicate_email_check->num_rows() > 0) {
                return false;
            }else {
                return true;
            }
        }elseif ($action == 'on_update') {
            if ($duplicate_email_check->num_rows() > 0) {
                if ($duplicate_email_check->row()->id == $user_id) {
                    return true;
                }else {
                    return false;
                }
            }else {
                return true;
            }
        }
    }

    public function edit_user($user_id = "") { // Admin does this editing
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            $data['first_name'] = html_escape($this->input->post('first_name'));
            $data['last_name'] = html_escape($this->input->post('last_name'));

            if (isset($_POST['email'])) {
                $data['email'] = html_escape($this->input->post('email'));
            }
            $data['gender'] = html_escape($this->input->post('gender'));
            $data['lga'] = html_escape($this->input->post('lga'));
            $data['state'] = html_escape($this->input->post('state'));
            $data['nationality'] = html_escape($this->input->post('nationality'));
            $data['address'] = html_escape($this->input->post('address'));
            $data['phone'] = html_escape($this->input->post('phone'));
            $data['genotype'] = html_escape($this->input->post('genotype'));
            $data['blood_group'] = html_escape($this->input->post('blood_group'));
            $data['allergies'] = html_escape($this->input->post('allergies'));

            $social_link['facebook'] = html_escape($this->input->post('facebook_link'));
            $social_link['twitter'] = html_escape($this->input->post('twitter_link'));
            $social_link['linkedin'] = html_escape($this->input->post('linkedin_link'));
            $data['social_links'] = json_encode($social_link);
            $data['biography'] = $this->input->post('biography');
            $data['title'] = html_escape($this->input->post('title'));

            // $data['category'] = html_escape($this->input->post('category'));
            // $data['class_option'] = html_escape($this->input->post('class_option'));
            if(isset($_POST['userstsatstus'])){
                $data['status'] = html_escape($this->input->post('userstsatstus'));                
            }
            $data['last_modified'] = strtotime(date("Y-m-d H:i:s"));

            // Update paypal keys
            $paypal_info = array();
            $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
            array_push($paypal_info, $paypal);
            $data['paypal_keys'] = json_encode($paypal_info);
            // Update Stripe keys
            $stripe_info = array();
            $stripe_keys = array(
                'public_live_key' => html_escape($this->input->post('stripe_public_key')),
                'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
            );
            array_push($stripe_info, $stripe_keys);
            $data['stripe_keys'] = json_encode($stripe_info);
            
            $this->db->select('*');
            $this->db->distinct("enrolled_status");
            $this->db->from('users');
            $this->db->where('id', $user_id);
            $enroled = $this->db->get();
            $enroled_statusd = $enroled->row();
            $enroled_status = $enroled->num_rows();
            if($enroled_status > 0){
                $e_status = $enroled_statusd->enrolled_status;
                $category = $enroled_statusd->category;
                $class_opt = get_phrase($enroled_statusd->class_options);
                if($e_status == 0 && $data['status'] == 1){
                    $this->db->select('id');
                    $this->db->distinct("id");
                    $this->db->from('category');
                    $this->db->where('name', $class_opt);
                    $dbcat = $this->db->get();
                    $dbcat_data = $dbcat->row();
                    // $numb = ;
                    
                    if ($dbcat->num_rows() > 0) {
                        $dbcat_data_id = $dbcat_data->id;
                        
                        $this->db->select('id');
                        $this->db->distinct('id');
                        $this->db->from('category');
                        $this->db->where('parent', $dbcat_data_id);
                        $list = $this->db->get();
                        $course_exist_id = "";
                        $count = 0;
                        $listdata = $list->result_array();
                        foreach($listdata as $repdata){
                            $hid = $repdata['id'];
                            $this->db->select('*');
                            // $this->db->distinct("id");
                            $this->db->from('course');
                            $this->db->where('sub_category_id', $hid);
                            $course_exist = $this->db->get();
                            $course_exist_id_row = $course_exist->result_array();
                            
                            if($course_exist->num_rows() > 0){
                                foreach($course_exist_id_row as $llist){
                                    $course_exist_id = $llist['id'];
                                    $enrol_data['course_id'] = $course_exist_id;
                                    $enrol_data['user_id'] = $user_id;
                                    $check = $this->db->get_where('enrol', $enrol_data);
                                    if ($check->num_rows() > 0) {
                                        
                                    }else {
                                        $enrol_data['date_added'] = strtotime(date('D, d-M-Y'));
                                        $this->db->insert('enrol', $enrol_data);
                                    }
                                }
                                // $newdata = array();
                                // $newdata['enrolled_status'] = 1;
                                $this->db->where('id', $user_id);
                                $this->db->update('users', array('enrolled_status' => 1));
                            }
                        }
                    }
                    
                }
            }
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->upload_user_image($user_id);
            $this->session->set_flashdata('flash_message', get_phrase('successfully_update_profile'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }

        $this->upload_user_image($user_id);
    }
    
    public function delete_user($user_id = "") {
        $this->db->where('id', $user_id);
        $this->db->delete('users');
        $this->session->set_flashdata('flash_message', get_phrase('user_deleted_successfully'));
    }
    
    public function activate_users($user_id = "") {
        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => '1'));
        $this->session->set_flashdata('flash_message', get_phrase('user_activated_successfully'));
    }
    
    public function deactivate_user($user_id = "") {
        if($user_id !== ""){
            $this->db->where('user_id', $user_id);
            $this->db->delete('enrol');
        }
        $this->db->where('id', $user_id);
        $this->db->update('users', array('status' => '0'));
        $this->session->set_flashdata('flash_message', get_phrase('user_deactivated_successfully'));
    }

    public function unlock_screen_by_password($password = "") {
        $password = sha1($password);
        return $this->db->get_where('users', array('id' => $this->session->userdata('user_id'), 'password' => $password))->num_rows();
    }

    public function register_user($data) {
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function my_courses() {
        return $this->db->get_where('enrol', array('user_id' => $this->session->userdata('user_id')));
    }

    public function get_result_logs($user = array(), $param2 = '') {
        if($param2 == ''){
            $all_logs = $this->db->get_where('report_log', array('sid' => $user['id'], 'status' => '1'));
        }else{
            $all_logs = $this->db->get_where('report_log', array('sid' => $user['id'], 'id' => $param2, 'status' => '1'));
        }
        return $all_logs;
    }

    public function get_results($parent_id = "", $class_op = "") {
        if($parent_id != '' && $class_op != ''){
            if($class_op == 'primary'){
                return $this->db->get_where('report', array('parent_id' => $parent_id));
            }else{
                return $this->db->get_where('report_preschool', array('parent_id' => $parent_id));
            }
        }
    }
    
    public function get_written_evaluation_by_userid($user_id)
    {
        if($user_id !== ""){
    	    // $evaluation = $this->db->get_where('users');
        	$user_evaluation_ids = array();
        	$user_details = $this->get_user($user_id)->row_array();
        	$class_opt = get_phrase($user_details['class_options']);
        	$evaluation = $this->db->get_where('evaluation', array('status' => '1'));
        	if($evaluation->num_rows() > 0){
            	foreach ($evaluation->result_array() as $query) {
            		$evaluation_category = $query['category'];
            		$evaluation_id = $query['id'];
            		$get_category_with_id = $this->db->get_where('category', array('id' => $evaluation_category))->row_array();
            		$get_parent_name_with_categoryId = $this->db->get_where('category', array('id' => $get_category_with_id['parent'], 'parent' => '0'))->row_array();
            		$category_name = get_phrase($get_parent_name_with_categoryId['name']);
            		if ($class_opt == $category_name) {
            			if(!in_array($evaluation_id, $user_evaluation_ids)){
            				array_push($user_evaluation_ids, $evaluation_id);
            			}
            		}
            	}
        	}
        	return $user_evaluation_ids;
        }
    }
    
    public function study_history() {
        return $this->db->get_where('study', array('user_id' => $this->session->userdata('user_id')));
    }

    public function upload_user_image($user_id) {
        if (isset($_FILES['user_image']) && $_FILES['user_image']['name'] != "") {
            move_uploaded_file($_FILES['user_image']['tmp_name'], 'uploads/user_image/'.$user_id.'.jpg');
            $this->session->set_flashdata('flash_message', get_phrase('user_update_successfully'));
        }
    }

    public function update_account_settings($user_id) {
        $validity = $this->check_duplication('on_update', $this->input->post('email'), $user_id);
        if ($validity) {
            if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
                $user_details = $this->get_user($user_id)->row_array();
                $current_password = $this->input->post('current_password');
                $new_password = $this->input->post('new_password');
                $confirm_password = $this->input->post('confirm_password');
                if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                    $data['password'] = sha1($new_password);
                }else {
                    $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                    return;
                }
            }
            $data['email'] = html_escape($this->input->post('email'));
            $this->db->where('id', $user_id);
            $this->db->update('users', $data);
            $this->session->set_flashdata('flash_message', get_phrase('updated_successfully'));
        }else {
            $this->session->set_flashdata('error_message', get_phrase('email_duplication'));
        }
    }

    public function change_password($user_id) {
        $data = array();
        if (!empty($_POST['current_password']) && !empty($_POST['new_password']) && !empty($_POST['confirm_password'])) {
            $user_details = $this->get_all_user($user_id)->row_array();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');
            $confirm_password = $this->input->post('confirm_password');

            if ($user_details['password'] == sha1($current_password) && $new_password == $confirm_password) {
                $data['password'] = sha1($new_password);
            }else {
                $this->session->set_flashdata('error_message', get_phrase('mismatch_password'));
                return;
            }
        }

        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
        $this->session->set_flashdata('flash_message', get_phrase('password_updated'));
    }


    public function get_instructor($id = 0) {
        if ($id > 0) {
            return $this->db->get_all_user($id);
        }else {
            if ($this->check_if_instructor_exists()) {
                $this->db->select('user_id');
                $this->db->distinct('user_id');
                $query_result =  $this->db->get('course');
                $ids = array();
                foreach ($query_result->result_array() as $query) {
                    if ($query['user_id']) {
                        array_push($ids, $query['user_id']);
                    }
                }

                $this->db->where_in('id', $ids);
                return $this->db->get('users')->result_array();
            }
            else {
                return array();
            }
        }
    }

    public function check_if_instructor_exists() {
        $this->db->where('user_id >', 0);
        $result = $this->db->get('course')->num_rows();
        if ($result > 0) {
            return true;
        }else {
            return false;
        }
    }

    public function get_user_image_url($user_id) {

         if (file_exists('uploads/user_image/'.$user_id.'.jpg'))
             return base_url().'uploads/user_image/'.$user_id.'.jpg';
        else
            return base_url().'uploads/user_image/placeholder.png';
    }
    public function get_instructor_list() {
        $query1 = $this->db->get_where('course', array('status' => 'active'))->result_array();
        $instructor_ids = array();
        $query_result = array();
        foreach ($query1 as $row1) {
            if (!in_array($row1['user_id'], $instructor_ids) && $row1['user_id'] != "") {
                array_push($instructor_ids, $row1['user_id']);
            }
        }
        if (count($instructor_ids) > 0) {
            $this->db->where_in('id', $instructor_ids);
            $query_result = $this->db->get('users');
        }else {
            $query_result = $this->get_admin_details();
        }

        return $query_result;
    }

    public function update_instructor_paypal_settings($user_id = '') {
        // Update paypal keys
        $paypal_info = array();
        $paypal['production_client_id'] = html_escape($this->input->post('paypal_client_id'));
        array_push($paypal_info, $paypal);
        $data['paypal_keys'] = json_encode($paypal_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
    public function update_instructor_stripe_settings($user_id = '') {
        // Update Stripe keys
        $stripe_info = array();
        $stripe_keys = array(
            'public_live_key' => html_escape($this->input->post('stripe_public_key')),
            'secret_live_key' => html_escape($this->input->post('stripe_secret_key'))
        );
        array_push($stripe_info, $stripe_keys);
        $data['stripe_keys'] = json_encode($stripe_info);
        $this->db->where('id', $user_id);
        $this->db->update('users', $data);
    }
}
