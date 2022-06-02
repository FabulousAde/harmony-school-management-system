<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('update_exam').': '.$exam['tittle']; ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title mb-3"><?php echo get_phrase('exam_manager'); ?>
                    <!-- <a href="<?php // echo site_url('admin/preview/'.$exam_id); ?>" class="alignToTitle btn btn-outline-secondary btn-rounded btn-sm ml-1" target="_blank"><?php // echo get_phrase('view_on_frontend'); ?> <i class="mdi mdi-arrow-right"></i> </a> -->
                    <a href="<?php echo site_url('admin/cbt'); ?>" class="alignToTitle btn btn-outline-secondary btn-rounded btn-sm"> <i class=" mdi mdi-keyboard-backspace"></i> <?php echo get_phrase('back_to_cbt_exam_list'); ?></a>
                </h4>

                <div class="row">
                    <div class="col-xl-12">
                        <form class="required-form" action="<?php echo site_url('admin/exam_edit/'.$exam_id); ?>" method="post" enctype="multipart/form-data">
                            <div id="basicwizard">
                                <ul class="nav nav-pills nav-justified form-wizard-header mb-3">
                                    <li class="nav-item">
                                       <a href="#exam" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                           <i class="mdi mdi-account-circle mr-1"></i>
                                           <span class="d-none d-sm-inline"><?php echo get_phrase('exam'); ?></span>
                                       </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#basic" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-fountain-pen-tip mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('basic'); ?></span>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a href="#requirements" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-bell-alert mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php // echo get_phrase('requirements'); ?></span>
                                        </a>
                                    </li> -->
                                    <li class="nav-item">
                                        <a href="#finish" data-toggle="tab" class="nav-link rounded-0 pt-2 pb-2">
                                            <i class="mdi mdi-checkbox-marked-circle-outline mr-1"></i>
                                            <span class="d-none d-sm-inline"><?php echo get_phrase('finish'); ?></span>
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content b-0 mb-0">
                                    <div class="tab-pane" id="exam">
                                        <?php include 'cbt_curriculum.php'; ?>
                                    </div>

                                    <div class="tab-pane" id="basic">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="course_title"><?php echo get_phrase('course_title'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <input type="text" class="form-control" id="course_title" name = "title" placeholder="<?php echo get_phrase('enter_course_title'); ?>" value="<?php echo $exam['tittle']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="description"><?php echo get_phrase('description'); ?></label>
                                                    <div class="col-md-10">
                                                        <textarea name="description" id = "description" class="form-control"><?php echo $exam['insructions']; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="sub_category_id"><?php echo get_phrase('category'); ?><span class="required">*</span></label>
                                                    <div class="col-md-10">
                                                        <select class="form-control select2" data-toggle="select2" name="category_id" id="sub_category_id">
                                                            <?php foreach ($categories->result_array() as $category): ?>
                                                                <option value="<?=$category['id'];?>" <?php if($category['id'] == $exam['category_id']) echo 'selected'; ?>><?=$category['name'];?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                </div>
                                            </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div> <!-- end tab pane -->

                                    <!-- <div class="tab-pane" id="requirements">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-8">
                                                <div class="form-group row mb-3">
                                                    <label class="col-md-2 col-form-label" for="requirements"><?php echo get_phrase('requirements'); ?></label>
                                                    <div class="col-md-10">
                                                        <div id = "requirement_area">
                                                            <?php if (count(json_decode($course_details['requirements'])) > 0): ?>
                                                                <?php
                                                                $counter = 0;
                                                                foreach (json_decode($course_details['requirements']) as $requirement):?>
                                                                <?php if ($counter == 0):
                                                                    $counter++; ?>
                                                                    <div class="d-flex mt-2">
                                                                        <div class="flex-grow-1 px-3">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="<?php echo get_phrase('provide_requirements'); ?>" value="<?php echo $requirement; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="">
                                                                            <button type="button" class="btn btn-success btn-sm" style="" name="button" onclick="appendRequirement()"> <i class="fa fa-plus"></i> </button>
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <div class="d-flex mt-2">
                                                                        <div class="flex-grow-1 px-3">
                                                                            <div class="form-group">
                                                                                <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="<?php echo get_phrase('provide_requirements'); ?>" value="<?php echo $requirement; ?>">
                                                                            </div>
                                                                        </div>
                                                                        <div class="">
                                                                            <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeRequirement(this)"> <i class="fa fa-minus"></i> </button>
                                                                        </div>
                                                                    </div>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        <?php else: ?>
                                                            <div class="d-flex mt-2">
                                                                <div class="flex-grow-1 px-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="<?php echo get_phrase('provide_requirements'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="">
                                                                    <button type="button" class="btn btn-success btn-sm" style="" name="button" onclick="appendRequirement()"> <i class="fa fa-plus"></i> </button>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>

                                                        <div id = "blank_requirement_field">
                                                            <div class="d-flex mt-2">
                                                                <div class="flex-grow-1 px-3">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" name="requirements[]" id="requirements" placeholder="<?php echo get_phrase('provide_requirements'); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="">
                                                                    <button type="button" class="btn btn-danger btn-sm" style="margin-top: 0px;" name="button" onclick="removeRequirement(this)"> <i class="fa fa-minus"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                    </div> -->

                                    <div class="tab-pane" id="finish">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h2 class="mt-0"><i class="mdi mdi-check-all"></i></h2>
                                                    <h3 class="mt-0">Thank you !</h3>

                                                    <p class="w-75 mb-2 mx-auto"><?php echo get_phrase('you_are_just_one_click_away'); ?></p>

                                                    <div class="mb-3 mt-3">
                                                        <button type="button" class="btn btn-primary text-center" onclick="checkRequiredFields()"><?php echo get_phrase('submit'); ?></button>
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row -->
                                    </div>

                                    <ul class="list-inline mb-0 wizard text-center">
                                        <li class="previous list-inline-item">
                                            <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-left-bold"></i> </a>
                                        </li>
                                        <li class="next list-inline-item">
                                            <a href="javascript::" class="btn btn-info"> <i class="mdi mdi-arrow-right-bold"></i> </a>
                                        </li>
                                    </ul>

                                </div> <!-- tab-content -->
                            </div> <!-- end #progressbarwizard-->
                        </form>
                    </div>
                </div>


            </div> <!-- end card-body-->
        </div> <!-- end card-->
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    initSummerNote(['#description']);
  });
</script>

<script type="text/javascript">
var blank_outcome = jQuery('#blank_outcome_field').html();
var blank_requirement = jQuery('#blank_requirement_field').html();
jQuery(document).ready(function() {
    jQuery('#blank_outcome_field').hide();
    jQuery('#blank_requirement_field').hide();
    calculateDiscountPercentage($('#discounted_price').val());
});
function appendOutcome() {
    jQuery('#outcomes_area').append(blank_outcome);
}
function removeOutcome(outcomeElem) {
    jQuery(outcomeElem).parent().parent().remove();
}

function appendRequirement() {
    jQuery('#requirement_area').append(blank_requirement);
}
function removeRequirement(requirementElem) {
    jQuery(requirementElem).parent().parent().remove();
}

function ajax_get_sub_category(category_id) {
    console.log(category_id);
    $.ajax({
        url: '<?php echo site_url('admin/ajax_get_sub_category/');?>' + category_id ,
        success: function(response)
        {
            jQuery('#sub_category_id').html(response);
        }
    });
}

function priceChecked(elem){
    if (jQuery('#discountCheckbox').is(':checked')) {

        jQuery('#discountCheckbox').prop( "checked", false );
    }else {

        jQuery('#discountCheckbox').prop( "checked", true );
    }
}

function topCourseChecked(elem){
    if (jQuery('#isTopCourseCheckbox').is(':checked')) {

        jQuery('#isTopCourseCheckbox').prop( "checked", false );
    }else {

        jQuery('#isTopCourseCheckbox').prop( "checked", true );
    }
}

function isFreeCourseChecked(elem) {

    if (jQuery('#'+elem.id).is(':checked')) {
        $('#price').prop('required',false);
    }else {
        $('#price').prop('required',true);
    }
}

function file_change(elem) {
    var url = "<?php echo base_url(); ?>";
    $('#course_overview_url').val(url+""+elem);
}

function calculateDiscountPercentage(discounted_price) {
    if (discounted_price > 0) {
        var actualPrice = jQuery('#price').val();
        if ( actualPrice > 0) {
            var reducedPrice = actualPrice - discounted_price;
            var discountedPercentage = (reducedPrice / actualPrice) * 100;
            if (discountedPercentage > 0) {
                jQuery('#discounted_percentage').text(discountedPercentage.toFixed(2) + "%");

            }else {
                jQuery('#discounted_percentage').text('<?php echo '0%'; ?>');
            }
        }
    }
}

$('.on-hover-action').mouseenter(function() {
    var id = this.id;
    $('#widgets-of-'+id).show();
});
$('.on-hover-action').mouseleave(function() {
    var id = this.id;
    $('#widgets-of-'+id).hide();
});
</script>
