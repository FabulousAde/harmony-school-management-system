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
                <a href = "<?php echo site_url('admin/instructors/add_instructor'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_instructor'); ?></a>
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('instructors'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('name'); ?></th>
                      <th><?php echo get_phrase('email'); ?></th>
                      <th><?php echo get_phrase('category_taking'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($instructors->result_array() as $key => $instructor): ?>
                        <tr>
                              <td><?php echo $key+1; ?></td>
                              <td>
                                  <div>
                                      <img src="<?php echo $this->user_model->get_user_image_url($instructor['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail"> <div class="user_status <?php if($instructor['status'] == '0'): echo 'u__disabled'; else: echo 'u__enabled'; endif; ?>"></div></div>
                              </td>
                              <td><?php echo $instructor['first_name'].' '.$instructor['last_name']; ?></td>
                              <td><?php echo $instructor['email']; ?></td>
                              <td>
                                 <?php echo get_phrase($instructor['class_options']); ?>
                              </td>
                              <td>
                                  <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/user_form/edit_user_form/'.$instructor['id']) ?>"><?php echo get_phrase('edit'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/users/delete/'.$instructor['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/instructors/deactivate/'.$instructor['id']); ?>');"><?php echo get_phrase('deactivate_as_instructor'); ?></a></li>
                                    </ul>
                                </div>
                              </td>
                          </tr>
                        
                      <?php endforeach; ?>
                  </tbody>
              </table>
             </div>
            </div>
        </div>
    </div>
</div>

