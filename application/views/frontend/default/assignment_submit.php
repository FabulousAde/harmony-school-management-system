<?php
$get_assignment_details = $this->crud_model->get_evaluation_by_id($assignment_details)->row_array();
$user_id = $this->session->userdata('user_id');
$submitted_status = $this->crud_model->check_for_userevalution($user_id, $assignment_details);
$course_details = $this->crud_model->get_course_by_id($get_assignment_details['course_id'])->row_array();
if($get_assignment_details['status'] == '0' || $submitted_status == 'submitted' || $submitted_status == 'marked') {
    redirect(site_url('home/my_assignments'), 'refresh');
}
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
                <ul class="">
                    <div class="col-md-12 col-sm-12 col-lg-12">
                        <div class="">
                            <div class="card pd-10 col-sm-12">
                                <div class="col-sm-12">
                                    <strong class="h4 strong box-tittle">
                                        <?php echo $get_assignment_details['evaluation_tittle']; ?>
                                    </strong>
                                </div><br>
                                <div class="col-sm-12">
                                    <strong class="h6">
                                        <?php echo "<span style='font-weight: bold;'>".get_phrase("description").": </span>".$get_assignment_details['description'];?>
                                    </strong>
                                </div>
                                <div class="col-sm-12">
                                    <strong class="h6">
                                        <?php echo "<span style='font-weight: bold;'>".get_phrase("course_title").": </span>".$course_details['title'];?>
                                    </strong>
                                </div>
                                <div class="text-center">
                                    <?php if($get_assignment_details['file_attachment'] !== null || $get_assignment_details['file_attachment'] !== ""): ?>
                                     <div class="mt-5"> 
                                        <a href="<?php echo base_url().'uploads/evaluation_files/'.$get_assignment_details['file_attachment']; ?>" class="btn btn-sign-up" download style="color: #fff;">
                                            <i class="fa fa-download" style="font-size: 20px;"></i> <?php echo get_phrase('download').' '.$get_assignment_details['evaluation_tittle']; ?>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="mt-5 text-center">
                                    <a href="javascript:void(0)" id="show_btn" class="btn btn-primary"><?php echo get_phrase("show_submit_box"); ?></a>
                                </div>
                            </div>
                        </div>
                        <br>
                        <form action="<?php echo site_url('home/submit_assignment')."/".$assignment_details; ?>" method="post" enctype="multipart/form-data" class="hidden" id="student_form">
                            <div class="">
                                <div class="card pd-10 col-sm-12">
                                    <div class="col-sm-12">
                                        <strong class="h4 strong box-tittle">
                                            <?php echo get_phrase('submit_assignment'); ?>
                                        </strong>
                                    </div><br>
                                    <div class="text-center form-group">
                                        <input type="file" name="student_assignment" id="student_assignment" accept="*" class="form-control" required>
                                    </div>
                                    <div class="mt-5 text-center">
                                        <button type="submit" class="btn btn-primary"><?php echo get_phrase("submit_assignment"); ?></button>
                                    </div>
                                </div>
                                <input type="hidden" name="hds" id="hds" value="<?php echo $get_assignment_details['id']; ?>">
                            </div>
                        </form>
                    </div>
                </ul> 
                <?php // echo get_frontend_settings('terms_and_condition'); ?>
            </div>
        </div>
    </div>
</section>
<style>
    .pd-10{
        padding: 20px;
    }
    .box-tittle{
        font-weight: bold;
    }
</style>
<script>
    $(document).ready(function () {
       $('#show_btn').on('click', function(){
            $('#student_form').attr('class', '');
        }); 
    });
</script>