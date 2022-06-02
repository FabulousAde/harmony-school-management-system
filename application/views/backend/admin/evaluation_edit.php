<?php
$get_evaluation = $this->crud_model->get_evaluation_by_id($param2)->row_array();
$sections = $this->crud_model->get_section('course', $get_evaluation['course_id'])->result_array();
?>
<form action="<?php echo site_url('admin/evaluation/'.$param2.'/edit'); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label><?php echo get_phrase('evaluation_tittle'); ?><span class="required">*</span></label>
		<input type="text" name="evaluation_tittle" class="form-control" value="<?php echo $get_evaluation['evaluation_tittle']; ?>" required>
	</div>
	
	<div class="form-group">
        <label for="section_id"><?php echo get_phrase('section'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="" id = "other">
        <div class="form-group">
            <label> <?php echo get_phrase('attachment'); ?></label>
            <div class="input-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="attachment" name="attachment" onchange="changeTitleOfImageUploader(this)">
                    <label class="custom-file-label" for="attachment"><?php echo get_phrase('attachment'); ?></label>
                </div>
            </div>
        </div>
    </div>
    
    <div class="form-group mb-3">
    	<label><?php echo get_phrase('evaluation_description'); ?></label>
    	<textarea class="form-control" placeholder="E.g attach a word document and submit" name="evaluation_description"><?php echo $get_evaluation['description']; ?></textarea>
    </div>
    
    <div class="form-group">
        <label for="status"><?php echo get_phrase('status'); ?><span class="required">*</span></label>
        <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
        <option value="1" <?php if($get_evaluation['status'] == 1) echo 'selected'; ?>><?php echo get_phrase('activate'); ?></option>
        <option value="0" <?php if($get_evaluation['status'] == 0) echo 'selected'; ?>><?php echo get_phrase('deactivate'); ?></option>
    </select>
    </div>

    <div class="mb-3">
    	<div class="text-center">
    		<button type="submit" class="btn btn-success" name="button"><?php echo get_phrase("edit_evaluation"); ?></button>
    	</div>
    </div>

</form>

<script>
    function show_lesson_type_form(param) {
        var checker = param.split('-');
        var lesson_type = checker[0];
        if (lesson_type === "video") {
            $('#other').show();
            $('#video').hide();
        }else if (lesson_type === "other") {
            $('#video').hide();
            $('#other').show();
        }else {
            $('#video').hide();
            $('#other').hide();
        }
    }
</script>
