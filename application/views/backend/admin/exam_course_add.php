<?php
$exam = $this->crud_model->get_cbtexams($param2)->row_array();
$courses = $this->crud_model->get_sub_category($exam['category_id'])->result_array();
// $sections = $this->crud_model->get_section('course', $param2)->result_array();
?>
<form action="<?php echo site_url('admin/cbt_exams/'.$param2.'/add'); ?>" method="post">
    <div class="form-group">
        <label for="title"><?php echo get_phrase('course_exam_title'); ?></label>
        <input class="form-control" type="text" name="title" id="title" required>
    </div>
    <div class="form-group">
        <label for="course_id"><?php echo get_phrase('course'); ?></label>
        <select class="form-control select2" data-toggle="select2" name="course_id" id="course_id" required>
            <?php foreach ($courses as $course): ?>
                <option value="<?php echo $course['id']; ?>"><?php echo $course['name']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label><?php echo get_phrase('instruction'); ?></label>
        <textarea name="summary" class="form-control"></textarea>
    </div>
    <div class="text-center">
        <button class = "btn btn-success" type="submit" name="button"><?php echo get_phrase('submit'); ?></button>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function() {
    initSelect2(['#course_id']);
});
</script>
