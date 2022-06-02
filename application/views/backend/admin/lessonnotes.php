<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                <a href = "<?php echo site_url('admin/lesson_note/new'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_note'); ?></a>
            </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('notes'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('name'); ?></th>
                      <th><?php echo get_phrase('category'); ?></th>
                      <th><?php echo get_phrase('instructor'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($all_notes as $key => $notes): ?>
                        <?php
                          $instructor = $this->user_model->get_user($notes['instructors_id'])->row_array();
                        ?>
                        <tr>
                              <td><?php echo $key+1; ?></td>
                              <td><?php echo $notes['tittle']; ?></td>
                              <td><?php echo get_phrase($notes['category_added']); ?></td>
                              <td>
                                 <?php echo $instructor['first_name'].' '.$instructor['last_name']; ?>
                              </td>
                              <td>
                                <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/lesson_note/view/'.$notes['id']); ?>"><?php echo get_phrase('open_note'); ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo site_url($notes['stored_location']); ?>" download target="_blank"><?php echo get_phrase('download_note'); ?></a></li>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/lesson_note/delete/'.$notes['id']); ?>');"><?php echo get_phrase('delete_note'); ?></a></li>
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

