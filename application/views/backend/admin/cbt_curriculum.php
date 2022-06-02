<div class="row justify-content-center">
    <div class="col-xl-12 mb-4 text-center mt-3">
        <a href="javascript::void(0)" class="btn btn-outline-primary btn-rounded btn-sm ml-1" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_course_add/'.$exam_id); ?>', '<?php echo get_phrase('add_exam_courses'); ?>')"><i class="mdi mdi-plus"></i> <?php echo get_phrase('add_exam_courses'); ?></a>
    </div>

    <div class="col-xl-8">
        <div class="row">
            <?php
            $lesson_counter = 0;
            $quiz_counter   = 0;
            $main_exams = $this->crud_model->get_exams($exam_id)->result_array();
                ?>
            <div class="col-xl-12">
                <div class="card bg-light text-seconday on-hover-action mb-5" id = "section-<?php echo $main_exams['id']; ?>">
                    <div class="card-body">
                        <div class="clearfix"></div>
                        <?php
                        foreach ($main_exams as $index => $current_exam):?>
                        <div class="col-md-12">
                            <!-- Portlet card -->
                            <div class="card text-secondary on-hover-action mb-2" id = "<?php echo 'lesson-'.$current_exam['id']; ?>">
                                <div class="card-body thinner-card-body">
                                    <div class="card-widgets display-none" id = "widgets-of-lesson-<?php echo $current_exam['id']; ?>">
                                        <a href="javascript::" onclick="showLargeModal('<?php echo site_url('modal/popup/exam_questions/'.$current_exam['id']); ?>', '<?php echo get_phrase('manage_exam_questions'); ?>')"><i class="mdi mdi-comment-question-outline"></i></a>
                                        <a href="javascript::" onclick="showAjaxModal('<?php echo site_url('modal/popup/exam_course_edit/'.$current_exam['id'].'/'.$current_exam_id); ?>', '<?php echo get_phrase('update_exam_information'); ?>')"><i class="mdi mdi-pencil-outline"></i></a>
                                        <a href="javascript::" onclick="confirm_modal('<?php echo site_url('admin/cbt_exams/'.$exam_id.'/delete'.'/'.$current_exam['id']); ?>');"><i class="mdi mdi-window-close"></i></a>
                                    </div>
                                    <h5 class="card-title mb-0">
                                        <span class="font-weight-light">
                                            <img src="<?php echo base_url('assets/backend/lesson_icon/quiz.png'); ?>" alt="" height = "16">
                                        </span><?php echo get_phrase('exam').' '.($index+1).': '.$current_exam['title']; ?>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div> <!-- end card-->
        </div>
</div>
</div>
</div>
