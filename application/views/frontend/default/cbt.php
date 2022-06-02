<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('cbt_exams'); ?></h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                    <li><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
                    <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_results'); ?></a></li>
                    <li><a href="<?php echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li>
                    <?php if(get_settings('use_past_question') == '1'): ?>
                    <li><a href="<?php echo site_url('home/pastquestion'); ?>"><?php echo get_phrase('past_question'); ?></a></li>
                    <?php endif; ?>
                    <li class="active"><a href="<?php echo site_url('home/cbt'); ?>"><?php echo get_phrase('cbt_exams'); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row mt-4">
            <div class="col category-course-list" style="padding: 35px;">
                <ul>
                    <?php
                        if(count($all_cbt) < 1):
                    ?>
                        <div class="col category-course-list">
                            <div class="col-md-12">
                                <div class="card mg-10">
                                    <div class="card-body">
                                        <div class="text-center"><?php echo get_phrase("theres_nothing_here_yet"); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <?php foreach($all_cbt as $exam_id): ?>
                            <?php
                                $exam = $this->crud_model->get_cbtexams($exam_id)->row_array();
                                $number_of_lessons = $this->crud_model->get_exams($exam['id']);
                            ?>
                            <li>
                                <div class="course-box-2">
                                    <div class="col-sm-12 row">
                                        <div class="course-image col-xs-12 col-sm-12 col-xl-3 col-lg-3">
                                            <a href="<?php echo site_url('home/cbt/desc/'.($exam['id']+224)); ?>">
                                                <img src="<?php echo site_url('uploads/system/cbt.jpeg'); ?>" alt="" class="img-fluid">
                                            </a>
                                        </div>

                                        <div class="course-details">
                                            <a href="<?php echo site_url('home/cbt/desc/'.($exam['id']+224)); ?>" class="course-title h5"><?php echo $exam['tittle']; ?></a>
                                            <div class="course-meta">
                                                <div>
                                                     <span>
                                                        <i class="far fa-clock" style="color: #000;"></i>
                                                        &nbsp;<span><?php echo get_phrase('course_count'); ?>: <span style="font-weight: 800; font-size: 1em;"><?php echo $number_of_lessons->num_rows(); ?></span></span>
                                                    </span>
                                                </div>

                                                <div>
                                                    <i class="fas fa-stopwatch"></i>
                                                    &nbsp;<span style="font-weight: 800; font-size: 1em;"> <?php echo $exam['exam_time']; ?></span>
                                                </div>
                                                <div>
                                                     <span>
                                                        <i class="fas fa-language" style="color: #000;"></i>
                                                        <span><?php echo get_phrase('language').': '.get_phrase('english'); ?></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>