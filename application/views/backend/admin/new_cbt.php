<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                    
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>


<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-7">
                        <form action="<?=site_url('admin/cbt/add');?>" method="post">
                            <div class="form-group">
                                <label for="e_name"><?php echo get_phrase('exam_title'); ?></label>
                                <input type="text" name="e_name" id="e_name" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="sub_category_id"><?php echo get_phrase('categories'); ?></label>
                                <select class="form-control select2" data-toggle="select2" name="category_id" id="sub_category_id">
                                    <?php foreach ($categories->result_array() as $category): ?>
                                        <option value="<?=$category['id'];?>"><?=$category['name'];?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group mb-3">
                                <label for="instruction"><?php echo get_phrase('exam_instruction'); ?></label>
                                <div class="">
                                    <textarea name="instruction" id = "instruction" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="exam_hour"><?php echo get_phrase('exam_hours'); ?></label>
                                <div class="row col-sm-12 col-md-12">
                                    <input type="number" name="exam_hour" id="exam_hour" class="form-control col-md-5 col-sm-12" placeholder="hours">
                                    <div class="col-sm-1"></div>
                                    <input type="number" name="exam_min" id="exam_min" class="form-control col-md-5 col-sm-12" placeholder="minutes">
                                </div>
                            </div>
                            <div class="mb-3 mt-3 text-center">
                                <button type="submit" class="btn btn-primary text-center"><?php echo get_phrase('submit'); ?></button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
  $(document).ready(function () {
    initSummerNote(['#instruction']);
  });
</script>