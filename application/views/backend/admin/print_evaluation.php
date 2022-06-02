<?php
$direct_evaluation = $evaluation->row_array();
$get_allsubmited_eval = $this->crud_model->get_all_markedevaluation($direct_evaluation['id'])->result_array();
$system_name = $this->db->get_where('settings' , array('key'=>'system_name'))->row()->value;
$course = $this->crud_model->get_course_by_id($direct_evaluation['course_id'])->row_array();
// echo $direct_evaluation['course_id'];
// sub_category_id
$get_subcat = $this->crud_model->get_category_details_by_id($course['sub_category_id'])->row_array();
$course_t = $get_subcat['parent'];
$main_course = $this->crud_model->get_category_details_by_id($course_t)->row_array();
?>
<div class="col-xl-12">
    <div class="text-center">
        <img src="<?php echo site_url('uploads/system/logo-dark.png'); ?>" alt="school logo" title="school logo" class="img_class">
        <div>
            <div class="h3" style="margin-top: 17px;"><?php echo $system_name; ?></div>
            <div class="course_title">
                <span class="h4"><?php echo $main_course['name']." - ".$course['title']; ?></span>
            </div>
            <div class="evaluation_title"><?php echo $direct_evaluation['evaluation_tittle']; ?></div>
        </div>
    </div>
</div>
<br><br>
<div class="col-sm-12 col-xl-12">
    <?php 
    $count = 0;
    echo "<div style='margin-bottom: 8px;'><strong>".count($get_allsubmited_eval)." marked evaluation</strong></div>";
    ?>
    <table class="table table-stripped">
        <thead>
            <th><?php echo get_phrase('picture');  ?></th>
            <th><?php echo get_phrase('fullname'); ?></th>
            <th><?php echo get_phrase('email'); ?></th>
            <th><?php echo get_phrase('time_submitted'); ?></th>
            <th><?php echo get_phrase('score_obtained'); ?></th>
        </thead>
        <tbody>
            <?php
            foreach($get_allsubmited_eval as $submitted_eval): ?>
                <tr>
                    <td>
                        <span>
                                <img src="<?php echo $this->user_model->get_user_image_url($submitted_eval['user_id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                        </span>
                    </td>
                    <td>
                        <span>
                                <?php
                                $user = $this->user_model->get_user($submitted_eval['user_id'])->row_array();
                                echo "<span>".$user['first_name']." ".$user['last_name']."</span>"; ?>
                        </span>
                    </td>
                    <td>
                        <span class="margin_seperator">
                                <?php echo "<b>".$user['email']."</b>"; ?>
                        </span>
                    </td>
                    <td>
                        <span class="margin_seperator">
                                <?php echo "<b>".date('h:i:sa, D d-M-y', $submitted_eval['date_added'])."</b>"; ?>
                        </span>
                    </td>
                    <td>
                        <span class="margin_seperator">
                                <b><?php echo $submitted_eval['mark_obtain']; ?></b>
                        </span>
                    </td>

                </tr>
            <?php
            $count++;
            endforeach; ?>
        </tbody>
    </table>
    
    <?php if (count($get_allsubmited_eval) == 0): ?>
        <div class="img-fluid w-100 text-center">
          <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
          <?php echo get_phrase('no_evaluation_data_found'); ?>
        </div>
    <?php endif; ?>
</div>
<div class="col-xl-12 mg-10">
    <div class="text-center print-area">
        <a href="<?php echo site_url('/admin/course_form/course_evaluations/'.$para2); ?>"><i class="fas fa-arrow-left"></i> <?php echo get_phrase(' go_back'); ?></a>
        <button onclick="javascript:window.print();"><i class="fas fa-print"></i> <?php echo get_phrase(' print_page'); ?></button>
    </div>
</div>
<style>
        .margin_seperator {
            /*margin-left: 64px;  */
        }
        .evaluation_title {
            margin-top: 10px;
            font-size: 1.18em;
            font-weight: 600;
        }
        .mg-10 {
            margin-top: 35px;
        }
        .course_title {
            font-size: 1.04em;
            font-weight: bold;
        }
        td img {
            margin-top: -10px;
        }
        img.img_class {
           max-width: 370px;
           max-height: 68px;
        }
        .print-area button {
            height: 36px;
            width: 132px;
            border-radius: 2px;
            border: 1px solid #cdcdcd;
            background-color: #fff;
        }
        .print-area a {
            border-radius: 2px;
            border: 1px solid #cdcdcd;
            padding: 7.7px 17px;
            color: #000000;
        }
</style>