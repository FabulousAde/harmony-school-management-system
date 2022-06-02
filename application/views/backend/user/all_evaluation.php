<?php
$get_all_evaluation = $this->crud_model->get_all_evaluation()->result_array();
// $direct_evaluation = $evaluation->row_array();
// $get_allsubmited_eval = $this->crud_model->get_all_submitedevaluation($direct_evaluation['id'])->result_array();
// echo count($evaluation);
$valid_course = [];
foreach ($get_all_evaluation as $key => $all_evaluation) {
    $eval_category = $all_evaluation['category'];
    $category = $this->crud_model->get_category_details_by_id($eval_category)->row_array();
    // $category_parent = ;
    $main_category = $this->crud_model->get_category_details_by_id($category['parent'])->row_array();
    $instructor = $this->crud_model->get_all_instructors($this->session->userdata('user_id'))->row_array();
    if(get_phrase($instructor['class_options']) == $main_category['name']){
        array_push($valid_course, $all_evaluation['id']);
    }
    
}
?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-12">
    <?php
    if(count($valid_course) == 0):
    ?>
    <div class="img-fluid w-100 text-center">
      <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
      <?php echo get_phrase('no_data_found'); ?>
    </div>
    <?php else: ?>
    <?php
    foreach($valid_course as $evaluation):
        $evaluation_details = $this->crud_model->get_evaluation_by_id($evaluation)->row_array();
        $number_ofsubmission = $this->crud_model->get_all_submitedevaluation($evaluation_details['id']);
        $course_details = $this->crud_model->get_course_by_id($evaluation_details['course_id'])->row_array();
    ?>
    <div class="card">
        <div class="card-body">
            <a href="<?php echo site_url('user/course_form/evaluation/'.$evaluation_details['id']); ?>"><h4><?php echo $evaluation_details['evaluation_tittle']; echo " - ".$course_details['title']; ?></h4></a>
            <!--<h6><?php // echo get_phrase('assignment_course:');  ?></h6>-->
            <h6><?php echo get_phrase('no_of_submission'); ?>: <?php echo $number_ofsubmission->num_rows(); ?></h6>
            <h6><?php echo get_phrase('time_uploaded: '); echo date('d-m-Y', $evaluation_details['date_saved']); ?></h6>
        </div>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
</div>



