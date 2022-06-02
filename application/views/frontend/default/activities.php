<?php
$activities = $all_activities->result_array();
?>
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
                    <li><a href=""><?php echo get_phrase('user_profile'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_results'); ?></a></li>
                    <li class="active"><a href="<?php echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li>
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
                    <?php
                        if($all_activities->num_rows() < 1):
                    ?>
                    <div class="col-md-12">
                        <div class="card mg-10">
                            <div class="card-body">
                                <div class="text-center"><?php echo get_phrase("no_activity_available"); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <?php else: foreach($activities as $key => $activity): ?>
                    <li>
                            <div class="course-box-2">
                                <div class="col-sm-12 row">
                                    <div class="course-image col-xs-12 col-sm-12 col-xl-3 col-lg-3">
                                        <a href="<?php echo site_url('home/activiities/'.($activity['id']+28)); ?>">
                                            <img src="<?php echo site_url('uploads/system/activities.png'); ?>" alt="" class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="course-details">
                                        <a href="<?php echo site_url('home/activiities/'.($activity['id']+28)); ?>" class="course-title h5"><?php echo $activity['tittle']; ?></a>
                                        <div class="course-meta">
                                            <div>
                                                <i class="fas fa-stopwatch"></i>
                                                &nbsp;<span> <?php echo date('D d M, Y', strtotime($activity['start_date'])); ?> - <?php echo date('D d M, Y', strtotime($activity['end_date'])); ?></span>
                                            </div>
                                            
                                            <div>
                                                 <span>
                                                    <i class="far fa-clock" style="color: #000;"></i>
                                                    &nbsp;<span><?php echo get_phrase('activity_year'); ?>: <?php echo $activity['activity_year']; ?></span>
                                                </span>
                                            </div>
                                            <div>
                                                 <span>
                                                    <i class="fas fa-award" style="color: #000;"></i>
                                                    &nbsp;<span><?php echo get_phrase('session').' : '.get_phrase($activity['activity_session'].'_term'); ?></span>
                                                </span>
                                            </div>
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
            </div>
        </div>
    </div>
</section>