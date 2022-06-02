<?php

// echo $all_result_log->num_rows();
$all_results = $this->crud_model->get_results($all_result_log['id'], $all_result_log['class_category']);
?>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css"> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>

<style>
    input.form-control {
        padding: 0 5px;
        text-align: center;
    }
</style>
<div class="row">
    <div class="col-xl-12">
        <div class="row card">
             <div class="card-body">
                    <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4>
            </div>
        </div>
    </div>
</div>

<form action="<?php echo site_url('/user/result/update/'.$all_result_log['id'].'/'.$all_result_log['sid']); ?>" method="POST">
<?php if($user['category'] != 'preschool'): ?><div class="row">
    <div class="col-xl-8">
        <div class="row card">
             <div class="row card-body">
                 <div class="table-responsive-sm mt-4">
                     <div class="col-lg-12 col-md-12">
                         <div class="row col-lg-11">
                             <h2>
                                 <?php echo $user['first_name']." ".$user['last_name']; ?>
                             </h2>
                         </div>
                     </div>
                    <table class="table table-striped table-centered mb-0">
                     <thead>
                         <tr>
                             <td>Course</td>
                             <td>CAT1</td>
                             <td>CAT2</td>
                             <td>CAT3</td>
                             <td>CAT4</td>
                             <td>EXAM</td>
                             <td>TOTAL</td>
                             <td>GRADE</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach($all_results->result_array() as $key => $cat): ?>
                            <tr>
                                <td>
                                    <?php echo $cat['course_name']; ?>
                                    <input type="hidden" name="course_name_<?php echo $key; ?>" value="<?php echo strtolower($cat['course_name']); ?>">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo ($cat['cat1'] != null) ? $cat['cat1'] : 0; ?>' required class="form-control" id='<?php echo $cat['id']; ?>' name="<?php echo $cat['id']; ?>_cat1">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo ($cat['cat2'] != null) ? $cat['cat2'] : 0; ?>' required class="form-control" id='<?php echo $cat['id']; ?>' name="<?php echo $cat['id']; ?>_cat2">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo ($cat['cat3'] != null) ? $cat['cat3'] : 0; ?>' required class="form-control" id='<?php echo $cat['id']; ?>' name="<?php echo $cat['id']; ?>_cat3">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo ($cat['cat4'] != null) ? $cat['cat4'] : 0; ?>' required class="form-control" id='<?php echo $cat['id']; ?>' name="<?php echo $cat['id']; ?>_cat4">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo ($cat['exam_score'] != null) ? $cat['exam_score'] : 0; ?>' required class="form-control" id='<?php echo $cat['id']; ?>' name="<?php echo $cat['id']; ?>_exam_score">
                                </td>
                                <td>
                                    <input type="text" onkeypress="return keyFunc()" value='<?php echo $cat['total_scores']; ?>' required class="form-control" id='<?php echo $cat['id']; ?>_total' name="<?php echo $cat['id']; ?>_total">
                                </td>
                                <td>
                                    <input type="text" required value='<?php echo $cat['grade']; ?>' required style="-webkit-text-stroke: thick; text-transform: uppercase;" id="<?php echo $cat['id']; ?>_grade" class="form-control disabled" name="<?php echo $cat['id']; ?>_grade" readonly>
                                </td>
                            </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
             </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="alert alert-warning" role="alert">
            <h4>
                <?php echo $user['first_name']." ".$user['last_name']; ?>
            </h4>
            <div>
                <div style="font-size: 0.8em;"><?php echo get_phrase($all_result_log['class']); ?></div>
            </div>
            <div class="form-group">
                <div class="session mt-2">
                    <label for="session"><?php echo get_phrase('session'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "session" name="session">
                        <option value="first" <?php if($all_result_log['session'] == 'first') echo 'selected'; ?>> <?php echo get_phrase('first_term');?></option>
                        <option value="second" <?php if($all_result_log['session'] == 'second') echo 'selected'; ?>> <?php echo get_phrase('second_term');?></option>
                        <option value="third" <?php if($all_result_log['session'] == 'third') echo 'selected'; ?>> <?php echo get_phrase('third_term');?></option>
                    </select>
                </div>
                <div class="year mt-2">
                    <label for="year"><?php echo get_phrase('year'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "year" name="year">
                        <?php 
                            $year = date('Y') + 1;
                            for($i = date('Y') + 1; $i > ($year - 5); $i--):
                        ?>
                            <option <?php if($all_result_log['year_session'] == ($i-1)."/".$i) echo 'selected'; ?> value="<?php echo ($i-1)."/".$i; ?>"> <?php echo ($i-1)."/".$i; ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="review"><?php echo get_phrase('teacher_review'); ?></label>
                    <textarea name="review" id="review" class="form-control" required><?php echo $all_result_log['review']; ?></textarea>
                </div>
                <?php if($this->session->userdata('admin_login') == true) : ?>
                    <div class="mt-2">
                        <label for="admin0_review"><?php echo get_phrase('admin_review'); ?></label>
                        <textarea name="admin0_review" id="review" class="form-control" required><?php echo $all_result_log['admin_review']; ?></textarea>
                    </div>
                <?php endif; ?>
                <!-- from here -->
                <div class="mt-2">
                    <label for="time_school_opened"><?php echo get_phrase('time_school_opened'); ?></label>
                    <input type="number" name="time_school_opened" value="<?php echo $all_result_log['total_sopen']; ?>" class="form-control">
                </div>
                <div class="mt-2">
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                           <label for="time_present"><?php echo get_phrase('time_present'); ?></label>
                            <input type="number" name="time_present" value="<?php echo $all_result_log['time_present']; ?>" class="form-control col-sm-12"> 
                        </div>
                        <div class="col-sm-6">
                           <label for="time_absent"><?php echo get_phrase('time_absent'); ?></label>
                            <input type="number" name="time_absent" value="<?php echo $all_result_log['time_absent']; ?>" class="form-control col-sm-12"> 
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="date"><?php echo get_phrase('resumption_date'); ?></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="dpd1" name="dpd1" class="form-control date-selector" value="<?php echo $all_result_log['date_resume']; ?>" placeholder="&#xf073;" required />
                    </div>
                </div>
                <div class="mt-2">
                    <label for="grand_total"><?php echo get_phrase('grand_total'); ?></label>
                    <input type="text" name="grand_total" value="<?php echo $all_result_log['grand_total']; ?>" class="form-control" placeholder="Ground Total">
                </div>
                <div class="mt-2">
                    <label for="average"><?php echo get_phrase('average %'); ?></label>
                    <input type="text" name="average" class="form-control" placeholder="%" value="<?php echo $all_result_log['average']; ?>">
                </div>
                <div class="session mt-2">
                    <label for="session"><?php echo get_phrase('promoted'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "promoted" name="promoted">
                        <option>--- Is the student Promoted --- </option>
                        <option value="yes" <?php if($all_result_log['is_promoted'] == 'yes') echo 'selected'; ?>> <?php echo get_phrase('yes');?></option>
                        <option value="no" <?php if($all_result_log['is_promoted'] == 'no') echo 'selected'; ?>> <?php echo get_phrase('no');?></option>
                    </select>
                </div>

                <!-- to here -->
                <div>
                    <input type="hidden" name="student_id" value="<?php echo $user['id']; ?>">
                </div>
                <div class="row justify-content-md-center">
                     <div class="form-group col-md-10 mt-4">
                         <button type="submit" class="btn btn-block btn-primary"><?php echo get_phrase('save'); ?></button>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
<div class="row">
    <div class="col-xl-8">
        <div class="card">
             <div class="card-body">
                 <div class="table-responsive-sm mt-4">
                     <div class="col-lg-12 col-md-12">
                         <div class="row col-lg-11">
                             <h2>
                                 <?php echo $user['first_name']." ".$user['last_name']; ?>
                             </h2>
                         </div>
                     </div>
                    <table class="table table-striped table-centered mb-0">
                     <thead>
                         <tr>
                             <td>Course</td>
                             <td>REVIEW</td>
                             <td>GRADE</td>
                         </tr>
                     </thead>
                     <tbody>
                         <?php foreach($all_results->result_array() as $key => $cat): ?>
                            <tr>
                                <td>
                                    <?php echo $cat['course_name']; ?>
                                    <input type="hidden" name="course_name_<?php echo $key; ?>" value="<?php echo strtolower($cat['course_name']); ?>">
                                </td>
                                <td>
                                    <textarea type="text" required class="form-control" name="<?php echo $cat['id']; ?>_review"><?php echo $cat['review']; ?></textarea>
                                </td>
                                <td>
                                    <input type="text" required value="<?php echo $cat['grade']; ?>" style="-webkit-text-stroke: thick; text-transform: uppercase;" class="form-control" name="<?php echo $cat['id']; ?>_grade">
                                </td>
                            </tr>
                         <?php endforeach; ?>
                     </tbody>
                 </table>
             </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="alert alert-warning" role="alert">
            <h4>
                <?php echo $user['first_name']." ".$user['last_name']; ?>
            </h4>
            <div>
                <div style="font-size: 0.8em;"><?php echo get_phrase($all_result_log['class']); ?></div>
            </div>
            <div class="form-group">
                <div class="session mt-2">
                    <label for="session"><?php echo get_phrase('session'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "session" name="session">
                        <option value="first"> <?php echo get_phrase('first_term');?></option>
                        <option value="second"> <?php echo get_phrase('second_term');?></option>
                        <option value="third"> <?php echo get_phrase('third_term');?></option>
                    </select>
                </div>
                <div class="year mt-2">
                    <label for="year"><?php echo get_phrase('year'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "year" name="year">
                        <?php 
                            $year = date('Y') + 1;
                            for($i = date('Y') + 1; $i > ($year- 5); $i--):
                        ?>
                            <option value="<?php echo ($i-1)."/".$i; ?>"> <?php echo ($i-1)."/".$i; ?> </option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="mt-2">
                    <label for="review"><?php echo get_phrase('teacher_review'); ?></label>
                    <textarea name="review" id="review" class="form-control" required><?php echo $all_result_log['review']; ?></textarea>
                </div>
                <?php if($this->session->userdata('admin_login') == true) : ?>y
                    <div class="mt-2">
                        <label for="admin0_review"><?php echo get_phrase('admin_review'); ?></label>
                        <textarea name="admin0_review" id="review" class="form-control" required><?php echo $all_result_log['admin_review']; ?>
                        </textarea>
                    </div>
                <?php endif; ?>
                <div class="mt-2">
                    <label for="time_school_opened"><?php echo get_phrase('time_school_opened'); ?></label>
                    <input type="number" name="time_school_opened" value="<?php echo $all_result_log['total_sopen']; ?>" class="form-control">
                </div>
                <div class="mt-2">
                    <div class="row col-sm-12">
                        <div class="row col-sm-6">
                           <label for="time_present"><?php echo get_phrase('time_present'); ?></label>
                            <input type="number" name="time_present" value="<?php echo $all_result_log['time_present']; ?>" class="form-control col-sm-12"> 
                        </div>
                        <div class="col-sm-6">
                           <label for="time_absent"><?php echo get_phrase('time_absent'); ?></label>
                            <input type="number" name="time_absent" value="<?php echo $all_result_log['time_absent']; ?>" class="form-control col-sm-12"> 
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <label for="date"><?php echo get_phrase('resumption_date'); ?></label>
                    <div class='input-group date' id='datetimepicker1'>
                        <input type="text" id="dpd1" name="dpd1" class="form-control date-selector" value="<?php echo $all_result_log['date_resume']; ?>" placeholder="&#xf073;" required />
                    </div>
                </div>
                <div class="mt-2">
                    <label for="grand_total"><?php echo get_phrase('grand_total'); ?></label>
                    <input type="text" name="grand_total" value="<?php echo $all_result_log['grand_total']; ?>" class="form-control" placeholder="Ground Total">
                </div>
                <div class="mt-2">
                    <label for="average"><?php echo get_phrase('average %'); ?></label>
                    <input type="text" name="average" class="form-control" placeholder="%" value="<?php echo $all_result_log['average']; ?>">
                </div>
                <div class="session mt-2">
                    <label for="session"><?php echo get_phrase('promoted'); ?></label>
                    <select class="form-control select2" data-toggle="select2" id = "promoted" name="promoted">
                        <option>--- Is the student Promoted --- </option>
                        <option value="yes" <?php if($all_result_log['is_promoted'] == 'yes') echo 'selected'; ?>> <?php echo get_phrase('yes');?></option>
                        <option value="no" <?php if($all_result_log['is_promoted'] == 'no') echo 'selected'; ?>> <?php echo get_phrase('no');?></option>
                    </select>
                </div>
                <div>
                    <input type="hidden" name="student_id" value="<?php echo $user['id']; ?>">
                </div>
                <div class="row justify-content-md-center">
                     <div class="form-group col-md-10 mt-4">
                         <button type="submit" class="btn btn-block btn-primary"><?php echo get_phrase('update'); ?></button>
                     </div>
                 </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
</form>

<script>
    $('tr td input').on('keyup', function (){
        var id = this.id;
        if(this.value == '')
            this.value = 0;
        else 
            this.value = parseInt(this.value);
        var sum = 0;
        var grade;
        var all = document.querySelectorAll("input[id='"+id+"']");
        console.log(all);
        for (var i = 0; i < all.length; ++i) {
            sum = eval(parseInt(sum) + parseInt(all[i].value));
        }
        console.log(sum);
        $('input#'+id+'_total').val(sum);
        if(sum < 45) grade = 'F';
        else if(sum > 44 && sum < 50) grade = 'P';
        else if(sum > 49 && sum < 60) grade = 'C';
        else if(sum > 59 && sum < 80) grade = 'B';
        else if(sum > 79 && sum < 101) grade = 'A';
        else grade = '0';

        $('input#'+id+'_grade').val(grade);
    });
    function keyFunc() {
        return event.charCode >= 48 && event.charCode <= 57;
    }
    if(jQuery('#dpd1').length){
        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
         
        var checkin = $('#dpd1').datepicker({
          onRender: function(date) {
            return date.valueOf() < now.valueOf() ? '' : '';
          }
        }).on('changeDate', function(ev) {
          if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
            newDate.setDate(newDate.getDate() + 1);
            checkout.setValue(newDate);
          }
          checkin.hide();
          $('#dpd2')[0].focus();
        }).data('datepicker');
        var checkout = $('#dpd2').datepicker({
          onRender: function(date) {
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
          }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');
    }
</script>