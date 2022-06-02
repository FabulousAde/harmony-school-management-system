<?php
$direct_evaluation = $evaluation->row_array();
$get_allsubmited_eval = $this->crud_model->get_all_submitedevaluation($direct_evaluation['id'])->result_array();
// echo count($evaluation);
?>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                <!--<a href = "<?php // echo site_url('admin/all_evaluation/print/'.$param2); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="fas fa-print"></i> <?php // echo get_phrase(' print_answers'); ?></a>-->
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="col-sm-12 col-xl-12">
    <?php 
    $count = 0;
    foreach($get_allsubmited_eval as $submitted_eval): ?>
        <div class="card">
            <div class="card-body">
                <div>
                    <span>
                        <img src="<?php echo $this->user_model->get_user_image_url($submitted_eval['user_id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                    </span>
                    <span>
                        <?php
                        $user = $this->user_model->get_user($submitted_eval['user_id'])->row_array();
                        echo "<span class='h4' style='margin-left: 10px;'>".$user['first_name']." ".$user['last_name']."</span>"; ?>
                    </span>
                    <span>
                        <?php
                        echo "<span class='h5'> - ".$direct_evaluation['evaluation_tittle']."</span>";
                        ?>
                    </span>
                </div>
                <div>
                    <span class="margin_seperator">
                        Time Submitted: <?php echo date('h:i:sa, D d-M-y', $submitted_eval['date_added']); ?>
                    </span>
                </div>
                <div id="<?php echo $count; ?>">
                    <span class="margin_seperator">
                        <a href="<?php echo site_url('uploads/evaluation_files/users_e/').$submitted_eval['attachment']; ?>" target="_blank" class="answer_button"><?php echo get_phrase('check_answer'); ?></a>
                        <span id="mark_area">
                            <a href="javascript:0" onclick="show_markbox('<?php echo $count; ?>')" class="answer_button mark_button"><?php echo get_phrase('award_mark'); ?></a>
                            <input type="text" class="hidden" id="mark_input" onkeyup="save_mark('<?php echo $count; ?>', this)" value = "<?php echo $submitted_eval['mark_obtain']; ?>" />
                            <button id="save_button" onclick="record_mark('<?php echo $submitted_eval['id']; ?>', '<?php echo $count; ?>')" class="save hidden"><?php echo get_phrase('save_mark'); ?></button>
                            <button id="saved_button" onclick="record_mark('<?php echo $submitted_eval['id']; ?>', '<?php echo $count; ?>')" class="saved hidden"><i class="fas fa-check"></i></button>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    <?php
    $count++;
    endforeach; ?>
    <?php if (count($get_allsubmited_eval) == 0): ?>
        <div class="img-fluid w-100 text-center">
          <img style="opacity: 1; width: 100px;" src="<?php echo base_url('assets/backend/images/file-search.svg'); ?>"><br>
          <?php echo get_phrase('no_evaluation_data_found'); ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .margin_seperator {
        margin-left: 64px;  
    }
    .answer_button {
        color: #727cf5;
        border: 1.3px solid #727cf5;
        padding: 10px 14px;
        line-height: 47px;
        border-radius: 60px;
    }
    #mark_input {
        color: #727cf5;
        border: 1.3px solid #727cf5;
        border-radius: 60px;
        height: 40px;
        width: 100.5px;
        outline: none;
        text-align: center;
        font-weight: bold;
        font-size: 1.09em;
        transition: .4s ease-in-out;
    }
    #save_button, #saved_button {
        background-color: #727cf5;
        color: #fff;
        border: 1.3px solid #727cf5;
        border-radius: 60px;
        height: 40px;
        width: 100.5px;
        font-weight: bold;
        font-size: 0.82em;
        transition: .4s ease-in-out;
    }
</style>
<script>
    function record_mark(ol, divnumber) {
        var divinput = $('#'+divnumber+' input').val();
        $.ajax({
            url: '<?php echo site_url('user/mark_evaluation_ajax'); ?>',
            method: 'post',
            data: {ol, divinput},
            dataType: 'json',
            success: function(response) {
                $('#'+divnumber+' button#save_button').attr('class', 'hidden');
                $('#'+divnumber+' button#saved_button').removeAttr('class');
                // var len = response.length;
                // if(len > 0){
                //     console.log(response);
                // }
            }
        });
    }
    function show_markbox(divnumber) {
        $('#'+divnumber+' .mark_button').attr('class', 'hidden');
        $('#'+divnumber+' input').removeAttr('class');
    }
    function save_mark(divnumber, el) {
       if(el.value.trim() !== ""){
           $('#'+divnumber+' button#save_button').removeAttr('class');
       }else{
           $('#'+divnumber+' button#save_button').attr('class', 'hidden');
       }
    }
</script>