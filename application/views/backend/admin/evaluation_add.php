<?php
$categories = $this->crud_model->get_categories();
$sections = $this->crud_model->get_section('course', $param2)->result_array();
?>
<form action="<?php echo site_url('admin/evaluation/'.$param2.'/add'); ?>" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label><?php echo get_phrase('evaluation_tittle'); ?><span class="required">*</span></label>
		<input type="text" name="evaluation_tittle" class="form-control" required>
	</div>
	
	<div class="form-group">
        <label for="section_id"><?php echo get_phrase('section'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="section_id" id="section_id" required>
            <?php foreach ($sections as $section): ?>
                <option value="<?php echo $section['id']; ?>"><?php echo $section['title']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="section_id"><?php echo get_phrase('evaluation_type'); ?><span class="required">*</span></label>
        <select class="form-control select2" data-toggle="select2" name="evaluation_type" id="evaluation_type" required onchange="show_lesson_type_form(this.value)">
            <option value=""><?php echo get_phrase('select_type_of_evaluation'); ?></option>
            <option value="video-file"><?php echo get_phrase('video_file'); ?></option>
            <option value="other-txt"><?php echo get_phrase('text_file'); ?></option>
            <option value="other-pdf"><?php echo get_phrase('pdf_file'); ?></option>
            <option value="other-doc"><?php echo get_phrase('document_file'); ?></option>
            <option value="other-img"><?php echo get_phrase('image_file'); ?></option>
        </select>
    </div>
    <div class="" id = "other" style="display: none;">
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
    	<textarea class="form-control" placeholder="E.g attach a word document and submit" name="evaluation_description"></textarea>
    </div>

    <div class="mb-3">
    	<div class="text-center">
    		<button type="submit" class="btn btn-success" name="button"><?php echo get_phrase("add_evaluation"); ?></button>
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
