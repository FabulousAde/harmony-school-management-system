<!-- <div class="row">
	<div class="col-xl-12">
		<div class="card">
			 <div class="card-body">
	                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4>
	        </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-12">
		<form action="<?php echo site_url('admin/filtered_result/'); ?>" method="GET">
			<div class="card">
				 <div class="card-body p-4">
		                <div class="row">
		                	<div class="col-xl-8">
			                	<div class="">
			                        <div class="form-group">
			                            <label for="category_id"><?php echo get_phrase('categories'); ?></label>
				                            <select class="form-control select2" data-toggle="select2" name="category_id" id="category_id">
				                                <option value="<?php echo 'all'; ?>" <?php if($selected_category_id == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
				                                <?php foreach ($categories->result_array() as $category): ?>
				                                     <option value="<?php echo $category['id']; ?>" <?php if($selected_category_id == $category['id']) echo 'selected'; ?>><?php echo $category['name']; ?></option>
				                            	<?php endforeach; ?>
				                        	</select>
				                    </div>
				                </div>
			                </div>
			                <div class="col-xl-2">
			                    <label for=".." class="text-white"><?php echo get_phrase('..'); ?></label>
			                    <button type="submit" class="btn btn-primary btn-block"><?php echo get_phrase('filter'); ?></button>
			                </div>
		                </div>
		        </div>


		        <?php if ($selected_category_id != 'all') : ?>

		        <div class="col-xl-12 p-3">
			        <div class="table-responsive-sm mt-4">
			                <table id="basic-datatable" class="table table-striped table-centered mb-0">
			                  <thead>
			                    <tr>
			                      <th>#</th>
			                      <th><?php echo get_phrase('photo'); ?></th>
			                      <th><?php echo get_phrase('name'); ?></th>
			                      <th><?php echo get_phrase('email'); ?></th>
			                      <th><?php echo get_phrase('actions'); ?></th>
			                    </tr>
			                  </thead>
			                  <tbody>
			                    <?php foreach($users->result_array() as $key => $user): ?>
			                        <tr>
			                            <td><?php echo $key+1; ?></td>
			                            <td>
			                                <div>
			                                  <img src="<?php echo $this->user_model->get_user_image_url($user['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail"> <div class="user_status <?php if($user['status'] == '0'): echo 'u__disabled'; else: echo 'u__enabled'; endif; ?>"></div>
			                                </div>
			                            </td>
			                            <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
			                            <td><?php echo $user['email']; ?></td>
			                            <td>
			                                  <div class="dropright dropright">
			                                    <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			                                        <i class="mdi mdi-dots-vertical"></i>
			                                    </button>
			                                    <ul class="dropdown-menu">
			                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/result/new/'.$user['id']) ?>"><?php echo get_phrase('new_result'); ?></a></li>
			                                        <li><a class="dropdown-item" href="<?php echo site_url('admin/result/view/'.$user['id']) ?>"><?php echo get_phrase('view_all_results'); ?></a></li>
			                                    </ul>
			                                </div>
			                              </td>
			                        </tr>
			                    <?php endforeach; ?>
			                  </tbody>
			        </table>
			        </div>
			    </div>

		    	<?php endif; ?>

			</div>
		</form>
	</div>
</div> -->