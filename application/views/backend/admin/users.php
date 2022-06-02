<style>
    .user_status{
        position: absolute;
        height: 6px;
        display: inline-flex;
        width: 6px;
        border-radius: 50%;
    }
    .u__enabled{
        background-color: green;
    }
    .u__disabled{
        background-color: red;
    }
</style>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                <a href = "<?php echo site_url('admin/user_form/add_user_form'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_student'); ?></a>
                <a href = "<?php echo site_url('admin/user_form/promote'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><?php echo get_phrase('promote_student'); ?></a>
            </div> <!-- end card body-->
            </h4>
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
              <h4 class="mb-3 header-title"><?php echo get_phrase('students'); ?></h4>
              
              <form class="row" action="<?php echo site_url('admin/users'); ?>" method="get">
                    <div class="col-xl-3">
                        <div class="form-group">
                            <label for="main_category"><?php echo get_phrase('categories'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="main_category" id="main_category">
                                    <option value="<?php echo 'all'; ?>" <?php if($main_category == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                    <?php
                                    foreach($all_categories as $key => $categories):
                                        $current_phrase = $categories['name'];
                                    ?>
                                    <option value="<?php echo underscore($categories['name']); ?>" <?php if($main_category == underscore($categories['name'])) echo 'selected'; ?>><?php echo $categories['name']; ?></option>
                                    <?php endforeach; ?>
                            </select>
                    </div>
                </div>

                <!-- Course Status -->
                <div class="col-xl-2">
                    <div class="form-group">
                        <label for="status"><?php echo get_phrase('status'); ?></label>
                        <select class="form-control select2" data-toggle="select2" name="status" id = 'status'>
                            <option value="all" <?php if($selected_status == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                            <option value="activated" <?php if($selected_status == 'activated') echo 'selected'; ?>><?php echo get_phrase('activated'); ?></option>
                            <option value="deactivated" <?php if($selected_status == 'deactivated') echo 'selected'; ?>><?php echo get_phrase('deactivated'); ?></option>
                        </select>
                    </div>
                </div>

                <div class="col-xl-2">
                    <label for=".." class="text-white"><?php echo get_phrase('..'); ?></label>
                    <button type="submit" class="btn btn-primary btn-block" name="button"><?php echo get_phrase('filter'); ?></button>
                </div>
            </form>
              
              
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('name'); ?></th>
                      <th><?php echo get_phrase('email'); ?></th>
                      <th><?php echo get_phrase('enrolled_courses'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                       foreach ($users->result_array() as $key => $user): ?>
                          <tr>
                              <td><?php echo $key+1; ?></td>
                              <td>
                                  <div>
                                      <img src="<?php echo $this->user_model->get_user_image_url($user['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail"> <div class="user_status <?php if($user['status'] == '0'): echo 'u__disabled'; else: echo 'u__enabled'; endif; ?>"></div></div>
                              </td>
                              <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                              <td><?php echo $user['email']; ?></td>
                              <td>
                                 <?php
                                    $enrolled_courses = $this->crud_model->enrol_history_by_user_id($user['id']);?>
                                    <ul>
                                        <?php foreach ($enrolled_courses->result_array() as $enrolled_course):
                                            $course_details = $this->crud_model->get_course_by_id($enrolled_course['course_id'])->row_array();?>
                                            <li><?php echo $course_details['title']; ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                              </td>
                              <td>
                                  <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/user_form/edit_user_form/'.$user['id']) ?>"><?php echo get_phrase('edit'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/users/delete/'.$user['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                        <?php if($user['status'] == '0'): ?>
                                            <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/users/activate/'.$user['id']); ?>');"><?php echo get_phrase('activate_user'); ?></a></li>
                                        <?php elseif($user['status'] == '1'): ?>
                                            <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/users/deactivate/'.$user['id']); ?>');"><?php echo get_phrase('deactivate_user'); ?></a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                              </td>
                          </tr>
                      <?php endforeach; ?>
                  </tbody>
              </table>
              </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>
