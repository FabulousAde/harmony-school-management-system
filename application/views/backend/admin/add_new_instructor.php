<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('add_an_instructor'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row justify-content-center">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
              <div class="col-lg-12">
                <h4 class="mb-3 header-title"><?php echo get_phrase('instructor_form'); ?></h4>

                <form class="required-form" action="<?php echo site_url('admin/instructors/enrol'); ?>" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                        <label for="user_id"><?php echo get_phrase('user'); ?><span class="required">*</span> </label>
                        <select class="form-control select2" data-toggle="select2" name="user_id" id="user_id" required>
                            <option value=""><?php echo get_phrase('select_a_user'); ?></option>
                            <?php $user_list = $this->user_model->get_user()->result_array();
                                foreach ($user_list as $user):?>
                                <option value="<?php echo $user['id'] ?>"><?php echo $user['first_name'].' '.$user['last_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="categry_id"><?php echo get_phrase('category_to_enrol to'); ?><span class="required">*</span> </label>
                        <select class="form-control select2" data-toggle="select2" name="categry_id" id="categry_id" required>
                            <option value=""><?php echo get_phrase('select_a_category'); ?></option>
                            <?php $category_list = $this->crud_model->get_categories()->result_array();
                                foreach ($category_list as $category):
                                // if ($category['status'] != 'active')
                                    // continue;
                                    ?>
                                <option value="<?php echo $category['id'] ?>"><?php echo $category['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase('enrol_instructor'); ?></button>
                </form>
              </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
