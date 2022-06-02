<?php
$my_studyhistory = $this->user_model->study_history()->result_array();

$categories = array();
$couse_scoredetails = array();
$overall = array();
$datelastst = array();
$total_retry = $overallhigest = array();
foreach ($my_studyhistory as $study_course) {
    $course_details = $this->crud_model->get_lessons('lesson', $study_course['course_id'])->row_array();
    if (!in_array($course_details['course_id'], $categories)) {
        array_push($categories, $course_details['course_id']);
        $dbgethigest = $this->crud_model->getuser_max_in_table('study', 'score_obtained', 'course_id',  $study_course['course_id']);
        array_push($couse_scoredetails, $dbgethigest['user_highest_score']);
        array_push($overall, $dbgethigest['number_ofq']);
        array_push($datelastst, date('D d-m-Y, h:i a', $dbgethigest['date_laststudy']));
        array_push($total_retry, $dbgethigest['number_oftry']);
        
        $dbgetoverall = $this->crud_model->get_max_in_table('study', 'score_obtained', 'course_id',  $study_course['course_id']);
        array_push($overallhigest, $dbgetoverall['overall_highest_score']);
    }
    // array_push($total_retry, $dbgethigest['number_oftry']);
}
// echo $course_details['course_id'];
// echo $course_details['course_id'];
?>

<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('study_history'); ?></h1>
                <ul>
                  <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                  <li class="active"><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
                  <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                  <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_certificates'); ?></a></li>
                  <!-- <li><a href="<?php // echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li> -->
                  <?php if(get_settings('use_past_question') == '1'): ?>
                        <li><a href="<?php echo site_url('home/pastquestion'); ?>"><?php echo get_phrase('past_question'); ?></a></li>
                  <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>


<section class="category-course-list-area">
    <div class="container">
        <div class="">
            <div class="col category-course-list" style="padding: 35px;">
                <ul>
                    <?php $rtcount = 0;
                    foreach($categories as $detail):  ?>
                    <?php // echo $detail; ?>
                        <?php $get_course_details = $this->crud_model->get_course_by_id($detail)->row_array();
                        // $dbgethigest = $this->crud_model->get_max_in_table('study', 'score_obtained', 'course_id', '9');
                        // $couse_image = $get_course_details[''];
                        
                        ?>
                        <li>
                            <div class="course-box-2">
                                <div class="col-sm-12 row">
                                    <div class="course-image col-xs-12 col-sm-12 col-xl-3 col-lg-3">
                                        <a href="<?php echo site_url('home/course/'.slugify($get_course_details['title']).'/'.$get_course_details['id']) ?>">
                                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($get_course_details['id']); ?>" alt="" class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="course-details col-xs-12 col-sm-12 col-xl-9 col-lg-9">
                                    <a href="<?php echo site_url('home/course/'.slugify($get_course_details['title']).'/'.$get_course_details['id']); ?>" class="course-title"><?php echo $get_course_details['title']; ?></a>
                                    <div class="course-meta">
                                        <div>
                                            <i class="fas fa-check-circle" style="color: #A5A8AF;"></i>
                                        <span style="font-size: 13px;">
                                            Your highest score <?php echo $couse_scoredetails[$rtcount]." / ".$overall[$rtcount];  ?>
                                        </span>
                                        </div>
                                        
                                        <div>
                                            <span><i class="fas fa-redo"></i> <?php echo get_phrase("attempts").": ". $total_retry[$rtcount];  ?></span>
                                        </div>
                                        <div>
                                             <span>
                                                <i class="far fa-clock"></i>
                                                <?php echo get_phrase("last attempt").": ". $datelastst[$rtcount] ?>
                                            </span>
                                        </div>
                                        <div>
                                            <span><i class="fas fa-clipboard-check"></i>
                                             <?php echo get_phrase('Overall higest'). ": " .$overallhigest[$rtcount] ?>
                                            </span>
                                        </div>
                                        <div>
                                            <?php //echo $get_course_details['title']; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <?php $rtcount++;  ?>
                                </div>
                                
                            </div>
                        </li>
                    <?php endforeach;  ?>
                </ul> 
                <?php // echo get_frontend_settings('terms_and_condition'); ?>
            </div>
        </div>
    </div>
</section>
