<?php
    if(count($cbt) > 0) {
        $cbt_hour = explode(':', $cbt['exam_time'])[0];
        $cbt_min = explode(':', $cbt['exam_time'])[1];
        $class = $this->db->get_where('category', array('id' => $cbt['category_id'], 'parent' => '0'))->row_array();
        $number_of_lessons = $this->crud_model->get_exams($cbt['id']);
        $checkEnrolled = $this->crud_model->checkCbtEnrolled($cbt['id']);
        $quiz_questions = $this->crud_model->get_examquestions($cbt['id']);
    }
    // echo 'hello';
?>

<style type="text/css">
    .exam_error {
        font-weight: 900;
        font-size: 1.1em;
        margin-top: 37px;
    }
    .custom-box {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        box-shadow: 0 0 2em 0 rgba(0, 0, 0, 0.105);
        border-radius: 10px;
        min-height: 148px;
        background-color: #fff;
        padding: 30px 0px;
        margin: 50px 0;
    }
    .text-bold {
        font-weight: bold;
    }
    .btn.proceed-btn {
        margin: 20px 0;
        padding-right: 20px;
        padding-left: 20px;
    }
    .name-underline {
        border-bottom: 1px solid #000111;
        width: auto;
        margin: 0 auto;
    }
    .input .container {
      display: block;
      position: relative;
      padding-left: 30px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 12px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .input label.container text {
        color: red;
    }
    .input .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    .input .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      border-radius: 4px;
      width: 20px;
      background-color: #eee;
    }
    .input .container:hover input ~ .checkmark {
      background-color: #ccc;
    }
    .input .container input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    .input .container input:checked ~ .checkmark:after {
      display: block;
    }
    .input .container .checkmark:after {
      left: 7px;
      top: 4px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
    .input .text {
        color: #83858D;
        font-size: 0.9em;
    }
    .text-div {
        margin: 0 0 7px 0;
    }
    .transp {
        background-color: transparent;
    }
    @media screen and (max-width: 425px) {
        section.category-course-list-area .container .category-course-list {
            padding: 5px !important;
        }
        .course-box-2 .lesson_start, .course-box-2 section .col-sm-12, .course-box-2 .container, .course-box-2 .col, .course-box-2 {
            padding-right: 0;
            padding-left: 0;
        }
        .input .container {
            padding-left: 30px;
        }
        .course-box-2 .container .row:first-child {
            margin-left: 0;
        }
        .list-group-item .form-check {
            padding-left: 4px;
        }
        .bg-quiz-result-info {
            padding: 13px 7px;
        }
        .bg-quiz-result-info .card-body {
            padding: 1.25rem 1.0rem;
        }
    }
</style>
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
                <div class="course-box-2">
                    <div class="col-sm-12 pb-3 pt-1 <?php if(count($cbt) < 1) echo 'justify-content-center'; ?>">
                        <?php if(count($cbt) < 1): ?>
                            <div class="text-center exam_error"><?= get_phrase('this_exam_is_not_valid'); ?></div>
                        <?php else: ?>
                            <div class="col-sm-12 cbt_desc_area mt-3">
                                <div class="col-sm-12">
                                    <div class="mb-2">
                                        <u>
                                            <strong class="h4 strong box-tittle">
                                                <?php echo $cbt['tittle'].'  ('.$number_of_lessons->num_rows().' course)'; ?>
                                            </strong>
                                        </u>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-1">
                                        <strong><i class="far fa-clock" style="color: #000; font-size: 1.4em;"></i> <?= $cbt_hour; ?>hr(s) <?= $cbt_min; ?>min(s)</strong>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-1">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("class").": </span>"; ?>
                                            <?= $class['name']; ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-1">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("exam_questions").": </span>"; ?>
                                            <?= $quiz_questions->num_rows(); ?>
                                        </strong>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="mb-1">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("exam_instruction").": </span>"; ?>
                                            <?= htmlspecialchars_decode($cbt['insructions']); ?>
                                        </strong>
                                    </div>
                                </div>

                                <div class="justify-content-center">
                                    <div class="col-sm-12 text-center">
                                        <?php if(!$checkEnrolled) : ?>
                                            <button href="javascript:void(0)" id="show_btn" class="btn btn-primary" onclick="getStarted('1');"><?php echo get_phrase("start_cbt_exam"); ?></button>
                                        <?php else: ?>
                                            <button href="javascript:void(0)" id="show_btn" disabled class="btn btn-primary disabled"><?php echo get_phrase("cbt_exam_already_submitted"); ?></button>
                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>
                            <section class="lesson_start col-sm-12 hidden">
                                <div class="container">
                                    <div class="">
                                        <div class="col">
                                            <div class="text-center">
                                                <div class="col-sm-12 pt-4 pb-4 mt-4 mb-4">
                                                    <div class="text-center mt-2">
                                                        <div class="row col-sm-12 col-lg-12 col-xl-12 col-xs-12">
                                                          <div class="col-sm-1"></div>
                                                          <div class="col-sm-10 content-card"> </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $('.lesson_starter_screen').hide();
        $('.lesson_select').show();
        $('.lesson_start').hide();
    });
    function getStarted(number) {
        if(number == '0') {
            $('.lesson_starter_screen').hide();
            $('.lesson_select').show();
        } else if(number == '1') {
            $.ajax({
              type: "POST",
              url: '<?php echo site_url("home/cbt_questions/".$cbt['id']); ?>',
              // data: number,
              // dataType  : 'json',
              success: function (val) {
                  // console.log(val);
                  $('.cbt_desc_area').hide();
                  $('.lesson_start .content-card').html(val);
                  $('.lesson_start').show();
              },
              error: function (val) {
                  console.log('error');
                  console.log(val);
              }
            });

        //     // $('.lesson_select').hide();
        //     // $('.lesson_start').show();
        }
    }
</script>