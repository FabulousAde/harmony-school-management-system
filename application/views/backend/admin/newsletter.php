<?php
    // $student_list = $this->crud_model->all_enrolled_student()->result_array();
    $student_list = $this->user_model->get_user()->result_array();
    $allemail = '';
    foreach ($student_list as $key => $student) {
    	$allemail .= $student['email'].',';
    }
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('send_newsletter'); ?>
                    <a href="<?php echo site_url('admin/activities/add_resources'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle" style="margin-right: 10px;"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_newsletter_resourse'); ?></a>
                </h4>
            </div>
        </div> 
    </div>
</div>

<div class="card pt-2">
	<div class="card-body">
		<form method="post" class="mt-2" action="<?php echo site_url('admin/send_newsletter'); ?>" enctype="multipart/form-data">
			<div class="form-group">
				<label for="newsletter_subject"><?php echo get_phrase('newsletter_subject'); ?></label>
				<input type="text" name="subject" id="newsletter_subject" class="form-control" placeholder="eg. <?php echo get_phrase('this_is_our_yearly_newsletter'); ?>" required>
			</div>

			<div class="form-group">
		        <div class="row">
		            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		            	<label for="receiver"><?php echo get_phrase('select_recepient'); ?></label>
		            	<i class="float-right mdi mdi-reply"></i>
                        <select class="form-control select2" data-toggle="select2" name="receiver" id="receiver" required>
							<option value="0"><?php echo get_phrase('all_user');?></option>
                            <optgroup label="<?php echo get_phrase('students'); ?>">
                                <?php foreach($student_list as $student):?>
                                    <option value="<?php echo $student['email']; ?>">
                                        - <?php echo $student['first_name'].' '.$student['last_name']; ?></option>
                                <?php endforeach; ?>
                            </optgroup>
						</select>
		            </div>
		        </div>
		    </div>

		    <div class="form-group">
                <label for="recepients"><?php echo get_phrase('recepients'); ?></label>
                <input type="text" class="form-control bootstrap-tag-input" id = "recepients" name="recepients" data-role="tagsinput" style="width: 100%;" value="<?php echo $allemail; ?>" required/>
            </div>

            <div class="form-group">
                <div class="">
                        <label for="search_resources"><?php echo get_phrase('newsletter_resources'); ?></label>
                          <select class="form-control select2" data-toggle="select2" name="search_resources" id="search_resources">
                              <option value="0"><?php echo get_phrase('none'); ?></option>
                              <?php foreach ($resources as $activityresources): ?>
                                      <option value="<?php echo $activityresources['stored_location']; ?>"><?php echo $activityresources['file_name']; ?></option>
                              <?php endforeach; ?>
                          </select>
                </div>
            </div>

            <div class="form-group">
            	<div class="">
                        <label for="link"><?php echo get_phrase('resorce_link'); ?></label>
                        <input type="text" class="form-control" id="resources_link" name="" value="<?php echo get_phrase('no_resources_found'); ?>" disabled>
                </div>
            </div>

		    <div class="form-group">
		        <div class="row">
		            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		                <textarea class="form-control" rows="5" name="message" id="message" placeholder="<?php echo get_phrase('type_your_message'); ?>" required></textarea>
		            </div>
		        </div>
		    </div>

		    <div class="form-group mt-4">
		        <div class="row">
		            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-13 text-center">
		                <button type="submit" class="btn btn-success float-right"><?php echo get_phrase('send_newsletter'); ?></button>
		            </div>
		        </div>
		    </div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
	    initSummerNote(['#message']);
	});
	$(document).ready(function () {
		const allMail = '<?php echo $allemail; ?>';
		const largeList = $('#recepients').val().split(',').length;
		console.log(largeList);
		console.log('shekpe');
		console.log(allMail);
		$('#receiver').on('change', function () {
			if(this.value == 0){
				$('#recepients').val(allMail);
			}else{
				const listLength = $('input#recepients').attr('value').split(',').length;
				if(listLength == largeList){
					$('.bootstrap-tagsinput').empty();
					$('input#recepients').attr('value', '');
					var initialval = '';
				}else{
					var initialval = $('input#recepients').attr('value');
				}
				const newTag = '<span class="tag label label-info">'+this.value+'<span data-role="remove"></span></span>';
				$('input#recepients').attr('value', ''+initialval+','+this.value);
				$('.bootstrap-tagsinput').append(newTag);
			}
		});
		$('select#search_resources').on('change', function () {
			const tag = (this.value !== '0') ? '<?php echo site_url(''); ?>'+this.value : '<?php echo get_phrase('no_resources_found'); ?>';
			$('input#resources_link').attr('value', tag);
		});
	});

	function check_receiver() {
		var check_receiver = $('#receiver').val();
		if (check_receiver == '' || check_receiver == 0) {
			toastr.error("Please select a receiver", "Error");
            return false;
		}
	}
</script>
