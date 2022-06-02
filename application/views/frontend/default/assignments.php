<?php
$my_studyhistory = $this->user_model->study_history()->result_array();
$my_evaluation = $this->user_model->get_written_evaluation_by_userid($this->session->userdata('user_id'));

?>

<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('my_assignments'); ?></h1>
                <ul>
                  <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                  <!--<li><a href="<?php // echo site_url('home/my_wishlist'); ?>"><?php // echo get_phrase('wishlists'); ?></a></li>-->
                  <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                  <li class="active"><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                  <li><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
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
        <div class="row">
            <div class="col category-course-list" style="padding: 35px;">
                <ul>
                    <?php $rtcount = 0;
                        if(count($my_evaluation) < 1):
                    ?>
                    <div class="col-md-12">
                        <div class="card mg-10">
                            <div class="card-body">
                                <div class="text-center"><?php echo get_phrase("no_assigment_available"); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <?php else:
                        foreach($my_evaluation as $detail):  ?>
                        <?php
                            $evaluation_details = $this->crud_model->get_evaluation_by_id($detail)->row_array();
                        // $get_course_details = $this->crud_model->get_course_by_id($detail)->row_array();
                        $status = $this->crud_model->check_for_userevalution($this->session->userdata('user_id'), $detail);
                        $mark = $this->crud_model->get_all_submitedevaluation($detail, $this->session->userdata('user_id'))->row_array();
                        $course_details = $this->crud_model->get_course_by_id($evaluation_details['course_id'])->row_array();
                        ?>
                        <li>
                            <div class="course-box-2">
                                <div class="course-image">
                                    <a href="javascript::0">
                                        <img src="<?php echo site_url('uploads/system/assignments.jpeg'); ?>" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="course-details">
                                    <a href="<?php // echo site_url('home/course/'.slugify($get_course_details['title']).'/'.$get_course_details['id']); ?>" class="course-title h5"><?php echo $evaluation_details['evaluation_tittle']; ?></a>
                                    <div class="course-meta">
                                        <div>
                                            <i class="fas fa-bookmark"></i>
                                            &nbsp;<span> <?php echo $course_details['title']; ?></span>
                                        </div>
                                        <div>
                                            <i class="fas fa-check-circle"></i><span style="font-size: 13px;">
                                            &nbsp;Status: <?php if($status !== false): echo get_phrase("$status");
                                            else:
                                        echo get_phrase("active");  
                                            endif;
                                            ?>
                                        </span>
                                        </div>
                                        <div>
                                             <span>
                                                <i class="fas fa-clock"></i>
                                                <?php echo get_phrase("assignment_time").": 12 hours"; ?>
                                            </span>
                                        </div>
                                        <?php if($mark['marked'] == 1): ?>
                                        <div>
                                            <i class="fas fa-check"></i><b> &nbsp;Mark: <?php echo $mark['mark_obtain']; ?></b>
                                        </div>
                                        <?php endif; ?>
                                        <div class="form-group" style="margin-top: 10px;">
                                            <?php if($evaluation_details['status'] == '1'): ?>
                                            <a href="<?php echo site_url("home/assignments_expand/$detail"); ?>" class="btn btn-outline-primary btn-rounded btn-sm ml-1"><?php echo get_phrase("view_and_submit_assignment"); ?></a>
                                            <?php else: ?>
                                            <a class="btn btn-outline-primary btn-rounded btn-sm ml-1" disabled><?php echo get_phrase("view_and_submit_assignment"); ?></a>
                                            <?php endif; ?>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                        </li>
                    <?php
                        endforeach; 
                        endif;
                    ?>
                </ul> 
                <?php // echo get_frontend_settings('terms_and_condition'); ?>
            </div>
        </div>
    </div>
</section>
<style>
    .modal-header .modal-title{
        display: none;
    }
</style>
