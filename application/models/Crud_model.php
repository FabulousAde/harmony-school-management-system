<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Crud_model extends CI_Model {

    function __construct()
    {
        parent::__construct();
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    
    public function get_user_category_by_user_id() {
        $enroled_statusd = $this->db->get_where('users', array('id' => $this->session->userdata('user_id')));
            // $this->db->select('*');
            // $this->db->distinct("enrolled_status");
            // $this->db->from('users');
            // $this->db->where('id', $this->session->userdata('user_id'));
            // $enroled = $this->db->get();
            // $enroled_statusd = $enroled->row();
            $enroled_status = $enroled_statusd->num_rows();
            // echo $enroled_statusd->row()->class_options;
            if($enroled_status > 0){
                $e_status = $enroled_statusd->row()->enrolled_status;
                $category = $enroled_statusd->row()->category;
                $class_opt = get_phrase($enroled_statusd->row()->class_options);
                if($e_status == 1){
                    $this->db->select('id');
                    $this->db->distinct("id");
                    $this->db->from('category');
                    $this->db->where('name', $class_opt);
                    $dbcat = $this->db->get();
                    $dbcat_data = $dbcat->row();
                    
                    if ($dbcat->num_rows() > 0) {
                        $dbcat_data_id = $dbcat_data->id;
                        $categories = $this->crud_model->get_categories($dbcat_data_id)->result_array();
                    }
                }
            }
            return $categories;
    }
    
    public function get_allresources($param1 = "") {
        $this->db->order_by('id', 'desc');
        return $this->db->get('course_resources');
    }
    
    public function get_activities_resources($param1 = "") {
        $this->db->order_by('id', 'desc');
        return $this->db->get('activity_resources');
    }
    
    public function get_categories($param1 = "") {
        if ($param1 != "") {
            $this->db->where('id', $param1);
        }
        $this->db->where('parent', 0);
        return $this->db->get('category');
    }
    
    public function get_categories_by_userref($param1 = "", $param2 = "") {
        if ($param1 != "") {
            $this->db->where('id', $param1);
        }
        if($param2 != ""){
            $user_details = $this->user_model->get_user($param2)->row_array();
            $user_type = get_phrase($user_details['class_options']);
            $this->db->where('name', $user_type);
        }
        $this->db->where('parent', 0);
        return $this->db->get('category');
    }
    
    public function get_sub_category($param1 = "") {
        return $this->db->get_where('category', array('parent' => $param1));
    }

    public function get_category_details_by_id($id) {
        return $this->db->get_where('category', array('id' => $id));
    }

    public function get_category_id($slug = "") {
        $category_details = $this->db->get_where('category', array('slug' => $slug))->row_array();
        return $category_details['id'];
    }
    
    public function get_all_evaluation() {
        return $this->db->get('evaluation');
    }
    
    public function get_evaluation_by_id($id = "", $getter = "") {
        if($getter != ""){
            return $this->db->get_where('evaluation', array("course_id" => $id));
        }else{
            return $this->db->get_where('evaluation', array('id' => $id));
        }
    }
    
    public function get_all_submitedevaluation($id = "", $user_id = "") {
        if($user_id == ""){
            return $this->db->get_where('evaluation_answer', array('evaluation_id' => $id));
        }
        return $this->db->get_where('evaluation_answer', array('evaluation_id' => $id, 'user_id' => $user_id));
    }
    
    public function get_all_markedevaluation($id = "") {
        return $this->db->get_where('evaluation_answer', array('evaluation_id' => $id, 'marked' => '1'));
    }
    
    public function check_for_userevalution($param1 = "", $param2 = "") {
        $getexist = $this->db->get_where('evaluation_answer', array('user_id' => $param1, 'evaluation_id' => $param2));
        if($getexist->num_rows() > 0){
            $tt = $getexist->row_array();
            if($tt['marked'] == 0){
                return 'submitted';
            }else if($tt['marked'] == 1){
                return 'marked';
            }
        }else{
            return false;
        }
    }

    public function add_category() {
        $data['code']   = html_escape($this->input->post('code'));
        $data['name']   = html_escape($this->input->post('name'));
        $data['parent'] = html_escape($this->input->post('parent'));
        $data['slug']   = slugify(html_escape($this->input->post('name')));
        if ($this->input->post('parent') == 0) {
            // Font awesome class adding
            if ($_POST['font_awesome_class'] != "") {
                $data['font_awesome_class'] = html_escape($this->input->post('font_awesome_class'));
            }else {
                $data['font_awesome_class'] = 'fas fa-chess';
            }

            // category thumbnail adding
            if (!file_exists('uploads/thumbnails/category_thumbnails')) {
                mkdir('uploads/thumbnails/category_thumbnails', 0777, true);
            }
            if ($_FILES['category_thumbnail']['name'] == "") {
                $data['thumbnail'] = 'category-thumbnail.png';
            }else {
                $data['thumbnail'] = md5(rand(10000000, 20000000)).'.jpg';
                move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/thumbnails/category_thumbnails/'.$data['thumbnail']);
            }
        }
        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $this->db->insert('category', $data);
    }
    
    public function save_instructor() {
        $category_id = html_escape($this->input->post('categry_id'));
        $instructr_id = html_escape($this->input->post('user_id'));
        $get_cat = $this->get_categories($category_id)->row_array();
        $data['class_options'] = underscore($get_cat['name']);
        $data['is_instructor'] = '1';
        if($instructr_id > 0){
            $this->db->where('id',$instructr_id);
            $this->db->update('users', $data);
        }
    }
    
    public function deactivate_instructor($param1 = "") {
        $data['is_instructor'] = '0';
        $this->db->where('id', $param1);
        $this->db->update('users', $data);
    }
    
    public function add_study($param1, $param3, $param4) {
        $userid = $this->session->userdata('user_id');
        $totalcorrect_answer = html_escape($param1);
        $data['user_id'] = $userid;
        $data['course_id'] = $param3;
        $data['date_studied'] = time();
        $data['n_ofstudy'] = $param4;
        $data['date_laststudy'] = time();
        $data['score_obtained'] = $totalcorrect_answer;
        $this->db->insert('study', $data);
        // $data['user_id'] = html_escape($this->input->post(''));
        
    }
    
    public function save_result() {
        $data['sid'] = html_escape($this->input->post('student_id'));
        
        $user = $this->user_model->get_user($data['sid'])->row_array();
        $getcat = $this->crud_model->get_categories_by_userref('', $user['id'])->row_array();
        $subcat = $this->crud_model->get_sub_category($getcat['id'])->result_array();
        $prelog['sid'] = $user['id'];
        $prelog['class_category'] = $user['category'];
        $prelog['session'] = html_escape($this->input->post('session'));
        $prelog['year_session'] = html_escape($this->input->post('year'));
        $prelog['review'] = html_escape($this->input->post('review'));
        $prelog['instructor_id'] = $this->session->userdata('user_id');
        $prelog['admin_review'] = html_escape($this->input->post('admin0_review'));
        $prelog['class'] = $user['class_options'];
        
        $prelog['total_sopen'] = html_escape($this->input->post('time_school_opened'));
        $prelog['time_present'] = html_escape($this->input->post('time_present'));
        $prelog['time_absent'] = html_escape($this->input->post('time_absent'));
        $prelog['date_resume'] = html_escape($this->input->post('dpd1'));
        $prelog['grand_total'] = html_escape($this->input->post('grand_total'));
        $prelog['average'] = html_escape($this->input->post('average'));
        $prelog['is_promoted'] = html_escape($this->input->post('promoted'));
        $this->db->insert('report_log', $prelog);
        $data['parent_id'] = $this->db->insert_id();
        if($user['category'] != 'preschool'){
            foreach($subcat as $key => $cat){
                $data['course_name'] = html_escape($cat['name']);
                $data['cat1'] = html_escape($this->input->post($cat['id'].'_cat1'));
                $data['cat2'] = html_escape($this->input->post($cat['id'].'_cat2'));
                $data['cat3'] = html_escape($this->input->post($cat['id'].'_cat3'));
                $data['cat4'] = html_escape($this->input->post($cat['id'].'_cat4'));
                $data['exam_score'] = html_escape($this->input->post($cat['id'].'_exam_score'));
                $data['total_scores'] = html_escape($this->input->post($cat['id'].'_total'));
                $data['grade'] = html_escape($this->input->post($cat['id'].'_grade'));
                $data['session'] = html_escape($this->input->post('session'));
                $data['year_session'] = html_escape($this->input->post('year'));
                $this->db->insert('report', $data);
            }
        }else{
            foreach($subcat as $key => $cat){
                $data['course_name'] = html_escape($cat['name']);
                $data['review'] = html_escape($this->input->post($cat['id'].'_review'));
                $data['grade'] = html_escape($this->input->post($cat['id'].'_grade'));
                $data['session'] = html_escape($this->input->post('session'));
                $data['year_session'] = html_escape($this->input->post('year'));
                $this->db->insert('report_preschool', $data);
            }
        }
    }
    
    public function update_result($param1 = array()) {
        $prelog['session'] = html_escape($this->input->post('session'));
        $prelog['year_session'] = html_escape($this->input->post('year'));
        $prelog['review'] = html_escape($this->input->post('review'));
        if(isset($_POST['admin0_review'])){
            $prelog['admin_review'] = html_escape($this->input->post('admin0_review'));
        }
        $prelog['total_sopen'] = html_escape($this->input->post('time_school_opened'));
        $prelog['time_present'] = html_escape($this->input->post('time_present'));
        $prelog['time_absent'] = html_escape($this->input->post('time_absent'));
        $prelog['date_resume'] = html_escape($this->input->post('dpd1'));
        $prelog['grand_total'] = html_escape($this->input->post('grand_total'));
        $prelog['average'] = html_escape($this->input->post('average'));
        $prelog['is_promoted'] = html_escape($this->input->post('promoted'));
        $this->db->where('id', $param1['id']);
        $this->db->update('report_log', $prelog);
        $all_results = $this->get_results($param1['id'], $param1['class_category'])->result_array();
        if($param1['class_category'] != 'preschool'){
            foreach ($all_results as $key => $oldresult) {
                $form_coursename = html_escape($this->input->post('course_name_'.$key));
                $oldresultname = strtolower($oldresult['course_name']);
                if($oldresultname == $form_coursename){
                    $data['cat1'] = html_escape($this->input->post($oldresult['id'].'_cat1'));
                    $data['cat2'] = html_escape($this->input->post($oldresult['id'].'_cat2'));
                    $data['cat3'] = html_escape($this->input->post($oldresult['id'].'_cat3'));
                    $data['cat4'] = html_escape($this->input->post($oldresult['id'].'_cat4'));
                    $data['exam_score'] = html_escape($this->input->post($oldresult['id'].'_exam_score'));
                    $data['total_scores'] = html_escape($this->input->post($oldresult['id'].'_total'));
                    $data['grade'] = html_escape($this->input->post($oldresult['id'].'_grade'));
                    $data['session'] = html_escape($this->input->post('session'));
                    $data['year_session'] = html_escape($this->input->post('year'));
                    $this->db->where('id', $oldresult['id']);
                    $this->db->where('course_name', $oldresult['course_name']);
                    $this->db->where( 'parent_id', $param1['id']);
                    $this->db->update('report', $data);
                }
            }
        }else{
            foreach ($all_results as $key => $oldresult) {
                $form_coursename = html_escape($this->input->post('course_name_'.$key));
                $oldresultname = strtolower($oldresult['course_name']);
                if($oldresultname == $form_coursename){
                    $data['review'] = html_escape($this->input->post($oldresult['id'].'_review'));
                    $data['grade'] = html_escape($this->input->post($oldresult['id'].'_grade'));
                    $data['session'] = html_escape($this->input->post('session'));
                    $data['year_session'] = html_escape($this->input->post('year'));
                    $this->db->where('id', $oldresult['id']);
                    $this->db->where('course_name', $oldresult['course_name']);
                    $this->db->where( 'parent_id', $param1['id']);
                    $this->db->update('report_preschool', $data);
                }
            }
        }
    }

    public function update_result_status($details = array()){
        if(isset($details['status']) && isset($details['post'])){
            $id = html_escape($details['post']);
            $data['status'] = (html_escape($details['status']) == "true") ? '1' : '0';
            $this->db->where('id', $id);
            $this->db->update('report_log', $data);
            echo "sucess";
        }else{
            echo "failled";
        }
    }

    public function update_question_status($details = array()) {
        if(isset($details['status'])) {
            $data['value'] = (html_escape($details['status']) == "true") ? '1' : '0';
            $this->db->where('key', 'use_past_question');
            $this->db->update('settings', $data);
            echo "sucess";
        }else{
            echo "failled.";
        }
    }

    public function update_top_activity_status($details = array()) {
        if(isset($details['keyRef'])) {
            $data['is_top'] = '1';
            $this->db->update('activities', array('is_top' => '0'));

            $id = html_escape($details['keyRef']);
            $this->db->where('id', $id);
            $this->db->update('activities', $data);
            echo 'success';
        }else{
            echo "failled.";
        }
    }

    public function edit_category($param1) {
        $data['name']   = html_escape($this->input->post('name'));
        $data['parent'] = html_escape($this->input->post('parent'));
        $data['slug']   = slugify(html_escape($this->input->post('name')));
        if ($this->input->post('parent') == 0) {
            // Font awesome class adding
            if ($_POST['font_awesome_class'] != "") {
                $data['font_awesome_class'] = html_escape($this->input->post('font_awesome_class'));
            }else {
                $data['font_awesome_class'] = 'fas fa-chess';
            }
            // category thumbnail adding
            if (!file_exists('uploads/category_thumbnails')) {
                mkdir('uploads/category_thumbnails', 0777, true);
            }
            if ($_FILES['category_thumbnail']['name'] != "") {
                $data['thumbnail'] = md5(rand(10000000, 20000000)).'.jpg';
                move_uploaded_file($_FILES['category_thumbnail']['tmp_name'], 'uploads/thumbnails/category_thumbnails/'.$data['thumbnail']);
            }
        }
        $data['last_modified'] = strtotime(date('D, d-M-Y'));
        $this->db->where('id', $param1);
        $this->db->update('category', $data);
    }

    public function delete_category($category_id) {
        $this->db->where('id', $category_id);
        $this->db->delete('category');
    }

    public function get_sub_categories($parent_id = "") {
        return $this->db->get_where('category', array('parent' => $parent_id))->result_array();
    }

    public function get_top_activities() {
        return $this->db->get_where('activities', array('is_top' => '1'));
    }

    
    public function get_result_logs($user = array(), $param2 = '') {
        if($param2 == ''){
            $all_logs = $this->db->get_where('report_log', array('sid' => $user['id']));
        }else{
            $all_logs = $this->db->get_where('report_log', array('sid' => $user['id'], 'id' => $param2));
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

    public function delete_result($parent_id = "", $userid){
        $log = $this->db->get_where('report_log', array('id' => $parent_id, 'sid' => $userid))->row_array();
        if($log['class_category'] == 'primary'){
            $this->db->where('parent_id', $log['id']);
            $this->db->delete('report');
        }elseif ($log['class_category'] == 'preschool') {
            $this->db->where('parent_id', $log['id']);
            $this->db->delete('report_preschool');
        }
        $this->db->where('id', $log['id']);
        $this->db->delete('report_log');
    }
    

    public function enrol_history($course_id = "") {
        if ($course_id > 0) {
            return $this->db->get_where('enrol', array('course_id' => $course_id));
        }else {
            return $this->db->get('enrol');
        }
    }

    public function enrol_history_by_user_id($user_id = "") {
        return $this->db->get_where('enrol', array('user_id' => $user_id));
    }

    public function all_enrolled_student() {
        $this->db->select('user_id');
        $this->db->distinct('user_id');
        return $this->db->get('enrol');
    }

    public function enrol_history_by_date_range($timestamp_start = "", $timestamp_end = "") {
        $this->db->order_by('date_added' , 'desc');
        $this->db->where('date_added >=' , $timestamp_start);
        $this->db->where('date_added <=' , $timestamp_end);
        return $this->db->get('enrol');
    }

    public function get_revenue_by_user_type($timestamp_start = "", $timestamp_end = "", $revenue_type = "") {
        $course_ids = array();
        $courses    = array();
        $admin_details = $this->user_model->get_admin_details()->row_array();
        if ($revenue_type == 'admin_revenue') {
            //$this->db->where('user_id', $admin_details['id']);
        }elseif ($revenue_type == 'instructor_revenue') {
            $this->db->where('user_id !=', $admin_details['id']);
            $this->db->select('id');
            $courses = $this->db->get('course')->result_array();
            foreach ($courses as $course) {
                if (!in_array($course['id'], $course_ids)) {
                    array_push( $course_ids, $course['id'] );
                }
            }
            if (sizeof($course_ids)) {
                $this->db->where_in('course_id', $course_ids);
            }else {
                return array();
            }
        }

        $this->db->order_by('date_added' , 'desc');
        $this->db->where('date_added >=' , $timestamp_start);
        $this->db->where('date_added <=' , $timestamp_end);
        return $this->db->get('payment')->result_array();
    }

    //START OF EXPENSES MODEL

    public function get_expenses_by_user_type($timestamp_start = "", $timestamp_end = "", $expense_type = "") {
        $course_ids = array();
        $courses    = array();
        $admin_details = $this->user_model->get_admin_details()->row_array();
        if ($expense_type == 'expense_type') {
            //$this->db->where('user_id', $admin_details['id']);
        }elseif ($expense_type == 'instructor_revenue') {
            $this->db->where('user_id !=', $admin_details['id']);
            $this->db->select('id');
            $courses = $this->db->get('course')->result_array();
            foreach ($courses as $course) {
                if (!in_array($course['id'], $course_ids)) {
                    array_push( $course_ids, $course['id'] );
                }
            }
            if (sizeof($course_ids)) {
                $this->db->where_in('course_id', $course_ids);
            }else {
                return array();
            }
        }

        $this->db->order_by('date_added' , 'desc');
        $this->db->where('date_added >=' , $timestamp_start);
        $this->db->where('date_added <=' , $timestamp_end);
        return $this->db->get('payment')->result_array();
    }



    //END OF EXPENSES MODEL

    public function get_instructor_revenue($timestamp_start = "", $timestamp_end = "") {
        $course_ids = array();
        $courses    = array();

        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->select('id');
        $courses = $this->db->get('course')->result_array();
        foreach ($courses as $course) {
            if (!in_array($course['id'], $course_ids)) {
                array_push( $course_ids, $course['id'] );
            }
        }
        if (sizeof($course_ids)) {
            $this->db->where_in('course_id', $course_ids);
        }else {
            return array();
        }

        $this->db->order_by('date_added' , 'desc');
        $this->db->where('date_added >=' , $timestamp_start);
        $this->db->where('date_added <=' , $timestamp_end);
        return $this->db->get('payment')->result_array();
    }

    public function delete_payment_history($param1) {
        $this->db->where('id', $param1);
        $this->db->delete('payment');
    }
    public function delete_enrol_history($param1) {
        $this->db->where('id', $param1);
        $this->db->delete('enrol');
    }

    public function purchase_history($user_id) {
        if ($user_id > 0) {
            return $this->db->get_where('payment', array('user_id'=> $user_id));
        }else {
            return $this->db->get('payment');
        }
    }
    
    public function save_assignment($user_id, $assignment_id){
        $data['user_id'] = $user_id;
        // $data['attachment'] = "";
        $data['evaluation_id'] = $assignment_id;
        $data['date_added'] = strtotime(date('r'));
        if ($_FILES['student_assignment']['name'] == "") {
            $this->session->set_flashdata('error_message',get_phrase('invalid_attachment'));
            redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
        }else {
            $fileName           = $_FILES['student_assignment']['name'];
            $tmp                = explode('.', $fileName);
            $fileExtension      = end($tmp);
            $uploadable_file    =  md5(uniqid(rand(), true)).'.'.$fileExtension;
            $data['attachment'] = $uploadable_file;

            if (!file_exists('uploads/evaluation_files/users_e')) {
                mkdir('uploads/evaluation_files/users_e', 0777, true);
            }
            move_uploaded_file($_FILES['student_assignment']['tmp_name'], 'uploads/evaluation_files/users_e/'.$uploadable_file);
        }
        
        $this->db->insert('evaluation_answer', $data);
    }
    
    public function mark_evaluation($eval_data = array()) {
        $response = array();
        if(isset($eval_data['ol']) && isset($eval_data['divinput'])){
            $data['mark_obtain'] = $eval_data['divinput'];
            $data['marked'] = '1';
            $this->db->where('id', $eval_data['ol']);
            $this->db->update('evaluation_answer', $data);
            $response = "sucessfully_updated";
        }
        return $response;
    }

    public function get_all_qcategories($categories = array()) {
        $list = array();
        if(isset($categories['list']) && $categories['list'] != null){
            $category_list = $categories['list'];
            foreach ($category_list as $key => $category) {
                $category_courses = $this->db->get_where('course', array('sub_category_id' => $category))->result_array();
                foreach ($category_courses as $catkey => $cc) {
                    $id = $cc['id'];
                    $course = $this->db->get_where('lesson', array('course_id' => $id))->result_array();
                    foreach ($course as $keys => $main_course) {
                        if($main_course['lesson_type'] == 'quiz') {
                            array_push($list, $main_course['id']);
                        }
                    }
                }
            }

            return $list;

            // echo count($list[0]);
            // $id = html_escape($details['post']);
            // $data['status'] = (html_escape($details['status']) == "true") ? '1' : '0';
            // $this->db->where('id', $id);
            // $this->db->update('report_log', $data);
        }else{
            echo array();
        }
    }
    
    public function get_activities($id = "") {
        if($id == ''){
            $this->db->from('activities');
            return $this->db->get();
        }else{
            return $this->db->get_where('activities', array('id' => $id));
        }
    }
    
    public function save_newactivity($editid = '') {
        $data['tittle'] = html_escape($this->input->post('activities_name'));
        $data['note'] = html_escape($this->input->post('activity_note'));
        $data['reource_loc'] = html_escape($this->input->post('search_resources'));
        $data['activity_year'] = html_escape($this->input->post('year'));
        $data['activity_session'] = html_escape($this->input->post('session'));
        $data['start_date'] = html_escape($this->input->post('dpd1'));
        $data['end_date'] = html_escape($this->input->post('dpd2'));
        if($editid == ''){
            $this->db->insert('activities', $data);
        }else{
            $this->db->where('id', $editid);
            $this->db->update('activities', $data);
        }
    }
    
    public function delete_activities($deleteid) {
        $this->db->where('id', $deleteid);
        $this->db->delete('activities');
    }
    
    // public function get_results($id = "") {
    //     if($id == ''){
    //         $this->db->from('activities');
    //         return $this->db->get();
    //     }else{
    //         return $this->db->get_where('activities', array('id' => $id));
    //     }
    // }

    public function send_newsletter() {
        $email = array();
        $msg = $this->input->post('message');
        $email_subject = html_escape($this->input->post('subject'));
        $recepient = html_escape($this->input->post('recepients'));
        $email_split = explode(',', $recepient);
        foreach ($email_split as $key => $emailList) {
            if($emailList == null || $emailList == '') return null;
            array_push($email, $emailList);
        }
        $this->email_model->send_newsLetter($msg, $email, $email_subject);
    }

    public function get_notes($note_id = ''){
        if($note_id == ''){
            if($this->session->userdata('admin_login') != true){
                $user = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
                return $this->db->get_where('l_notes', array('category_added' => $user['class_options']));
            }else{
                return $this->db->get('l_notes');
            }
        }else{
            return $this->db->get_where('l_notes', array('id' => $note_id));
        }
    }

    public function delete_note($id = ''){
        $note = $this->get_notes($id)->row_array();
        if(unlink($note['stored_location'])){
            $this->db->where('id', $id);
            $this->db->delete('l_notes');
        }
    }

    public function upload_lnote(){
        $file = $_FILES['resource_file_selection'];
        $cusom_name = $_POST['file_custom_name'];
        $savename = $this->session->userdata('user_id').'_'.$file['name'];
        if (!file_exists('uploads/core/lessonnotes')) {
            mkdir('uploads/core/lessonnotes', 0777, true);
        }
        $path = "uploads/core/lessonnotes/$savename";

        if(move_uploaded_file($file['tmp_name'], $path)){
            $data = array();
            $data['tittle'] = $cusom_name;
            $data['stored_location'] = $path;
            if ($this->session->userdata('admin_login') == true) {
                $data['category_added'] = html_escape($this->input->post('main_category'));
            }else{
                $user = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
                $data['category_added'] = $user['class_options'];
            }
            $data['instructors_id'] = $this->session->userdata('user_id');
            $data['time_saved'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('l_notes', $data);
            
            return 'note_added_sucessfully';
        }else{
            return 'note_not_uploaded';
        }
    }
    
    public function submit_promotion($data = array()) {
        $response = array();
        if(isset($data['uid']) && isset($data['cid'])){
            $uid = $data['uid'];
            $cid = $data['cid'];
            $get_cat = $this->get_categories($cid)->row_array();
            $undr = underscore($get_cat['name']);
            $this->db->where('id', $uid);
            $this->db->update('users', array('class_options' => $undr));
            $response = "sucessfully_updated";
        }
        return $response;
    }
    
    public function add_evaluation($course_id = "") {
        $data['evaluation_tittle'] = html_escape($this->input->post('evaluation_tittle'));
        $get_course = $this->get_course_by_id($course_id)->row_array();
        $data['category'] = $get_course['sub_category_id'];
        // $data['category'] = html_escape($this->input->post('sub_category_id'));
        // $data['type'] = html_escape($this->input->post('evaluation_type'));
        // $data['file_attachment'] = html_escape($this->input->post('attachment'));
        $data['course_id'] = $course_id;
        $data['section_id'] = html_escape($this->input->post('section_id'));
        $lesson_type_array = explode('-', $this->input->post('evaluation_type'));
        $lesson_type = $lesson_type_array[0];

        // $data['attachment_type'] = $lesson_type_array[1];
        $data['type'] = $lesson_type;
        $data['date_saved'] = strtotime(date('r'));
        $data['description'] = html_escape($this->input->post('evaluation_description'));
        
        
        if ($_FILES['attachment']['name'] == "") {
            $this->session->set_flashdata('error_message',get_phrase('invalid_attachment'));
            redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
        }else {
            $fileName           = $_FILES['attachment']['name'];
            $tmp                = explode('.', $fileName);
            $fileExtension      = end($tmp);
            $uploadable_file    =  md5(uniqid(rand(), true)).'.'.$fileExtension;
            $data['file_attachment'] = $uploadable_file;

            if (!file_exists('uploads/evaluation_files')) {
                mkdir('uploads/evaluation_files', 0777, true);
            }
            move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/evaluation_files/'.$uploadable_file);
        }
        
        if($this->db->insert('evaluation', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function edit_evaluation($evaluation_id = "") {
        $data['evaluation_tittle'] = html_escape($this->input->post('evaluation_tittle'));
        $data['section_id'] = html_escape($this->input->post('section_id'));
        $data['date_modified'] = strtotime(date('r'));
        $data['description'] = html_escape($this->input->post('evaluation_description'));
        $data['status'] = html_escape($this->input->post('status'));
        
        if ($_FILES['attachment']['name'] == "") {
            // $this->session->set_flashdata('error_message',get_phrase('invalid_attachment'));
            // redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
        }else {
            $fileName           = $_FILES['attachment']['name'];
            $tmp                = explode('.', $fileName);
            $fileExtension      = end($tmp);
            $uploadable_file    =  md5(uniqid(rand(), true)).'.'.$fileExtension;
            $data['file_attachment'] = $uploadable_file;
            $db_fileloc = $this->db->get_where('evaluation', array('id' => $evaluation_id))->row_array();
            $fileloc = $db_fileloc['file_attachment'];

            if (!file_exists('uploads/evaluation_files')) {
                mkdir('uploads/evaluation_files', 0777, true);
            }
            if(!unlink('uploads/evaluation_files/'.$fileloc)){
                return false;
            }
            move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/evaluation_files/'.$uploadable_file);
            
        }
        $this->db->where('id', $evaluation_id);
        if($this->db->update('evaluation', $data)){
            return true;
        }else{
            return false;
        }
    }
    
    public function delete_evaluation($evaluation_id = "") {
        $db_fileloc = $this->db->get_where('evaluation', array('id' => $evaluation_id))->row_array();
        $fileloc = $db_fileloc['file_attachment'];
        $this->db->where('id', $evaluation_id);
        if($this->db->delete('evaluation')){
            if(!unlink('uploads/evaluation_files/'.$fileloc)){
                return false;
            }else{
                return true;
            }
        }else{
            return false;
        }
    }
    
    public function get_written_eveluation($type = "", $id = "") {
        if($type == 'section'){
            return $this->db->get_where('evaluation', array('section_id' => $id));
        }else if($type == 'status') {
            $status = $this->db->get_where('evaluation', array('course_id' => $id));
            if($status->num_rows() > 0){
                return true;
            }else{
                return false;
            }
        }
    }

    public function get_course_category_count($course_type = '') {
       return $list = $this->db->get_where('course', array('level' => $course_type))->result_array();
    }

    public function get_payment_details_by_id($payment_id = "") {
        return $this->db->get_where('payment', array('id' => $payment_id))->row_array();
    }

    public function update_instructor_payment_status($payment_id = "") {
        $updater = array(
            'instructor_payment_status' => 1
        );
        $this->db->where('id', $payment_id);
        $this->db->update('payment', $updater);
    }

    public function update_system_settings() {
        $data['value'] = html_escape($this->input->post('system_name'));
        $this->db->where('key', 'system_name');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('system_title'));
        $this->db->where('key', 'system_title');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('author'));
        $this->db->where('key', 'author');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('slogan'));
        $this->db->where('key', 'slogan');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('language'));
        $this->db->where('key', 'language');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('text_align'));
        $this->db->where('key', 'text_align');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('system_email'));
        $this->db->where('key', 'system_email');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('address'));
        $this->db->where('key', 'address');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('phone'));
        $this->db->where('key', 'phone');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('youtube_api_key'));
        $this->db->where('key', 'youtube_api_key');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('vimeo_api_key'));
        $this->db->where('key', 'vimeo_api_key');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('purchase_code'));
        $this->db->where('key', 'purchase_code');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('footer_text'));
        $this->db->where('key', 'footer_text');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('footer_link'));
        $this->db->where('key', 'footer_link');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('website_keywords'));
        $this->db->where('key', 'website_keywords');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('website_description'));
        $this->db->where('key', 'website_description');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('student_email_verification'));
        $this->db->where('key', 'student_email_verification');
        $this->db->update('settings', $data);
    }

    public function update_smtp_settings() {
        $data['value'] = html_escape($this->input->post('protocol'));
        $this->db->where('key', 'protocol');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('smtp_host'));
        $this->db->where('key', 'smtp_host');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('smtp_port'));
        $this->db->where('key', 'smtp_port');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('smtp_user'));
        $this->db->where('key', 'smtp_user');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('smtp_pass'));
        $this->db->where('key', 'smtp_pass');
        $this->db->update('settings', $data);
    }

    public function update_social_settings() {
        $data['value'] = html_escape($this->input->post('facebook'));
        $this->db->where('key', 'facebook');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('instagram'));
        $this->db->where('key', 'instagram');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('twitter'));
        $this->db->where('key', 'twitter');
        $this->db->update('settings', $data);
    }

    public function update_paypal_settings() {
        // update paypal keys
        $paypal_info = array();
        $paypal['active'] = $this->input->post('paypal_active');
        $paypal['mode'] = $this->input->post('paypal_mode');
        $paypal['sandbox_client_id'] = $this->input->post('sandbox_client_id');
        $paypal['production_client_id'] = $this->input->post('production_client_id');

        array_push($paypal_info, $paypal);

        $data['value']    =   json_encode($paypal_info);
        $this->db->where('key', 'paypal');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('paypal_currency'));
        $this->db->where('key', 'paypal_currency');
        $this->db->update('settings', $data);
    }

    public function update_paystack_settings() {
        // update paypal keys
        $paystack_info = array();
        $paystack['active'] = $this->input->post('paystack_active');
        $paystack['paystack_live_key'] = $this->input->post('paystack_live_key');

        array_push($paystack_info, $paystack);

        $data['value']    =   json_encode($paystack_info);
        $this->db->where('key', 'paystack_keys');
        $this->db->update('settings', $data);
        // $this->db->update('settings', $data);
    }

    public function update_stripe_settings() {
        // update stripe keys
        $stripe_info = array();

        $stripe['active'] = $this->input->post('stripe_active');
        $stripe['testmode'] = $this->input->post('testmode');
        $stripe['public_key'] = $this->input->post('public_key');
        $stripe['secret_key'] = $this->input->post('secret_key');
        $stripe['public_live_key'] = $this->input->post('public_live_key');
        $stripe['secret_live_key'] = $this->input->post('secret_live_key');

        array_push($stripe_info, $stripe);

        $data['value']    =   json_encode($stripe_info);
        $this->db->where('key', 'stripe_keys');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('stripe_currency'));
        $this->db->where('key', 'stripe_currency');
        $this->db->update('settings', $data);
    }

    public function update_system_currency() {
        $data['value'] = html_escape($this->input->post('system_currency'));
        $this->db->where('key', 'system_currency');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('currency_position'));
        $this->db->where('key', 'currency_position');
        $this->db->update('settings', $data);
    }

    public function update_instructor_settings() {
        $data['value'] = html_escape($this->input->post('allow_instructor'));
        $this->db->where('key', 'allow_instructor');
        $this->db->update('settings', $data);

        $data['value'] = html_escape($this->input->post('instructor_revenue'));
        $this->db->where('key', 'instructor_revenue');
        $this->db->update('settings', $data);
    }

    public function get_lessons($type = "", $id = "") {
        $this->db->order_by("order", "asc");
        if($type == "course"){
            return $this->db->get_where('lesson', array('course_id' => $id));
        }
        elseif ($type == "section") {
            return $this->db->get_where('lesson', array('section_id' => $id));
        }
        elseif ($type == "lesson") {
            return $this->db->get_where('lesson', array('id' => $id));
        }
        else {
            return $this->db->get('lesson');
        }
    }
    
    public function getuser_max_in_table($tablename = "", $selectcolname = "", $colname2 = "", $colname2val = "") {
        $this->db->select_max($selectcolname);
        $this->db->select('n_ofstudy');
        $this->db->select_max('date_laststudy');
        $this->db->where('user_id', $this->session->userdata('user_id'));
        $this->db->where($colname2, $colname2val);
        $result = $this->db->get($tablename);
        if($result->num_rows() > 0){
            $sbret = $result->result_array();
            $ret = $sbret[0][$selectcolname];
            $data['user_highest_score'] = $sbret[0][$selectcolname];
            $data['number_ofq'] = $sbret[0]['n_ofstudy'];
            $data['date_laststudy'] = $sbret[0]['date_laststudy'];
            // $data['number_oftry'] = $result->num_rows();
            
            $this->db->select('date_laststudy');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where($colname2, $colname2val);
            $ret2data = $this->db->get($tablename);
            $data['number_oftry'] = $ret2data->num_rows();
             
            // // $this->db->select('date_laststudy');
            return $data;
        }
        return 0;
    }
    
    public function get_max_in_table($tablename = "", $selectcolname = "", $colname2 = "", $colname2val = "") {
        $this->db->select_max($selectcolname);
        $this->db->where($colname2, $colname2val);
        $result = $this->db->get($tablename);
        if($result->num_rows() > 0){
            $sbret = $result->result_array();
            $ret = $sbret[0][$selectcolname];
            $data['overall_highest_score'] = $sbret[0][$selectcolname];
            // $data['overall_highest_score'] = $sbret[0][$selectcolname];
            // $data['number_ofq'] = ;
            return $data;
        }
        return 0;
    }
            //     $ret = $sbret[0][$selectcolname];
            // $data['user_highest_score'] = $sbret[0][$selectcolname];
            // $data['overall_highest_score'] = ;
            // $data['number_ofq'] = ;

    public function add_course($param1 = "") {
        $outcomes = $this->trim_and_return_json($this->input->post('outcomes'));
        $requirements = $this->trim_and_return_json($this->input->post('requirements'));

        $data['title'] = html_escape($this->input->post('title'));
        $data['short_description'] = $this->input->post('short_description');
        $data['description'] = $this->input->post('description');
        $data['outcomes'] = $outcomes;
        $data['language'] = $this->input->post('language_made_in');
        $data['sub_category_id'] = $this->input->post('sub_category_id');
        $category_details = $this->get_category_details_by_id($this->input->post('sub_category_id'))->row_array();
        $data['category_id'] = $category_details['parent'];
        $data['requirements'] = $requirements;
        $data['price'] = $this->input->post('price');
        $data['discount_flag'] = $this->input->post('discount_flag');
        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['level'] = $this->input->post('level');
        $data['is_free_course'] = $this->input->post('is_free_course');
        $data['video_url'] = html_escape($this->input->post('course_overview_url'));

        if ($this->input->post('course_overview_url') != "") {
            $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        }else {
            $data['course_overview_provider'] = "";
        }

        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['section'] = json_encode(array());
        $data['is_top_course'] = $this->input->post('is_top_course');
        $data['user_id'] = $this->session->userdata('user_id');
        $data['meta_description'] = $this->input->post('meta_description');
        $data['meta_keywords'] = $this->input->post('meta_keywords');
        $admin_details = $this->user_model->get_admin_details()->row_array();
        if ($admin_details['id'] == $data['user_id']) {
            $data['is_admin'] = 1;
        }else {
            $data['is_admin'] = 0;
        }
        if ($param1 == "save_to_draft") {
            $data['status'] = 'draft';
        }else{
            $data['status'] = 'pending';
        }
        $this->db->insert('course', $data);

        $course_id = $this->db->insert_id();
        // Create folder if does not exist
        if (!file_exists('uploads/thumbnails/course_thumbnails')) {
            mkdir('uploads/thumbnails/course_thumbnails', 0777, true);
        }

        if ($_FILES['course_thumbnail']['name'] != "") {
            move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg');
        }
        if ($data['status'] == 'approved') {
            $this->session->set_flashdata('flash_message', get_phrase('course_added_successfully'));
        }elseif ($data['status'] == 'pending') {
            $this->session->set_flashdata('flash_message', get_phrase('course_added_successfully').'. '.get_phrase('please_wait_untill_Admin_approves_it'));
        }elseif ($data['status'] == 'draft') {
            $this->session->set_flashdata('flash_message', get_phrase('your_course_has_been_added_to_draft'));
        }
    }

    public function get_cbtexams($id = '', $instructor_id = '') {
        if($id !== '') {
            $this->db->where('id', $id);
        }
        if($instructor_id != '') {
            $this->db->where('instructor_id', $instructor_id);
        }
        return $this->db->get('cbt_exams');
    }

    public function checkCbtEnrolled($param1) {
        // print('here');
        $check = $this->db->get_where('cbt_enrol', array('exam_id' => $param1, 'user_id' => $this->session->userdata('user_id')));
        if($check->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function get_usercbtexams($id = '') {
        $user_cbt_ids = array();
        if($id !== '') {
            $this->db->where('id', $id);
        }
        $user = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        $class_opt = get_phrase($user['class_options']);
        $cbt = $this->get_cbtexams();
        if($cbt->num_rows() > 0) {
            foreach($cbt->result_array() as $exam) {
                if($exam['status'] == '1') {
                    $get_parent_name_with_categoryId = $this->db->get_where('category', array('id' => $exam['category_id'], 'parent' => '0'))->row_array();
                    $category_name = get_phrase($get_parent_name_with_categoryId['name']);
                    if ($class_opt == $category_name) {
                        if(!in_array($exam['id'], $user_cbt_ids)){
                            array_push($user_cbt_ids, $exam['id']);
                        }
                    }
                }
            }
        }
        return $user_cbt_ids;

        // return $this->db->get('cbt_exams');
    }

    public function add_cbtexam() {
        $data = array();
        $data['tittle'] = html_escape($this->input->post('e_name'));
        // $data['short_description'] = $this->input->post('short_description');
        $data['insructions'] = html_escape($this->input->post('instruction'));
        // $data['sub_category_id'] = html_escape($this->input->post('sub_category_id'));
        // $category_details = $this->get_category_details_by_id(html_escape($this->input->post('sub_category_id')))->row_array();
        // $data['category_id'] = $category_details['parent'];
        $data['category_id'] = html_escape($this->input->post('category_id'));
        $exam_hour = html_escape($this->input->post('exam_hour'));
        $exam_mins = html_escape($this->input->post('exam_min'));
        $data['exam_time'] = $exam_hour.':'.$exam_mins;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['date_added'] = strtotime(date('D, d-M-Y'));

        $res = $this->db->insert('cbt_exams', $data);
        $section_id = $this->db->insert_id();

        $this->session->set_flashdata('flash_message', get_phrase('exam_set_successfully'));
    }

    public function add_cbtexam_instructor() {
        $data = array();
        $data['tittle'] = html_escape($this->input->post('e_name'));
        // $data['short_description'] = $this->input->post('short_description');
        $data['insructions'] = html_escape($this->input->post('instruction'));
        // $data['sub_category_id'] = html_escape($this->input->post('sub_category_id'));
        // $category_details = $this->get_category_details_by_id(html_escape($this->input->post('sub_category_id')))->row_array();
        // $data['category_id'] = $category_details['parent'];
        $user_cat = $this->crud_model->get_categories_by_userref("", $this->session->userdata('user_id'))->row_array();
        $data['category_id'] = $user_cat['id'];
        $data['instructor_id'] = $this->session->userdata('user_id');
        $exam_hour = html_escape($this->input->post('exam_hour'));
        $exam_mins = html_escape($this->input->post('exam_min'));
        $data['exam_time'] = $exam_hour.':'.$exam_mins;
        $data['user_id'] = $this->session->userdata('user_id');
        $data['date_added'] = strtotime(date('D, d-M-Y'));

        $res = $this->db->insert('cbt_exams', $data);
        $section_id = $this->db->insert_id();

        $this->session->set_flashdata('flash_message', get_phrase('exam_set_successfully'));
    }

    public function edit_cbtexam($exam_id = '') {
        $data = array();
        $data['tittle'] = html_escape($this->input->post('title'));
        // $data['short_description'] = $this->input->post('short_description');
        $data['insructions'] = html_escape($this->input->post('description'));
        // $data['sub_category_id'] = html_escape($this->input->post('sub_category_id'));
        // $category_details = $this->get_category_details_by_id(html_escape($this->input->post('sub_category_id')))->row_array();
        if(isset($_POST['category_id'])){
            $data['category_id'] = html_escape($this->input->post('category_id'));
        }
        // $exam_hour = html_escape($this->input->post('exam_hour'));
        // $exam_mins = html_escape($this->input->post('exam_min'));
        // $data['exam_time'] = $exam_hour.':'.$exam_mins;
        // $data['user_id'] = $this->session->userdata('user_id');
        $data['date_modified'] = strtotime(date('D, d-M-Y'));

        $this->db->where('id', $exam_id);
        $this->db->update('cbt_exams', $data);

        $this->session->set_flashdata('flash_message', get_phrase('exam_edited_successfully'));
    }

    // activate and deactivate cbt exams

    public function activate_cbt($exam_id = '') {
        $this->db->where('id', $exam_id);
        $this->db->update('cbt_exams', array('status' => '1'));
    }

    public function deactivate_cbt($exam_id = '') {
        $this->db->where('id', $exam_id);
        $this->db->update('cbt_exams', array('status' => '0'));
    }

    function trim_and_return_json($untrimmed_array) {
        $trimmed_array = array();
        if(sizeof($untrimmed_array) > 0){
            foreach ($untrimmed_array as $row) {
                if ($row != "") {
                    array_push($trimmed_array, $row);
                }
            }
        }
        return json_encode($trimmed_array);
    }

    public function update_course($course_id, $type = "") {
        $outcomes = $this->trim_and_return_json($this->input->post('outcomes'));
        $requirements = $this->trim_and_return_json($this->input->post('requirements'));
        $data['title'] = $this->input->post('title');
        $data['short_description'] = $this->input->post('short_description');
        $data['description'] = $this->input->post('description');
        $data['outcomes'] = $outcomes;
        $data['language'] = $this->input->post('language_made_in');
        $data['category_id'] = $this->input->post('category_id');
        $data['sub_category_id'] = $this->input->post('sub_category_id');
        $data['requirements'] = $requirements;
        $data['is_free_course'] = $this->input->post('is_free_course');
        $data['price'] = $this->input->post('price');
        $data['discount_flag'] = $this->input->post('discount_flag');
        $data['discounted_price'] = $this->input->post('discounted_price');
        $data['level'] = $this->input->post('level');
        $data['video_url'] = $this->input->post('course_overview_url');

        if ($this->input->post('course_overview_url') != "") {
            $data['course_overview_provider'] = html_escape($this->input->post('course_overview_provider'));
        }else {
            $data['course_overview_provider'] = "";
        }

        $data['meta_description'] = $this->input->post('meta_description');
        $data['meta_keywords'] = $this->input->post('meta_keywords');
        $data['last_modified'] = strtotime(date('D, d-M-Y'));

        if ($this->input->post('is_top_course') != 1) {
            $data['is_top_course'] = 0;
        }else {
            $data['is_top_course'] = 1;
        }


        if ($type == "save_to_draft") {
            $data['status'] = 'draft';
        }else{
            $data['status'] = 'pending';
        }
        $this->db->where('id', $course_id);
        $this->db->update('course', $data);

        if ($_FILES['course_thumbnail']['name'] != "") {
            move_uploaded_file($_FILES['course_thumbnail']['tmp_name'], 'uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg');
        }
        if ($data['status'] == 'approved') {
            $this->session->set_flashdata('flash_message', get_phrase('course_updated_successfully'));
        }elseif ($data['status'] == 'pending') {
            $this->session->set_flashdata('flash_message', get_phrase('course_updated_successfully').'. '.get_phrase('please_wait_untill_Admin_approves_it'));
        }elseif ($data['status'] == 'draft') {
            $this->session->set_flashdata('flash_message', get_phrase('your_course_has_been_added_to_draft'));
        }
    }

    public function change_course_status($status = "", $course_id = "") {
        $updater = array(
            'status' => $status
        );
        $this->db->where('id', $course_id);
        $this->db->update('course', $updater);
    }

    public function get_course_thumbnail_url($course_id) {

        if (file_exists('uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg'))
        return base_url().'uploads/thumbnails/course_thumbnails/'.$course_id.'.jpg';
        else
        return base_url().'uploads/thumbnails/course_thumbnails/course-thumbnail.png';
    }
    public function get_lesson_thumbnail_url($lesson_id) {

        if (file_exists('uploads/thumbnails/lesson_thumbnails/'.$lesson_id.'.jpg'))
        return base_url().'uploads/thumbnails/lesson_thumbnails/'.$lesson_id.'.jpg';
        else
        return base_url().'uploads/thumbnails/thumbnail.png';
    }

    public function get_my_courses_by_category_id($category_id) {
        $this->db->select('course_id');
        $course_lists_by_enrol = $this->db->get_where('enrol', array('user_id' => $this->session->userdata('user_id')))->result_array();
        $course_ids = array();
        foreach ($course_lists_by_enrol as $row) {
            if (!in_array($row['course_id'], $course_ids)) {
                array_push($course_ids, $row['course_id']);
            }
        }
        $this->db->where_in('id', $course_ids);
        $this->db->where('category_id', $category_id);
        return $this->db->get('course');
    }

    public function get_my_courses_by_search_string($search_string) {
        $this->db->select('course_id');
        $course_lists_by_enrol = $this->db->get_where('enrol', array('user_id' => $this->session->userdata('user_id')))->result_array();
        $course_ids = array();
        foreach ($course_lists_by_enrol as $row) {
            if (!in_array($row['course_id'], $course_ids)) {
                array_push($course_ids, $row['course_id']);
            }
        }
        $this->db->where_in('id', $course_ids);
        $this->db->like('title', $search_string);
        return $this->db->get('course');
    }

    public function get_courses_by_search_string($search_string) {
        $this->db->like('title', $search_string);
        $this->db->where('status', 'active');
        return $this->db->get('course');
    }


    public function get_course_by_id($course_id = "") {
        $this->db->where('id', $course_id);
        // $this->db->where('status', 'active');
        return $this->db->get('course');
        // return $this->db->get_where('course', array('id' => $course_id));
    }

    public function delete_course($course_id) {
        $this->db->where('id', $course_id);
        $this->db->delete('course');
    }
    
    public function archieve_course($course_id = '') {
        if($course_id != '') {
            $this->db->where('id', $course_id);
            $this->db->update('course', array('archieved_status' => '1', 'status' => 'pending'));
        }else{
            $this->db->where('archieved_status', '0');
            $this->db->update('course', array('archieved_status' => '1', 'status' => 'pending'));
        }
    }
    
    public function unarchieve_course($course_id) {
        $this->db->where('id', $course_id);
        $this->db->update('course', array('archieved_status' => '0'));
    }

    public function get_top_courses() {
        return $this->db->get_where('course', array('is_top_course' => 1, 'status' => 'active'));
    }

    public function get_top_selling_courses() {
        return $this->db->query('SELECT course_id, COUNT(id) FROM payment GROUP BY course_id ORDER BY COUNT(id) DESC');
    }
    public function get_default_category_id() {
        $categories = $this->get_categories()->result_array();
        foreach ($categories as $category) {
            return $category['id'];
        }
    }

    public function get_courses_by_user_id($param1 = "") {
        $courses['draft'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'draft'));
        $courses['pending'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'pending'));
        $courses['active'] = $this->db->get_where('course', array('user_id' => $param1, 'status' => 'active'));
        return $courses;
    }

    public function get_status_wise_courses($status = "") {
        if ($status != "") {
            $courses = $this->db->get_where('course', array('status' => $status));
        }else {
            $courses['draft'] = $this->db->get_where('course', array('status' => 'draft'));
            $courses['pending'] = $this->db->get_where('course', array('status' => 'pending'));
            $courses['active'] = $this->db->get_where('course', array('status' => 'active'));
        }
        return $courses;
    }
    
    public function enrol_right_users_for_course($course_id){
        if(empty($course_id) || $course_id == '0'){
            $this->session->set_flashdata('flash_message', get_phrase('course_id_cannot_be_zero_or_empty'));
        }else{
            $count = "";
            $dd = "";
            // $this->db->select('*');
            // $this->db->distinct("enrolled_status");
            // $this->db->from('users');
            // $this->db->where('status', '1');
            // $enroled = $this->db->get();
            // $enroled_statusd = $enroled->row();
            // $enroled_status = $enroled->num_rows();
            $alluser = $this->db->get_where('users', array('status'=>'1', 'role_id'=>'2'))->result_array();
            foreach($alluser as $user_rows) {
                $user_id = $user_rows['id'];
                // $dd .= $userid.', ';
                // if($enroled_status > 0){
                $e_status = $user_rows['enrolled_status'];
                $category = $user_rows['category'];
                $class_opt = get_phrase($user_rows['class_options']);
                if($e_status == 0 || $e_status == 1){
                    $this->db->select('id');
                    $this->db->distinct("id");
                    $this->db->from('category');
                    $this->db->where('name', $class_opt);
                    $dbcat = $this->db->get();
                    $dbcat_data = $dbcat->row();
                    if ($dbcat->num_rows() > 0) {
                        $dbcat_data_id = $dbcat_data->id;
                        
                        $course_subcat_details = $this->get_course_by_id($course_id)->row_array();
                        
                        $course_subcat_id = $course_subcat_details['sub_category_id'];
                        
                        $category_details = $this->get_category_details_by_id($course_subcat_id)->row_array();
                        $parent_id = $category_details['parent'];
                        
                        
                        // $count = $course_id;
                        
                        if($dbcat_data_id == $parent_id){
                            // $count .= $user_id.", ";
                            // if($course_exist->num_rows() > 0){
                            //     foreach($course_exist_id_row as $llist){
                            //         $course_exist_id = $llist['id'];
                                    $enrol_data['course_id'] = $course_id;
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
                            // }
                        
                        // $this->db->select('id');
                        // $this->db->distinct('id');
                        // $this->db->from('category');
                        // $this->db->where('parent', $dbcat_data_id);
                        // $list = $this->db->get();
                        // $course_exist_id = "";
                        // // $count = 0;
                        // $listdata = $list->result_array();
                        // foreach($listdata as $repdata){
                        //     $hid = $repdata['id'];
                        //     $this->db->select('*');
                        //     // $this->db->distinct("id");
                        //     $this->db->from('course');
                        //     $this->db->where('sub_category_id', $hid);
                        //     // $this->db->where('id', $course_id);
                        //     $course_exist = $this->db->get();
                        //     $course_exist_id_row = $course_exist->result_array();
                        //     $count += $course_exist->num_rows();
                            
                        //     // if($course_exist->num_rows() > 0){
                        //     //     foreach($course_exist_id_row as $llist){
                        //     //         $course_exist_id = $llist['id'];
                        //     //         $enrol_data['course_id'] = $course_exist_id;
                        //     //         $enrol_data['user_id'] = $user_id;
                        //     //         $check = $this->db->get_where('enrol', $enrol_data);
                        //     //         if ($check->num_rows() > 0) {
                                        
                        //     //         }else {
                        //     //             $enrol_data['date_added'] = strtotime(date('D, d-M-Y'));
                        //     //             $this->db->insert('enrol', $enrol_data);
                        //     //         }
                        //     //     }
                        //     //     // $newdata = array();
                        //     //     // $newdata['enrolled_status'] = 1;
                        //     //     $this->db->where('id', $user_id);
                        //     //     $this->db->update('users', array('enrolled_status' => 1));
                        //     // }
                        // }
                    }
                    
                }
            // }
            }
           
            $this->session->set_flashdata('flash_message', get_phrase('sucessfully_enrolled_users_for_this_course'));
            // get_phrase('sucessfully_enrolled_users_for_this_course')

        }
    }


    public function get_status_wise_courses_for_instructor($status = "") {
        if ($status != "") {
            $this->db->where('status', $status);
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses = $this->db->get('course');
        }else {
            $this->db->where('status', 'draft');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses['draft'] = $this->db->get('course');

            $this->db->where('user_id', $this->session->userdata('user_id'));
            $this->db->where('status', 'draft');
            $courses['pending'] = $this->db->get('course');

            $this->db->where('status', 'draft');
            $this->db->where('user_id', $this->session->userdata('user_id'));
            $courses['active'] = $this->db->get_where('course');
        }
        return $courses;
    }

    public function get_default_sub_category_id($default_cateegory_id) {
        $sub_categories = $this->get_sub_categories($default_cateegory_id);
        foreach ($sub_categories as $sub_category) {
            return $sub_category['id'];
        }
    }

    public function get_instructor_wise_courses($instructor_id = "", $return_as = "") {
        $courses = $this->db->get_where('course', array('user_id' => $instructor_id));
        if ($return_as == 'simple_array') {
            $array = array();
            foreach ($courses->result_array() as $course) {
                if (!in_array($course['id'], $array)) {
                    array_push($array, $course['id']);
                }
            }
            return $array;
        }else {
            return $courses;
        }
    }

    public function get_instructor_wise_payment_history($instructor_id = "") {
        $courses = $this->get_instructor_wise_courses($instructor_id, 'simple_array');
        if (sizeof($courses) > 0) {
            $this->db->where_in('course_id', $courses);
            return $this->db->get('payment')->result_array();
        }else {
            return array();
        }
    }
    
    public function get_all_instructors ($instructor_id = "") {
        if($instructor_id != ""){
            $this->db->where('id', $instructor_id);
        }
        $this->db->where('is_instructor', '1');
        return $this->db->get('users');
    }

    public function add_section($course_id) {
        $data['title'] = html_escape($this->input->post('title'));
        $data['course_id'] = $course_id;
        $this->db->insert('section', $data);
        $section_id = $this->db->insert_id();

        $course_details = $this->get_course_by_id($course_id)->row_array();
        $previous_sections = json_decode($course_details['section']);

        if (sizeof($previous_sections) > 0) {
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        }else {
            $previous_sections = array();
            array_push($previous_sections, $section_id);
            $updater['section'] = json_encode($previous_sections);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        }
    }

    public function edit_section($section_id) {
        $data['title'] = $this->input->post('title');
        $this->db->where('id', $section_id);
        $this->db->update('section', $data);
    }

    public function delete_section($course_id, $section_id) {
        $this->db->where('id', $section_id);
        $this->db->delete('section');

        $course_details = $this->get_course_by_id($course_id)->row_array();
        $previous_sections = json_decode($course_details['section']);

        if (sizeof($previous_sections) > 0) {
            $new_section = array();
            for ($i = 0; $i < sizeof($previous_sections); $i++) {
                if ($previous_sections[$i] != $section_id) {
                    array_push($new_section, $previous_sections[$i]);
                }
            }
            $updater['section'] = json_encode($new_section);
            $this->db->where('id', $course_id);
            $this->db->update('course', $updater);
        }
    }

    public function get_section($type_by, $id){
        $this->db->order_by("order", "asc");
        if ($type_by == 'course') {
            return $this->db->get_where('section', array('course_id' => $id));
        }elseif ($type_by == 'section') {
            return $this->db->get_where('section', array('id' => $id));
        }
    }

    public function serialize_section($course_id, $serialization) {
        $updater = array(
            'section' => $serialization
        );
        $this->db->where('id', $course_id);
        $this->db->update('course', $updater);
    }

    public function add_lesson() {
        $data['course_id'] = html_escape($this->input->post('course_id'));
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));

        $lesson_type_array = explode('-', $this->input->post('lesson_type'));
        $lesson_type = $lesson_type_array[0];

        $data['attachment_type'] = $lesson_type_array[1];
        $data['lesson_type'] = $lesson_type;

        if($lesson_type == 'video') {
            $lesson_provider = $this->input->post('lesson_provider');
            if ($lesson_provider == 'youtube' || $lesson_provider == 'vimeo') {
                if ($this->input->post('video_url') == "" || $this->input->post('duration') == "") {
                    $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('video_url'));

                $duration_formatter = explode(':', $this->input->post('duration'));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour.':'.$min.':'.$sec;

                $video_details = $this->video_model->getVideoDetails($data['video_url']);
                $data['video_type'] = $video_details['provider'];
            }elseif ($lesson_provider == 'html5') {
                if ($this->input->post('html5_video_url') == "" || $this->input->post('html5_duration') == "") {
                    $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('html5_video_url'));
                $duration_formatter = explode(':', $this->input->post('html5_duration'));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour.':'.$min.':'.$sec;
                $data['video_type'] = 'html5';
            }else {
                $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_provider'));
                redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
            }
        }else {
            if ($_FILES['attachment']['name'] == "") {
                $this->session->set_flashdata('error_message',get_phrase('invalid_attachment'));
                redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
            }else {
                $fileName           = $_FILES['attachment']['name'];
                $tmp                = explode('.', $fileName);
                $fileExtension      = end($tmp);
                $uploadable_file    =  md5(uniqid(rand(), true)).'.'.$fileExtension;
                $data['attachment'] = $uploadable_file;

                if (!file_exists('uploads/lesson_files')) {
                    mkdir('uploads/lesson_files', 0777, true);
                }
                move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/'.$uploadable_file);
            }
        }

        $data['date_added'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = $this->input->post('summary');

        $this->db->insert('lesson', $data);
        $inserted_id = $this->db->insert_id();

        if ($_FILES['thumbnail']['name'] != "") {
            if (!file_exists('uploads/thumbnails/lesson_thumbnails')) {
                mkdir('uploads/thumbnails/lesson_thumbnails', 0777, true);
            }
            move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/thumbnails/lesson_thumbnails/'.$inserted_id.'.jpg');
        }
    }

    public function edit_lesson($lesson_id) {

        $previous_data = $this->db->get_where('lesson', array('id' => $lesson_id))->row_array();

        $data['course_id'] = html_escape($this->input->post('course_id'));
        $data['title'] = html_escape($this->input->post('title'));
        $data['section_id'] = html_escape($this->input->post('section_id'));

        $lesson_type_array = explode('-', $this->input->post('lesson_type'));
        $lesson_type = $lesson_type_array[0];

        $data['attachment_type'] = $lesson_type_array[1];
        $data['lesson_type'] = $lesson_type;

        if($lesson_type == 'video') {
            $lesson_provider = $this->input->post('lesson_provider');
            if ($lesson_provider == 'youtube' || $lesson_provider == 'vimeo') {
                if ($this->input->post('video_url') == "" || $this->input->post('duration') == "") {
                    $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('video_url'));

                $duration_formatter = explode(':', $this->input->post('duration'));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour.':'.$min.':'.$sec;

                $video_details = $this->video_model->getVideoDetails($data['video_url']);
                $data['video_type'] = $video_details['provider'];
            }elseif ($lesson_provider == 'html5') {
                if ($this->input->post('html5_video_url') == "" || $this->input->post('html5_duration') == "") {
                    $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_url_and_duration'));
                    redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
                }
                $data['video_url'] = html_escape($this->input->post('html5_video_url'));

                $duration_formatter = explode(':', $this->input->post('html5_duration'));
                $hour = sprintf('%02d', $duration_formatter[0]);
                $min = sprintf('%02d', $duration_formatter[1]);
                $sec = sprintf('%02d', $duration_formatter[2]);
                $data['duration'] = $hour.':'.$min.':'.$sec;
                $data['video_type'] = 'html5';

                if ($_FILES['thumbnail']['name'] != "") {
                    if (!file_exists('uploads/thumbnails/lesson_thumbnails')) {
                        mkdir('uploads/thumbnails/lesson_thumbnails', 0777, true);
                    }
                    move_uploaded_file($_FILES['thumbnail']['tmp_name'], 'uploads/thumbnails/lesson_thumbnails/'.$lesson_id.'.jpg');
                }
            }else {
                $this->session->set_flashdata('error_message',get_phrase('invalid_lesson_provider'));
                redirect(site_url(strtolower($this->session->userdata('role')).'/course_form/course_edit/'.$data['course_id']), 'refresh');
            }
            $data['attachment'] = "";
        }else {
            if ($_FILES['attachment']['name'] != "") {
                // unlinking previous attachments
                if ($previous_data['attachment'] != "") {
                    unlink('uploads/lesson_files/'.$previous_data['attachment']);
                }

                $fileName           = $_FILES['attachment']['name'];
                $tmp                = explode('.', $fileName);
                $fileExtension      = end($tmp);
                $uploadable_file    =  md5(uniqid(rand(), true)).'.'.$fileExtension;
                $data['attachment'] = $uploadable_file;
                $data['video_type'] = "";
                $data['duration'] = "";
                $data['video_url'] = "";
                if (!file_exists('uploads/lesson_files')) {
                    mkdir('uploads/lesson_files', 0777, true);
                }
                move_uploaded_file($_FILES['attachment']['tmp_name'], 'uploads/lesson_files/'.$uploadable_file);
            }
        }

        $data['last_modified'] = strtotime(date('D, d-M-Y'));
        $data['summary'] = $this->input->post('summary');

        $this->db->where('id', $lesson_id);
        $this->db->update('lesson', $data);
    }
    public function delete_lesson($lesson_id) {
        $this->db->where('id', $lesson_id);
        $this->db->delete('lesson');
    }

    public function update_frontend_settings() {
        $data['value'] = html_escape($this->input->post('banner_title'));
        $this->db->where('key', 'banner_title');
        $this->db->update('frontend_settings', $data);

        $data['value'] = html_escape($this->input->post('banner_sub_title'));
        $this->db->where('key', 'banner_sub_title');
        $this->db->update('frontend_settings', $data);

        $data['value'] = html_escape($this->input->post('banner_instructor_text'));
        $this->db->where('key', 'banner_instructor_text');
        $this->db->update('frontend_settings', $data);


        $data['value'] = $this->input->post('about_us');
        $this->db->where('key', 'about_us');
        $this->db->update('frontend_settings', $data);

        $data['value'] = $this->input->post('terms_and_condition');
        $this->db->where('key', 'terms_and_condition');
        $this->db->update('frontend_settings', $data);

        $data['value'] = $this->input->post('privacy_policy');
        $this->db->where('key', 'privacy_policy');
        $this->db->update('frontend_settings', $data);
    }

    public function update_frontend_banner() {
        move_uploaded_file($_FILES['banner_image']['tmp_name'], 'uploads/system/home-banner.jpg');
    }

    public function update_frontend_partners($index = '') {
        // return $index;
        if (!file_exists('uploads/partners')) {
            mkdir('uploads/partners', 0777, true);
        }
        $file_name = $_FILES['partner_image_'.$index];
        return move_uploaded_file($file_name['tmp_name'], 'uploads/partners/partner'.$index.'.jpg');
    }
    
    public function upload_resources() {
        $file = $_FILES['resource_file_selection'];
        $cusom_name = $_POST['file_custom_name'];
        $savename = $file['name'];
        $path = "uploads/core/video/$savename";
        
        if(move_uploaded_file($file['tmp_name'], $path)){
            $data = array();
            $data['file_name'] = $cusom_name;
            $data['stored_location'] = $path;
            $data['time_saved'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('course_resources', $data);
            
            return 'file_uploaded_sucessfully';
        }else{
            return 'file_not_uploaded';
        }
    }
    
    public function upload_activity_resources() {
        $file = $_FILES['resource_file_selection'];
        $cusom_name = $_POST['file_custom_name'];
        $savename = $file['name'];
        if(!is_dir('uploads/core/activities')) mkdir('uploads/core/activities', 0777, TRUE);
        $path = "uploads/core/activities/$savename";
        
        if(move_uploaded_file($file['tmp_name'], $path)){
            $data = array();
            $data['file_name'] = $cusom_name;
            $data['stored_location'] = $path;
            $data['time_saved'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('activity_resources', $data);
            
            return 'file_uploaded_sucessfully';
        }else{
            return 'file_not_uploaded';
        }
    }

    public function update_light_logo() {
        move_uploaded_file($_FILES['light_logo']['tmp_name'], 'uploads/system/logo-light.png');
    }

    public function update_dark_logo() {
        move_uploaded_file($_FILES['dark_logo']['tmp_name'], 'uploads/system/logo-dark.png');
    }

    public function update_small_logo() {
        move_uploaded_file($_FILES['small_logo']['tmp_name'], 'uploads/system/logo-light-sm.png');
    }

    public function update_favicon() {
        move_uploaded_file($_FILES['favicon']['tmp_name'], 'uploads/system/favicon.png');
    }

    public function handleWishList($course_id) {
        $wishlists = array();
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        if ($user_details['wishlist'] == "") {
            array_push($wishlists, $course_id);
        }else {
            $wishlists = json_decode($user_details['wishlist']);
            if (in_array($course_id, $wishlists)) {
                $container = array();
                foreach ($wishlists as $key) {
                    if ($key != $course_id) {
                        array_push($container, $key);
                    }
                }
                $wishlists = $container;
                // $key = array_search($course_id, $wishlists);
                // unset($wishlists[$key]);
            }else {
                array_push($wishlists, $course_id);
            }
        }

        $updater['wishlist'] = json_encode($wishlists);
        $this->db->where('id', $this->session->userdata('user_id'));
        $this->db->update('users', $updater);
    }

    public function is_added_to_wishlist($course_id = "") {
        if ($this->session->userdata('user_login') == 1) {
            $wishlists = array();
            $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
            $wishlists = json_decode($user_details['wishlist']);
            if (in_array($course_id, $wishlists)) {
                return true;
            }else {
                return false;
            }
        }else {
            return false;
        }
    }

    public function getWishLists() {
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        return json_decode($user_details['wishlist']);
    }

    public function get_latest_10_course() {
        $this->db->order_by("id", "desc");
        $this->db->limit('10');
        $this->db->where('status', 'active');
        return $this->db->get('course')->result_array();
    }

    public function enrol_student($user_id){
        $purchased_courses = $this->session->userdata('cart_items');
        foreach ($purchased_courses as $purchased_course) {
            $data['user_id'] = $user_id;
            $data['course_id'] = $purchased_course;
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('enrol', $data);
        }
    }
    public function enrol_a_student_manually() {
        $data['course_id'] = $this->input->post('course_id');
        $data['user_id']   = $this->input->post('user_id');
        if ($this->db->get_where('enrol', $data)->num_rows() > 0) {
            $this->session->set_flashdata('error_message', get_phrase('student_has_already_been_enrolled_to_this_course'));
        }else {
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('enrol', $data);
            $this->session->set_flashdata('flash_message', get_phrase('student_has_been_enrolled_to_that_course'));
        }
    }

    public function enrol_to_free_course($course_id = "", $user_id = "") {
        $course_details = $this->get_course_by_id($course_id)->row_array();
        if ($course_details['is_free_course'] == 1) {
            $data['course_id'] = $course_id;
            $data['user_id']   = $user_id;
            if ($this->db->get_where('enrol', $data)->num_rows() > 0) {
                $this->session->set_flashdata('error_message', get_phrase('student_has_already_been_enrolled_to_this_course'));
            }else {
                $data['date_added'] = strtotime(date('D, d-M-Y'));
                $this->db->insert('enrol', $data);
                $this->session->set_flashdata('flash_message', get_phrase('successfully_enrolled'));
            }
        }else {
            $this->session->set_flashdata('error_message', get_phrase('this_course_is_not_free_at_all'));
            redirect(site_url('home/course/'.slugify($course_details['title']).'/'.$course_id), 'refresh');
        }

    }
    public function course_purchase($user_id, $method, $amount_paid, $payment_ref = '') {
        $purchased_courses = $this->session->userdata('cart_items');
        foreach ($purchased_courses as $purchased_course) {
            $data['user_id'] = $user_id;
            $data['payment_type'] = $method;
            $data['payment_ref'] = $payment_ref;
            $data['course_id'] = $purchased_course;
            $course_details = $this->get_course_by_id($purchased_course)->row_array();
            if ($course_details['discount_flag'] == 1) {
                $data['amount'] = $course_details['discounted_price'];
            }else {
                $data['amount'] = $course_details['price'];
            }
            if (get_user_role('role_id', $course_details['user_id']) == 1) {
                $data['admin_revenue'] = $data['amount'];
                $data['instructor_revenue'] = 0;
                $data['instructor_payment_status'] = 1;
            }else {
                if (get_settings('allow_instructor') == 1) {
                    $instructor_revenue_percentage = get_settings('instructor_revenue');
                    $data['instructor_revenue'] = ceil(($data['amount'] * $instructor_revenue_percentage) / 100);
                    $data['admin_revenue'] = $data['amount'] - $data['instructor_revenue'];
                }else {
                    $data['instructor_revenue'] = 0;
                    $data['admin_revenue'] = $data['amount'];
                }
                $data['instructor_payment_status'] = 0;
            }
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $this->db->insert('payment', $data);
        }
    }

    public function get_default_lesson($section_id) {
        $this->db->order_by('order',"asc");
        $this->db->limit(1);
        $this->db->where('section_id', $section_id);
        return $this->db->get('lesson');
    }

    public function get_courses_by_wishlists() {
        $wishlists = $this->getWishLists();
        if (sizeof($wishlists) > 0) {
            $this->db->where_in('id', $wishlists);
            return $this->db->get('course')->result_array();
        }else {
            return array();
        }

    }


    public function get_courses_of_wishlists_by_search_string($search_string) {
        $wishlists = $this->getWishLists();
        if (sizeof($wishlists) > 0) {
            $this->db->where_in('id', $wishlists);
            $this->db->like('title', $search_string);
            return $this->db->get('course')->result_array();
        }else {
            return array();
        }
    }

    public function get_total_duration_of_lesson_by_course_id($course_id) {
        $total_duration = 0;
        $lessons = $this->crud_model->get_lessons('course', $course_id)->result_array();
        foreach ($lessons as $lesson) {
            if ($lesson['lesson_type'] != "other") {
                $time_array = explode(':', $lesson['duration']);
                $hour_to_seconds = $time_array[0] * 60 * 60;
                $minute_to_seconds = $time_array[1] * 60;
                $seconds = $time_array[2];
                $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
            }
        }
        return gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
    }

    public function get_total_duration_of_lesson_by_section_id($section_id) {
        $total_duration = 0;
        $lessons = $this->crud_model->get_lessons('section', $section_id)->result_array();
        foreach ($lessons as $lesson) {
            if ($lesson['lesson_type'] != 'other') {
                $time_array = explode(':', $lesson['duration']);
                $hour_to_seconds = $time_array[0] * 60 * 60;
                $minute_to_seconds = $time_array[1] * 60;
                $seconds = $time_array[2];
                $total_duration += $hour_to_seconds + $minute_to_seconds + $seconds;
            }
        }
        return gmdate("H:i:s", $total_duration).' '.get_phrase('hours');
    }

    public function rate($data) {
        if ($this->db->get_where('rating', array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']))->num_rows() == 0) {
            $this->db->insert('rating', $data);
        }else {
            $checker = array('user_id' => $data['user_id'], 'ratable_id' => $data['ratable_id'], 'ratable_type' => $data['ratable_type']);
            $this->db->where($checker);
            $this->db->update('rating', $data);
        }
    }

    public function get_user_specific_rating($ratable_type = "", $ratable_id = "") {
        return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'user_id' => $this->session->userdata('user_id'), 'ratable_id' => $ratable_id))->row_array();
    }

    public function get_ratings($ratable_type = "", $ratable_id = "", $is_sum = false) {
        if ($is_sum) {
            $this->db->select_sum('rating');
            return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'ratable_id' => $ratable_id));

        }else {
            return $this->db->get_where('rating', array('ratable_type' => $ratable_type, 'ratable_id' => $ratable_id));
        }
    }
    public function get_instructor_wise_course_ratings($instructor_id = "", $ratable_type = "", $is_sum = false) {
        $course_ids = $this->get_instructor_wise_courses($instructor_id, 'simple_array');
        if ($is_sum) {
            $this->db->where('ratable_type', $ratable_type);
            $this->db->where_in('ratable_id', $course_ids);
            $this->db->select_sum('rating');
            return $this->db->get('rating');

        }else {
            $this->db->where('ratable_type', $ratable_type);
            $this->db->where_in('ratable_id', $course_ids);
            return $this->db->get('rating');
        }
    }
    public function get_percentage_of_specific_rating($rating = "", $ratable_type = "", $ratable_id = "") {
        $number_of_user_rated = $this->db->get_where('rating', array(
            'ratable_type' => $ratable_type,
            'ratable_id'   => $ratable_id
        ))->num_rows();

        $number_of_user_rated_the_specific_rating = $this->db->get_where( 'rating', array(
            'ratable_type' => $ratable_type,
            'ratable_id'   => $ratable_id,
            'rating'       => $rating
        ))->num_rows();

        //return $number_of_user_rated.' '.$number_of_user_rated_the_specific_rating;
        if ($number_of_user_rated_the_specific_rating > 0) {
            $percentage = ($number_of_user_rated_the_specific_rating / $number_of_user_rated) * 100;
        }else {
            $percentage = 0;
        }
        return floor($percentage);
    }

    ////////private message//////
    function send_new_private_message() {
        $message    = $this->input->post('message');
        $timestamp  = strtotime(date("Y-m-d H:i:s"));

        $receiver   = $this->input->post('receiver');
        $sender     = $this->session->userdata('user_id');

        //check if the thread between those 2 users exists, if not create new thread
        $num1 = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->num_rows();
        $num2 = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->num_rows();
        if ($num1 == 0 && $num2 == 0) {
            $message_thread_code                        = substr(md5(rand(100000000, 20000000000)), 0, 15);
            $data_message_thread['message_thread_code'] = $message_thread_code;
            $data_message_thread['sender']              = $sender;
            $data_message_thread['receiver']            = $receiver;
            $this->db->insert('message_thread', $data_message_thread);
        }
        if ($num1 > 0)
        $message_thread_code = $this->db->get_where('message_thread', array('sender' => $sender, 'receiver' => $receiver))->row()->message_thread_code;
        if ($num2 > 0)
        $message_thread_code = $this->db->get_where('message_thread', array('sender' => $receiver, 'receiver' => $sender))->row()->message_thread_code;


        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);

        return $message_thread_code;
    }

    function send_reply_message($message_thread_code) {
        $message    = html_escape($this->input->post('message'));
        $timestamp  = strtotime(date("Y-m-d H:i:s"));
        $sender     = $this->session->userdata('user_id');

        $data_message['message_thread_code']    = $message_thread_code;
        $data_message['message']                = $message;
        $data_message['sender']                 = $sender;
        $data_message['timestamp']              = $timestamp;
        $this->db->insert('message', $data_message);
    }

    function mark_thread_messages_read($message_thread_code) {
        // mark read only the oponnent messages of this thread, not currently logged in user's sent messages
        $current_user = $this->session->userdata('user_id');
        $this->db->where('sender !=', $current_user);
        $this->db->where('message_thread_code', $message_thread_code);
        $this->db->update('message', array('read_status' => 1));
    }

    function count_unread_message_of_thread($message_thread_code) {
        $unread_message_counter = 0;
        $current_user = $this->session->userdata('user_id');
        $messages = $this->db->get_where('message', array('message_thread_code' => $message_thread_code))->result_array();
        foreach ($messages as $row) {
            if ($row['sender'] != $current_user && $row['read_status'] == '0')
            $unread_message_counter++;
        }
        return $unread_message_counter;
    }

    public function get_last_message_by_message_thread_code($message_thread_code) {
        $this->db->order_by('message_id','desc');
        $this->db->limit(1);
        $this->db->where(array('message_thread_code' => $message_thread_code));
        return $this->db->get('message');
    }

    function curl_request($code = '') {

        // $product_code = $code;

        // $personal_token = "FkA9UyDiQT0YiKwYLK3ghyFNRVV9SeUn";
        // $url = "https://api.envato.com/v3/market/author/sale?code=".$product_code;
        // $curl = curl_init($url);

        // //setting the header for the rest of the api
        // $bearer   = 'bearer ' . $personal_token;
        // $header   = array();
        // $header[] = 'Content-length: 0';
        // $header[] = 'Content-type: application/json; charset=utf-8';
        // $header[] = 'Authorization: ' . $bearer;

        // $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$product_code.'.json';
        //     $ch_verify = curl_init( $verify_url . '?code=' . $product_code );

        //     curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
        //     curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
        //     curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
        //     curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
        //     curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

        //     $cinit_verify_data = curl_exec( $ch_verify );
        //     curl_close( $ch_verify );

        //     $response = json_decode($cinit_verify_data, true);

        //     if (count($response['verify-purchase']) > 0) {
        //         return true;
        //     } else {
        //         return false;
        //     }
        }


        // version 1.3
        function get_currencies() {
            return $this->db->get('currency')->result_array();
        }

        function get_paypal_supported_currencies() {
            $this->db->where('paypal_supported', 1);
            return $this->db->get('currency')->result_array();
        }

        function get_stripe_supported_currencies() {
            $this->db->where('stripe_supported', 1);
            return $this->db->get('currency')->result_array();
        }

        // version 1.4
        function filter_course($selected_category_id = "", $selected_price = "", $selected_level = "", $selected_language = "", $selected_rating = "", $logins = ""){
            // echo $selected_category_id;
            // echo $selected_category_id.' '.$selected_price.' '.$selected_level.' '.$selected_language.' '.$selected_rating;

            $course_ids = array();
            if ($selected_category_id != "all") {
                $this->db->where('sub_category_id', $selected_category_id);
            }

            if ($selected_price != "all") {
                if ($selected_price == "paid") {
                    $this->db->where('is_free_course', null);
                }elseif ($selected_price == "free") {
                    $this->db->where('is_free_course', 1);
                }
            }

            if ($selected_level != "all") {
                $this->db->where('level', $selected_level);
            }

            if ($selected_language != "all") {
                $this->db->where('language', $selected_language);
            }
            $this->db->where('status', 'active');
            $courses = $this->db->get('course')->result_array();

            foreach ($courses as $course) {
                if ($selected_rating != "all") {
                    $total_rating =  $this->get_ratings('course', $course['id'], true)->row()->rating;
                    $number_of_ratings = $this->get_ratings('course', $course['id'])->num_rows();
                    if ($number_of_ratings > 0) {
                        $average_ceil_rating = ceil($total_rating / $number_of_ratings);
                        if ($average_ceil_rating == $selected_rating) {
                            array_push($course_ids, $course['id']);
                        }
                    }
                }else {
                    array_push($course_ids, $course['id']);
                }
            }

            if (count($course_ids) > 0) {
                $this->db->where_in('id', $course_ids);
                return $this->db->get('course')->result_array();
            }else {
                return array();
            }
        }

        public function get_courses($category_id = "", $sub_category_id = "", $instructor_id = 0) {
            if ($category_id > 0 && $sub_category_id > 0 && $instructor_id > 0) {
                return $this->db->get_where('course', array('category_id' => $category_id, 'sub_category_id' => $sub_category_id, 'user_id' => $instructor_id));
            }elseif ($category_id > 0 && $sub_category_id > 0 && $instructor_id == 0) {
                return $this->db->get_where('course', array('category_id' => $category_id, 'sub_category_id' => $sub_category_id));
            }else {
                return $this->db->get('course');
            }
        }

        public function filter_course_for_backend($category_id, $instructor_id, $price, $status) {
            if ($category_id != "all") {
                $this->db->where('sub_category_id', $category_id);
            }

            if ($price != "all") {
                if ($price == "paid") {
                    $this->db->where('is_free_course', null);
                }elseif ($price == "free") {
                    $this->db->where('is_free_course', 1);
                }
            }

            if ($instructor_id != "all") {
                $this->db->where('user_id', $instructor_id);
            }

            if ($status != "all") {
                $this->db->where('status', $status);
            }
            $this->db->where('archieved_status', '0');
            $this->db->order_by('id', 'desc');
            return $this->db->get('course')->result_array();
        }
        
        public function filter_users_for_backend($category, $status) {
            if ($category != "all") {
                $this->db->where('class_options', $category);
            }
            
            if($status == 'activated'){
                $mainactive = '1';
            }else{
                $mainactive = '0';
            }

            if ($status != "all") {
                $this->db->where('status', $mainactive);
            }
            // $this->db->where('archieved_status', '0');
            // $this->db->order_by('id', 'desc');
            $this->db->where('role_id', 2);
            $this->db->where('is_instructor', 1);
            return $this->db->get('users');
        }
        
        public function filter_users_for_promotion_backend($category) {
            if ($category != "all") {
                $this->db->where('class_options', $category);
            }
            
            $this->db->where('role_id', 2);
            $this->db->where('is_instructor', 1);
            return $this->db->get('users');
        }
        
        public function filter_course_for_backend_archieved($category_id, $instructor_id, $price, $status) {
            if ($category_id != "all") {
                $this->db->where('sub_category_id', $category_id);
            }

            if ($price != "all") {
                if ($price == "paid") {
                    $this->db->where('is_free_course', null);
                }elseif ($price == "free") {
                    $this->db->where('is_free_course', 1);
                }
            }

            if ($instructor_id != "all") {
                $this->db->where('user_id', $instructor_id);
            }

            if ($status != "all") {
                $this->db->where('status', $status);
            }
            $this->db->where('archieved_status', '1');
            $this->db->order_by('id', 'desc');
            return $this->db->get('course')->result_array();
        }

        public function sort_section($section_json) {
            $sections = json_decode($section_json);
            foreach ($sections as $key => $value) {
                $updater = array(
                    'order' => $key + 1
                );
                $this->db->where('id', $value);
                $this->db->update('section', $updater);
            }
        }

        public function sort_lesson($lesson_json) {
            $lessons = json_decode($lesson_json);
            foreach ($lessons as $key => $value) {
                $updater = array(
                    'order' => $key + 1
                );
                $this->db->where('id', $value);
                $this->db->update('lesson', $updater);
            }
        }
        public function sort_question($question_json) {
            $questions = json_decode($question_json);
            foreach ($questions as $key => $value) {
                $updater = array(
                    'order' => $key + 1
                );
                $this->db->where('id', $value);
                $this->db->update('question', $updater);
            }
        }

        public function sort_examquestion($question_json) {
            $questions = json_decode($question_json);
            foreach ($questions as $key => $value) {
                $updater = array(
                    'order' => $key + 1
                );
                $this->db->where('id', $value);
                $this->db->update('cbt_questions', $updater);
            }
        }

        public function get_free_and_paid_courses($price_status = "", $instructor_id = "") {
            $this->db->where('status', 'active');
            if ($price_status == 'free') {
                $this->db->where('is_free_course', 1);
            }else {
                $this->db->where('is_free_course', null);
            }

            if ($instructor_id > 0) {
                $this->db->where('user_id', $instructor_id);
            }
            return $this->db->get('course');
        }
        
        public function get_archieved_courses() {
            return $this->db->get_where('course', array('archieved_status' => '1'));
        }

        public function get_exams($exam_id = '', $elesson_id = '') {
            if($elesson_id != '') {
                return $this->db->get_where('cbt_lessons', array('id' => $elesson_id));
            } else {
                return $this->db->get_where('cbt_lessons', array('exam_id' => $exam_id));                
            }
        }

        // CBT exams functionalities

        public function add_exam($exam_id = "") {
            $data['exam_id'] = $exam_id;
            $data['title'] = html_escape($this->input->post('title'));
            $data['course_id'] = html_escape($this->input->post('course_id'));
            // $data['section_id'] = html_escape($this->input->post('section_id'));

            // $data['lesson_type'] = 'quiz';
            // $data['duration'] = '00:00:00';
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $data['summary'] = html_escape($this->input->post('summary'));
            $this->db->insert('cbt_lessons', $data);
        }

        public function edit_exam($exam_id = "") {
            $data['title'] = html_escape($this->input->post('title'));
            $data['course_id'] = html_escape($this->input->post('course_id'));

            $data['last_modified'] = strtotime(date('D, d-M-Y'));
            $data['summary'] = html_escape($this->input->post('summary'));
            $this->db->where('id', $exam_id);
            $this->db->update('cbt_lessons', $data);
        }

        public function delete_examlesson($exam_id = '') {
            $this->db->where('id', $exam_id);
            $this->db->delete('cbt_lessons');
        }

        public function get_exam_question_by_id($question_id) {
            $this->db->order_by("order", "asc");
            $this->db->where('id', $question_id);
            return $this->db->get('cbt_questions');
        }

        public function get_examquestions($examlesson_id = '') {
            $this->db->order_by("order", "asc");
            $this->db->where('lesson_id', $examlesson_id);
            return $this->db->get('cbt_questions');
        }

        public function fetch_examenrols($param1 = '', $check = false) {
            $cbt = $this->crud_model->get_cbtexams($param1, $this->session->userdata('user_id'))->result_array();
            if($check == true) {
                if(count($cbt) > 0) {
                    return $this->db->get_where('cbt_enrol', array('exam_id' => $param1))->result_array();
                }
            } else {
                return $this->db->get_where('cbt_enrol', array('exam_id' => $param1))->result_array();
            }
        }

        public function enrol_edit($enrol_id = '', $fields = array()) {
            $this->db->where('id', $enrol_id);
            $this->db->update('cbt_enrol', $fields);
        }


        // Add Quiz Questions
        public function add_exam_questions($examlesson_id) {
            $question_type = $this->input->post('question_type');
            if ($question_type == 'mcq') {
                $response = $this->add_multiple_exam_choice_question($examlesson_id);
                return $response;
            }
        }

        public function update_exam_questions($examlesson_id) {
            $question_type = $this->input->post('question_type');
            if ($question_type == 'mcq') {
                $response = $this->update_multiple_exam_choice_question($examlesson_id);
                return $response;
            }
        }

        function update_multiple_exam_choice_question($question_id){
            if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
                return false;
            }
            foreach ($this->input->post('options') as $option) {
                if ($option == "") {
                    return false;
                }
            }

            if (sizeof($this->input->post('correct_answers')) == 0) {
                $correct_answers = [""];
            }
            else{
                $correct_answers = $this->input->post('correct_answers');
            }

            $data['title']              = html_escape($this->input->post('title'));
            $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
            $data['type']               = 'multiple_choice';
            $data['options']            = json_encode($this->input->post('options'));
            $data['correct_answers']    = json_encode($correct_answers);
            $this->db->where('id', $question_id);
            $this->db->update('cbt_questions', $data);
            return true;
        }

        function delete_exam_question($question_id) {
            $this->db->where('id', $question_id);
            $this->db->delete('cbt_questions');
            return true;
        }

        function add_multiple_exam_choice_question($examlesson_id){
            if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
                return false;
            }
            foreach ($this->input->post('options') as $option) {
                if ($option == "") {
                    return false;
                }
            }
            if (sizeof($this->input->post('correct_answers')) == 0) {
                $correct_answers = [""];
            }
            else{
                $correct_answers = $this->input->post('correct_answers');
            }
            $data['lesson_id']            = $examlesson_id;
            $data['title']              = html_escape($this->input->post('title'));
            $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
            $data['type']               = 'multiple_choice';
            $data['options']            = json_encode($this->input->post('options'));
            $data['correct_answers']    = json_encode($correct_answers);
            $this->db->insert('cbt_questions', $data);
            return true;
        }

        // Adding quiz functionalities
        public function add_quiz($course_id = "") {
            $data['course_id'] = $course_id;
            $data['title'] = html_escape($this->input->post('title'));
            $data['section_id'] = html_escape($this->input->post('section_id'));

            $data['lesson_type'] = 'quiz';
            $data['duration'] = '00:00:00';
            $data['date_added'] = strtotime(date('D, d-M-Y'));
            $data['summary'] = html_escape($this->input->post('summary'));
            $this->db->insert('lesson', $data);
        }

        // updating quiz functionalities
        public function edit_quiz($lesson_id = "") {
            $data['title'] = html_escape($this->input->post('title'));
            $data['section_id'] = html_escape($this->input->post('section_id'));
            $data['last_modified'] = strtotime(date('D, d-M-Y'));
            $data['summary'] = html_escape($this->input->post('summary'));
            $this->db->where('id', $lesson_id);
            $this->db->update('lesson', $data);
        }

        // Get quiz questions
        public function get_quiz_questions($quiz_id) {
            $this->db->order_by("order", "asc");
            $this->db->where('quiz_id', $quiz_id);
            return $this->db->get('question');
        }

        public function get_quiz_question_by_id($question_id) {
            $this->db->order_by("order", "asc");
            $this->db->where('id', $question_id);
            return $this->db->get('question');
        }

        // Add Quiz Questions
        public function add_quiz_questions($quiz_id) {
            $question_type = $this->input->post('question_type');
            if ($question_type == 'mcq') {
                $response = $this->add_multiple_choice_question($quiz_id);
                return $response;
            }
        }

        public function update_quiz_questions($question_id) {
            $question_type = $this->input->post('question_type');
            if ($question_type == 'mcq') {
                $response = $this->update_multiple_choice_question($question_id);
                return $response;
            }
        }
        // multiple_choice_question crud functions
        function add_multiple_choice_question($quiz_id){
            if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
                return false;
            }
            foreach ($this->input->post('options') as $option) {
                if ($option == "") {
                    return false;
                }
            }
            if (sizeof($this->input->post('correct_answers')) == 0) {
                $correct_answers = [""];
            }
            else{
                $correct_answers = $this->input->post('correct_answers');
            }
            $data['quiz_id']            = $quiz_id;
            $data['title']              = html_escape($this->input->post('title'));
            $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
            $data['type']               = 'multiple_choice';
            $data['options']            = json_encode($this->input->post('options'));
            $data['correct_answers']    = json_encode($correct_answers);
            $this->db->insert('question', $data);
            return true;
        }
        // update multiple choice question
        function update_multiple_choice_question($question_id){
            if (sizeof($this->input->post('options')) != $this->input->post('number_of_options')) {
                return false;
            }
            foreach ($this->input->post('options') as $option) {
                if ($option == "") {
                    return false;
                }
            }

            if (sizeof($this->input->post('correct_answers')) == 0) {
                $correct_answers = [""];
            }
            else{
                $correct_answers = $this->input->post('correct_answers');
            }

            $data['title']              = html_escape($this->input->post('title'));
            $data['number_of_options']  = html_escape($this->input->post('number_of_options'));
            $data['type']               = 'multiple_choice';
            $data['options']            = json_encode($this->input->post('options'));
            $data['correct_answers']    = json_encode($correct_answers);
            $this->db->where('id', $question_id);
            $this->db->update('question', $data);
            return true;
        }

        function delete_quiz_question($question_id) {
            $this->db->where('id', $question_id);
            $this->db->delete('question');
            return true;
        }

        function get_application_details() {
            $purchase_code = get_settings('purchase_code');
            $returnable_array = array(
                'purchase_code_status' => get_phrase('not_found'),
                'support_expiry_date'  => get_phrase('not_found'),
                'customer_name'        => get_phrase('not_found')
            );

            $personal_token = "gC0J1ZpY53kRpynNe4g2rWT5s4MW56Zg";
            $url = "https://api.envato.com/v3/market/author/sale?code=".$purchase_code;
            $curl = curl_init($url);

            //setting the header for the rest of the api
            $bearer   = 'bearer ' . $personal_token;
            $header   = array();
            $header[] = 'Content-length: 0';
            $header[] = 'Content-type: application/json; charset=utf-8';
            $header[] = 'Authorization: ' . $bearer;

            $verify_url = 'https://api.envato.com/v1/market/private/user/verify-purchase:'.$purchase_code.'.json';
                $ch_verify = curl_init( $verify_url . '?code=' . $purchase_code );

                curl_setopt( $ch_verify, CURLOPT_HTTPHEADER, $header );
                curl_setopt( $ch_verify, CURLOPT_SSL_VERIFYPEER, false );
                curl_setopt( $ch_verify, CURLOPT_RETURNTRANSFER, 1 );
                curl_setopt( $ch_verify, CURLOPT_CONNECTTIMEOUT, 5 );
                curl_setopt( $ch_verify, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.13) Gecko/20080311 Firefox/2.0.0.13');

                $cinit_verify_data = curl_exec( $ch_verify );
                curl_close( $ch_verify );

                $response = json_decode($cinit_verify_data, true);

                if (count($response['verify-purchase']) > 0) {

                    //print_r($response);
                    $item_name 				= $response['verify-purchase']['item_name'];
                    $purchase_time 			= $response['verify-purchase']['created_at'];
                    $customer 				= $response['verify-purchase']['buyer'];
                    $licence_type 			= $response['verify-purchase']['licence'];
                    $support_until			= $response['verify-purchase']['supported_until'];
                    $customer 				= $response['verify-purchase']['buyer'];

                    $purchase_date			= date("d M, Y", strtotime($purchase_time));

                    $todays_timestamp 		= strtotime(date("d M, Y"));
                    $support_expiry_timestamp = strtotime($support_until);

                    $support_expiry_date	= date("d M, Y", $support_expiry_timestamp);

                    if ($todays_timestamp > $support_expiry_timestamp)
                    $support_status		= get_phrase('expired');
                    else
                    $support_status		= get_phrase('valid');

                    $returnable_array = array(
                        'purchase_code_status' => $support_status,
                        'support_expiry_date'  => $support_expiry_date,
                        'customer_name'        => $customer
                    );
                }
                else {
                    $returnable_array = array(
                        'purchase_code_status' => 'invalid',
                        'support_expiry_date'  => 'invalid',
                        'customer_name'        => 'invalid'
                    );
                }

                return $returnable_array;
            }
        }
