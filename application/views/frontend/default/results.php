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
    // $config['source_image'] = 'uploads/system/hbs_certificate.png';
    // $config['wm_text'] = 'Awotundun Maimunah';
    // $config['wm_type'] = 'text';
    // $config['new_image'] = 'uploads/system/new_image.png';
    // $config['wm_font_path'] = 'uploads/system/fonts/Lato-Bold.ttf';
    // $config['wm_font_size'] = '59';
    // $config['wm_font_color'] = '153385';
    // $config['wm_vrt_alignment'] = 'middle';
    // $config['wm_hor_alignment'] = 'center';
    // // $config['wm_padding'] = '-70';
    // // $config['wm_vrt_alignment'] = 'top';
    // // $config['wm_hor_alignment'] = 'left';
    // // $config['wm_hor_offset'] = 200; // px
    // $config['wm_vrt_offset'] = -160; // px
    // $this->image_lib->initialize($config);
    // $this->image_lib->watermark();

    // $config['source_image'] = 'uploads/system/new_image.png';
    // $config['wm_text'] = 'Mathematics';
    // $config['wm_type'] = 'text';
    // $config['new_image'] = 'uploads/system/new_image.png';
    // $config['wm_font_path'] = 'uploads/system/fonts/Lato-Regular.ttf';
    // $config['wm_font_size'] = '30';
    // $config['wm_font_color'] = '153385';
    // $config['wm_vrt_alignment'] = 'middle';
    // $config['wm_hor_alignment'] = 'center';
    // // $config['wm_padding'] = '-70';
    // // $config['wm_vrt_alignment'] = 'top';
    // // $config['wm_hor_alignment'] = 'left';
    // // $config['wm_hor_offset'] = 80; // px
    // $config['wm_vrt_offset'] = 140; // px
    // $this->image_lib->initialize($config);
    // $this->image_lib->watermark();



    // if (!$this->image_lib->watermark()) {
    //     echo $this->image_lib->display_errors();
    //     // echo $this->image_lib->source_image;
    // }
    // echo $this->image_lib->watermark();
?>

<?php
$logs = $all_result_logs->result_array();
?>
<style type="text/css">
    .course-box-2 {
        min-height: auto;
    }
</style>
<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('purchase_history'); ?></h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                    <li><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
                    <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                    <li class="active"><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_certificates'); ?></a></li>
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
                                        <a href="<?php echo site_url('home/my_results/'.$get_course_details['id']) ?>">
                                            <img src="<?php echo $this->crud_model->get_course_thumbnail_url($get_course_details['id']); ?>" alt="" class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="course-details col-xs-12 col-sm-12 col-xl-9 col-lg-9">
                                    <a href="<?php echo site_url('home/my_results/'.$get_course_details['id']); ?>" class="course-title"><?php echo $get_course_details['title']; ?></a>
                                    <div class="course-meta">
                                        <div>
                                             <span>
                                                <i class="far fa-clock"></i>
                                                <?php echo get_phrase("time_obtained").": ". $datelastst[$rtcount] ?>
                                            </span>
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

<!-- <section class="category-course-list-area">
    <div class="container">
        <div class="row">
            <div class="col category-course-list" style="padding: 35px;">
                <ul>
                    <img class="img-responsive" src="<? // = site_url('uploads/system/new_image.png'); ?>">
                    <?php
                        // if($all_result_logs->num_rows() < 1):
                    ?>
                    <div class="col-md-12">
                        <div class="card mg-10">
                            <div class="card-body">
                                <div class="text-center"><?php // echo get_phrase("theres_nothing_here_yet"); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <?php // else: foreach($logs as $key => $log): ?>
                    <li>
                            <div class="course-box-2">
                                <div class="course-image">
                                    <a href="<?php // echo site_url('home/my_results/'.($log['id'])); ?>">
                                        <img class="image_session" src="<?php // echo site_url('uploads/system/'); if($log['session'] == 'first'){ echo '1-12.jpg'; }elseif($log['session'] == 'second'){ echo '2-11.jpg'; }else{ echo '3-11.png'; }; ?>" alt="" class="img-fluid">
                                    </a>
                                </div>
                                <div class="course-details">
                                    <a href="<?php // echo site_url('home/my_results/'.($log['id'])); ?>" class="course-title h5"><?php // echo ucfirst($user['first_name']).' '.ucfirst($user['last_name']).'  ('.get_phrase($log['class_category'].'_class').')'; ?></a>
                                    <div class="course-meta">
                                        <div>
                                             <span>
                                                <i class="far fa-clock" style="color: #000;"></i>
                                                &nbsp;<span><?php // echo get_phrase('session'); ?>: <?php // echo get_phrase($log['session'].'_term'); ?></span>
                                            </span>
                                        </div>
                                        <div>
                                             <span>
                                               <i class="far fa-calendar-alt" style="color: #000;"></i>
                                                &nbsp;<span><?php // echo get_phrase('year').' : <b>'.get_phrase($log['year_session']).'</b>'; ?></span>
                                            </span>
                                        </div>
                                        <div>
                                             <span>
                                                <i class="fas fa-award" style="color: #000;"></i>
                                                &nbsp;<span><?php // echo get_phrase('result_class').' : '.get_phrase($log['class_category'].'_class'); ?></span>
                                            </span>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php
                        // endforeach; 
                        // endif;
                    ?>
                </ul> 
            </div>
        </div>
    </div>
</section> -->

<style>
    img.image_session {
       height: 100px;
       width: auto;
    }
    .course-box-2 .course-image {
        width: 24%;
    }
    @media screen and (min-width: 768px){
        img.image_session {
            height: 111px;
            width: auto;
            margin: 18px 0 0 57px;
        }
    }
</style>