<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        /*cache control*/
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        
        $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
        
        // $userrole = ;
        
        if ($user_details['is_instructor'] != '1' || $user_details['status'] != '1' || get_settings('allow_instructor') != 1){
            redirect(site_url('home'), 'refresh');
        }
        
    }

    public function index() {
        if ($this->session->userdata('user_login') == true) {
            $this->courses();
        }else {
            redirect(site_url('login'), 'refresh');
        }
    }

    public function courses() {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['selected_category_id']   = isset($_GET['category_id']) ? $_GET['category_id'] : "all";
        $page_data['selected_instructor_id'] = $this->session->userdata('user_id');
        $page_data['selected_price']         = isset($_GET['price']) ? $_GET['price'] : "all";
        $page_data['selected_status']        = isset($_GET['status']) ? $_GET['status'] : "all";
        $page_data['courses']                = $this->crud_model->filter_course_for_backend($page_data['selected_category_id'], $page_data['selected_instructor_id'], $page_data['selected_price'], $page_data['selected_status']);
        $page_data['page_name']              = 'courses';
        $page_data['categories']             = $this->crud_model->get_categories();
        $page_data['page_title']             = get_phrase('active_courses');
        $this->load->view('backend/index', $page_data);
    }

    public function cbt($param1 = '', $param2 = '') {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if($param1 == '') {
          $page_data['page_name']              = 'cbt';
          $page_data['categories']             = $this->crud_model->get_categories();
          $page_data['exams']                  = $this->crud_model->get_cbtexams('', $this->session->userdata('user_id'))->result_array();
          $page_data['page_title']             = get_phrase('cbt_exams');
          $this->load->view('backend/index', $page_data);
        } elseif($param1 == 'new') {
          $page_data['categories']             = $this->crud_model->get_categories();
          $page_data['page_name']              = 'new_cbt';
          $page_data['page_title']             = get_phrase('create_new_cbt_exams');
          $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'add') {
          $this->crud_model->add_cbtexam_instructor();
          redirect(site_url('user/cbt'), 'refresh');
        } elseif ($param1 == 'performance') {
          $page_data['page_name']              = 'cbt_performance';
          $page_data['exam_id']                = $param2;
          $page_data['enrols']                 = $this->crud_model->fetch_examenrols($param2, true);
          // $page_data['categories']             = $this->crud_model->get_categories();
          $page_data['exams']                  = $this->crud_model->get_cbtexams()->result_array();
          $page_data['page_title']             = get_phrase('cbt_exams_performance');
          $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'edit') {
          $page_data['page_name']              = 'cbt_edit';
          $page_data['exam_id']                = $param2;
          $page_data['exam']                   = $this->crud_model->get_cbtexams($param2, $this->session->userdata('user_id'))->row_array();
          $page_data['categories']             = $this->crud_model->get_categories();
          $page_data['page_title']             = get_phrase('cbt_exams');
          $this->load->view('backend/index', $page_data);
        } elseif ($param1 == 'delete') {
          $this->crud_model->delete_exam($param2);
          $this->session->set_flashdata('flash_message', get_phrase('exam_been_deleted_successfully'));
          redirect('user/cbt/');
        } elseif ($param1 == 'activate') {
          $this->crud_model->activate_cbt($param2);
          redirect(site_url('user/cbt'), 'refresh');
        } elseif ($param1 == 'deactivate') {
          $this->crud_model->deactivate_cbt($param2);
          redirect(site_url('user/cbt'), 'refresh');
        }
      }

    public function exam_edit($param2 = '') {
          $this->crud_model->edit_cbtexam($param2);
          redirect(site_url('user/cbt'), 'refresh');
    }

    public function cbt_exams($exam_id = "", $action = "", $quiz_id = "") {
        if ($this->session->userdata('user_login') != true) {
          redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
          $this->crud_model->add_exam($exam_id);
          $this->session->set_flashdata('flash_message', get_phrase('exam_has_been_added_successfully'));
        }
        elseif ($action == 'edit') {
          $this->crud_model->edit_exam($exam_id);
          $this->session->set_flashdata('flash_message', get_phrase('exam_has_been_updated_successfully'));
        }
        elseif ($action == 'delete') {
          $this->crud_model->delete_examlesson($quiz_id);
          $this->session->set_flashdata('flash_message', get_phrase('exam_has_been_deleted_successfully'));
        }
        redirect(site_url('user/cbt/edit/'.$exam_id));
      }

        // Manage Exam Questions
      public function exam_questions($exam_id = "", $action = "", $question_id = "") {
        if ($this->session->userdata('user_login') != true) {
          redirect(site_url('login'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_exams('', $exam_id)->row_array();

        if ($action == 'add') {
          $response = $this->crud_model->add_exam_questions($exam_id);
          echo $response;
        }

        elseif ($action == 'edit') {
          $response = $this->crud_model->update_exam_questions($question_id);
          echo $response;
        }

        elseif ($action == 'delete') {
          $response = $this->crud_model->delete_exam_question($question_id);
          $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
          redirect(site_url('user/cbt/edit/'.$quiz_details['exam_id']));
        }
      }

    public function course_actions($param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == "add") {
            $this->crud_model->add_course();
            redirect(site_url('user/courses'), 'refresh');

        }
        elseif ($param1 == "edit") {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->update_course($param2);
            redirect(site_url('user/courses'), 'refresh');

        }
        elseif ($param1 == 'delete') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->delete_course($param2);
            redirect(site_url('user/courses'), 'refresh');
        }
        elseif ($param1 == 'draft') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('draft', $param2);
            redirect(site_url('user/courses'), 'refresh');
        }
        elseif ($param1 == 'publish') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $this->crud_model->change_course_status('pending', $param2);
            redirect(site_url('user/courses'), 'refresh');
        }
    }
    
    public function evaluation($param1 = "") {
        $page_data['page_name'] = 'all_evaluation';
        $page_data['page_title'] = get_phrase('evaluations');
        $this->load->view('backend/index', $page_data);
    }


    public function result($param1 = "", $param2 = "", $param3 = "")
    {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if($param1 == ''){
            $user_details = $this->user_model->get_user($this->session->userdata('user_id'))->row_array();
            $instructor_class = $user_details['class_options'];
            $page_data['languages'] = $this->get_all_languages();
            $page_data['page_name'] = 'result';
            $page_data['page_title'] = get_phrase('result');
            $page_data['users'] = $this->crud_model->filter_users_for_backend($instructor_class, 'all');
            $this->load->view('backend/index', $page_data);
        }elseif($param1 == 'new'){
            $page_data['languages'] = $this->get_all_languages();
            $page_data['page_name'] = 'new_result';
            $page_data['page_title'] = get_phrase('new_result');
            $page_data['user'] = $this->user_model->get_user($param2)->row_array();
            $this->load->view('backend/index', $page_data);
        }elseif($param1 == 'save'){
            $this->crud_model->save_result();
            $this->session->set_flashdata('flash_message', get_phrase('result_saved_sucessfully'));
            redirect(('user/result'), 'refresh');
        }elseif($param1 == 'view'){
          $page_data['page_name'] = 'view_result';
          $page_data['page_title'] = get_phrase('view_result');
          $page_data['user'] = $this->user_model->get_user($param2)->row_array();
          $page_data['all_result_log'] = $this->crud_model->get_result_logs($page_data['user']);
          $this->load->view('backend/index', $page_data);
        }elseif($param1 == 'edit'){
          $page_data['page_name'] = 'edit_result';
          $page_data['page_title'] = get_phrase('edit_result');
          $page_data['user'] = $this->user_model->get_user($param3)->row_array();
          $page_data['all_result_log'] = $this->crud_model->get_result_logs($page_data['user'], $param2)->row_array();
          $this->load->view('backend/index', $page_data);
        }elseif($param1 == 'update'){
            $user = $this->user_model->get_user($param3)->row_array();
            $result_log = $this->crud_model->get_result_logs($user, $param2)->row_array();
            $resp = $this->crud_model->update_result($result_log);

            // $this->crud_model->update_result($param2);
            $this->session->set_flashdata('flash_message', get_phrase('result_update_sucessfully'));
            redirect(('user/result/view/'.$param3.''), 'refresh');
        }
    }

    public function course_form($param1 = "", $param2 = "") {

        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'add_course') {
            $page_data['languages']	= $this->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories_by_userref("", $this->session->userdata('user_id'));
            $page_data['resources'] = $this->crud_model->get_allresources()->result_array();
            $page_data['page_name'] = 'course_add';
            $page_data['page_title'] = get_phrase('add_course');
            $this->load->view('backend/index', $page_data);

        }elseif ($param1 == 'course_edit') {
            $this->is_the_course_belongs_to_current_instructor($param2);
            $page_data['page_name'] = 'course_edit';
            $page_data['course_id'] =  $param2;
            $page_data['page_title'] = get_phrase('edit_course');
            $page_data['languages']	= $this->get_all_languages();
            $page_data['categories'] = $this->crud_model->get_categories();
            $this->load->view('backend/index', $page_data);
        }elseif ($param1 == 'evaluation'){
            $page_data['languages']   = $this->get_all_languages();
          $page_data['categories'] = $this->crud_model->get_categories();
        //   $page_data['resources'] = $this->crud_model->get_allresources()->result_array();
          $page_data['evaluation'] = $this->crud_model->get_evaluation_by_id($param2, "course_id");
          $page_data['param2'] = $param2;
          $page_data['page_name'] = 'mark_evaluation';
          $page_data['page_title'] = get_phrase('course_evaluations');
          $this->load->view('backend/index', $page_data);
        }
    }
    
    public function mark_evaluation_ajax() {
          $userdetails = $this->input->post();
          $returnresponse = $this->crud_model->mark_evaluation($userdetails);
          echo json_encode($returnresponse);
    }

    public function payment_settings($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 == 'paypal_settings') {
            $this->user_model->update_instructor_paypal_settings($this->session->userdata('user_id'));
            redirect(site_url('user/payment_settings'), 'refresh');
        }
        if ($param1 == 'stripe_settings') {
            $this->user_model->update_instructor_stripe_settings($this->session->userdata('user_id'));
            redirect(site_url('user/payment_settings'), 'refresh');
        }

        $page_data['page_name'] = 'payment_settings';
        $page_data['page_title'] = get_phrase('payment_settings');
        $this->load->view('backend/index', $page_data);
    }

    public function instructor_revenue($param1 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param1 != "") {
            $date_range                   = $this->input->post('date_range');
            $date_range                   = explode(" - ", $date_range);
            $page_data['timestamp_start'] = strtotime($date_range[0]);
            $page_data['timestamp_end']   = strtotime($date_range[1]);
        }else {
            $page_data['timestamp_start'] = strtotime('-29 days', time());
            $page_data['timestamp_end']   = strtotime(date("m/d/Y"));
        }
        $page_data['payment_history'] = $this->crud_model->get_instructor_revenue($page_data['timestamp_start'], $page_data['timestamp_end']);
        $page_data['page_name'] = 'instructor_revenue';
        $page_data['page_title'] = get_phrase('instructor_revenue');
        $this->load->view('backend/index', $page_data);
    }
    
    public function add_resources($para = '') {
          $page_data['languages'] = $this->get_all_languages();
          $page_data['categories'] = $this->crud_model->get_categories();
          $page_data['page_name'] = 'add_resources';
          $page_data['page_title'] = get_phrase('add_resources');
          $this->load->view('backend/index', $page_data);
    }
    
      public function upload_course_resources() {
          if ($this->session->userdata('admin_login') != true) {
              redirect(site_url('login'), 'refresh');
          }
    
          $statusmessage = $this->crud_model->upload_resources();
          $this->session->set_flashdata('flash_message', get_phrase($statusmessage));
          redirect(site_url('user/add_resources'), 'refresh');
      }

    function get_all_languages() {
        $language_files = array();
        $all_files = $this->get_list_of_language_files();
        foreach ($all_files as $file) {
            $info = pathinfo($file);
            if( isset($info['extension']) && strtolower($info['extension']) == 'json') {
                $file_name = explode('.json', $info['basename']);
                array_push($language_files, $file_name[0]);
            }
        }
        return $language_files;
    }

    function get_list_of_language_files($dir = APPPATH.'/language', &$results = array()) {
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                $this->get_list_of_directories_and_files($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }

    function get_list_of_directories_and_files($dir = APPPATH, &$results = array()) {
        $files = scandir($dir);
        foreach($files as $key => $value){
            $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
            if(!is_dir($path)) {
                $results[] = $path;
            } else if($value != "." && $value != "..") {
                $this->get_list_of_directories_and_files($path, $results);
                $results[] = $path;
            }
        }
        return $results;
    }

    public function preview($course_id = '') {
        if ($this->session->userdata('user_login') != 1)
        redirect(site_url('login'), 'refresh');

        $this->is_the_course_belongs_to_current_instructor($course_id);
        if ($course_id > 0) {
            $courses = $this->crud_model->get_course_by_id($course_id);
            if ($courses->num_rows() > 0) {
                $course_details = $courses->row_array();
                redirect(site_url('home/lesson/'.slugify($course_details['title']).'/'.$course_details['id']), 'refresh');
            }
        }
        redirect(site_url('user/courses'), 'refresh');
    }

    public function lesson_note($param1 = '', $param2 = ''){
          if($param1 == ""){
            $page_data['all_notes'] = $this->crud_model->get_notes()->result_array();
            $page_data['page_name'] = 'lessonnotes';
            $page_data['page_title'] = get_phrase('lesson_notes');
            $this->load->view('backend/index', $page_data);
          }elseif ($param1 == 'new') {
            $page_data['all_categories'] = $this->crud_model->get_categories()->result_array();
            $page_data['page_name'] = 'new_lessonnote';
            $page_data['page_title'] = get_phrase('add_lesson_notes');
            $this->load->view('backend/index', $page_data);
          }elseif($param1 == 'view'){
            $note = $this->crud_model->get_notes($param2)->row_array();
            $page_data['note'] = $note;
            if($note['instructors_id'] != $this->session->userdata('user_id')){
                redirect(site_url('login'), 'refresh');
            }else{
                $page_data['page_name'] = 'view_lesson';
                $page_data['page_title'] = get_phrase('view_lesson_notes');
                $this->load->view('backend/index', $page_data);
            }
          }elseif ($param1 == 'delete') {
            $this->crud_model->delete_note($param2);
            $this->session->set_flashdata('flash_message', get_phrase('note_deleted'));
            redirect(site_url('user/lesson_note'), 'refresh');
          }
      }

      public function upload_lessonnote(){
          $statusmessage = $this->crud_model->upload_lnote();
          $this->session->set_flashdata('flash_message', get_phrase($statusmessage));
          redirect(site_url('user/lesson_note'), 'refresh');
      }

    public function sections($param1 = "", $param2 = "", $param3 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($param2 == 'add') {
            $this->crud_model->add_section($param1);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_added_successfully'));
        }
        elseif ($param2 == 'edit') {
            $this->crud_model->edit_section($param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_updated_successfully'));
        }
        elseif ($param2 == 'delete') {
            $this->crud_model->delete_section($param1, $param3);
            $this->session->set_flashdata('flash_message', get_phrase('section_has_been_deleted_successfully'));
        }
        redirect(site_url('user/course_form/course_edit/'.$param1));
    }

    public function lessons($course_id = "", $param1 = "", $param2 = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        if ($param1 == 'add') {
            $this->crud_model->add_lesson();
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_added_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'edit') {
            $this->crud_model->edit_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_updated_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'delete') {
            $this->crud_model->delete_lesson($param2);
            $this->session->set_flashdata('flash_message', get_phrase('lesson_has_been_deleted_successfully'));
            redirect('user/course_form/course_edit/'.$course_id);
        }
        elseif ($param1 == 'filter') {
            redirect('user/lessons/'.$this->input->post('course_id'));
        }
        $page_data['page_name'] = 'lessons';
        $page_data['lessons'] = $this->crud_model->get_lessons('course', $course_id);
        $page_data['course_id'] = $course_id;
        $page_data['page_title'] = get_phrase('lessons');
        $this->load->view('backend/index', $page_data);
    }

    // This function checks if this course belongs to current logged in instructor
    function is_the_course_belongs_to_current_instructor($course_id) {
        $course_details = $this->crud_model->get_course_by_id($course_id)->row_array();
        if ($course_details['user_id'] != $this->session->userdata('user_id')) {
            $this->session->set_flashdata('error_message', get_phrase('you_do_not_have_right_to_access_this_course'));
            redirect(site_url('user/courses'), 'refresh');
        }
    }

    // Manage Quizes
    public function quizes($course_id = "", $action = "", $quiz_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }

        if ($action == 'add') {
            $this->crud_model->add_quiz($course_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_added_successfully'));
        }
        elseif ($action == 'edit') {
            $this->crud_model->edit_quiz($quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_updated_successfully'));
        }
        elseif ($action == 'delete') {
            $this->crud_model->delete_section($course_id, $quiz_id);
            $this->session->set_flashdata('flash_message', get_phrase('quiz_has_been_deleted_successfully'));
        }
        redirect(site_url('user/course_form/course_edit/'.$course_id));
    }

    // Manage Quize Questions
    public function quiz_questions($quiz_id = "", $action = "", $question_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $quiz_details = $this->crud_model->get_lessons('lesson', $quiz_id)->row_array();

        if ($action == 'add') {
            $response = $this->crud_model->add_quiz_questions($quiz_id);
            echo $response;
        }

        elseif ($action == 'edit') {
            $response = $this->crud_model->update_quiz_questions($question_id);
            echo $response;
        }

        elseif ($action == 'delete') {
            $response = $this->crud_model->delete_quiz_question($question_id);
            $this->session->set_flashdata('flash_message', get_phrase('question_has_been_deleted'));
            redirect(site_url('user/course_form/course_edit/'.$quiz_details['course_id']));
        }
    }

    function manage_profile() {
        redirect(site_url('home/profile/user_profile'), 'refresh');
    }

    function invoice($payment_id = "") {
        if ($this->session->userdata('user_login') != true) {
            redirect(site_url('login'), 'refresh');
        }
        $page_data['page_name'] = 'invoice';
        $page_data['payment_details'] = $this->crud_model->get_payment_details_by_id($payment_id);
        $page_data['page_title'] = get_phrase('invoice');
        $this->load->view('backend/index', $page_data);
    }
    // Ajax Portion
    public function ajax_get_video_details() {
        $video_details = $this->video_model->getVideoDetails($_POST['video_url']);
        echo $video_details['duration'];
    }

    // this function is responsible for managing multiple choice question
    function manage_multiple_choices_options() {
        $page_data['number_of_options'] = $this->input->post('number_of_options');
        $this->load->view('backend/user/manage_multiple_choices_options', $page_data);
    }

    public function ajax_sort_section() {
        $section_json = $this->input->post('itemJSON');
        $this->crud_model->sort_section($section_json);
    }
    public function ajax_sort_lesson() {
        $lesson_json = $this->input->post('itemJSON');
        $this->crud_model->sort_lesson($lesson_json);
    }
    public function ajax_sort_question() {
        $question_json = $this->input->post('itemJSON');
        $this->crud_model->sort_question($question_json);
    }
    public function ajax_sort_examquestion() {
        $question_json = $this->input->post('itemJSON');
        $this->crud_model->sort_examquestion($question_json);
    }
}
