<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                    <a href="<?php echo site_url('user/cbt/new'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"  style="margin-right: 10px;"><i class="mdi mdi-plus"></i><?php echo get_phrase('set_new_cbt_exam'); ?></a> 
                </h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3 header-title"><?php echo get_phrase('exams'); ?></h4>
              <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('title'); ?></th>
                      <th><?php echo get_phrase('category'); ?></th>
                      <!-- <th><?php // echo get_phrase('course'); ?></th> -->
                      <th><?php echo get_phrase('exam_time'); ?></th>
                      <th><?php echo get_phrase('actions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        foreach($exams as $key => $exam): ?>
                        <?php
                          $course = $this->crud_model->get_category_details_by_id($exam['sub_category_id'])->row_array();
                          $course_child = $this->crud_model->get_category_details_by_id($exam['category_id'])->row_array();
                        ?>
                        <tr>
                              <td><?php echo $key+1; ?></td>
                              <td><?php echo $exam['tittle']; ?></td>
                              <td><?php echo get_phrase($course_child['name']); ?></td>
                              <!-- <td><?php // echo get_phrase($course_child['name']); ?></td> -->
                              <td><?=$exam['exam_time'];?></td>
                              <td>
                                <div class="dropright dropright">
                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="<?php echo site_url('user/cbt/edit/'.$exam['id']); ?>"><?php echo get_phrase('edit_exam'); ?></a></li>
                                        <li><a class="dropdown-item" href="<?php echo site_url('user/cbt/performance/'.$exam['id']); ?>"><?php echo get_phrase('exam_performance'); ?></a></li>
                                        <?php if($exam['status'] == '0') : ?>
                                            <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('user/cbt/activate/'.$exam['id']); ?>');"><?php echo get_phrase('activate_exam'); ?></a></li>
                                        <?php else: ?>
                                            <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('user/cbt/deactivate/'.$exam['id']); ?>');"><?php echo get_phrase('deactivate_exam'); ?></a></li>
                                        <?php endif; ?>
                                        <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('user/cbt/delete/'.$exam['id']); ?>');"><?php echo get_phrase('delete_exam'); ?></a></li>
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