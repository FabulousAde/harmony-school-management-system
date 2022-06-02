<div class="row">
	<div class="col-xl-12">
		<div class="card">
			 <div class="card-body">
	                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4>
	        </div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xl-7">
		<div class="">
			<div class="card widget-inline">
				<div class="card-body">
				    <h4 class="mb-3 header-title">ADD LESSON NOTE</h4>
					<!--<h6>-->
					    <label for="select_resource">
					        <?php echo get_phrase('select_resources'); ?>
	    				    <span class="required">*</span>
					    </label>
					<!--</h4>-->
					<form action="<?php echo base_url('admin/upload_lessonnote'); ?>" method="post" enctype="multipart/form-data">
						<div class="form-group mb-2">
						    <div class="input-group">
						      <div class="custom-file">
		    				    <input class="custom-file-input" accept="*" type="file" required id="resource_file_selection" name="resource_file_selection" >
		    				    <label class="custom-file-label">select file</label>
		    				  </div>
						    </div>
						</div>
						<?php if($this->session->userdata('admin_login') == true): ?>
							<div class="form-group mb-2">
							    <div class="input-group">
							      <select class="form-control select2" data-toggle="select2" name="main_category" id="main_category" required>
		                                    <option value="<?php echo 'all'; ?>"><?php echo get_phrase('all'); ?></option>
		                                    <?php foreach($all_categories as $key => $categories):
		                                        $current_phrase = $categories['name'];
		                                    ?>
		                                    <option value="<?php echo underscore($categories['name']); ?>"><?php echo $categories['name']; ?></option>
		                                    <?php endforeach; ?>
		                            </select>
							    </div>
							</div>
						<?php endif; ?>
						<div id="input_name_div" class="hidden">
							<label for="select_resource">
								<?php echo get_phrase('lesson_note_name'); ?>
		    				    <span class="required">*</span>
						    </label>
							<div class="form-group mb-2">
		    				    <input class="form-control" id="file_custom_name" name="file_custom_name" required>
							</div>
						</div>
						<div class="row justify-content-center">
						    <div class="col-md-4"><button type="submit" class="btn btn-block btn-primary"><?php echo get_phrase('add_note');  ?></button></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-5">
	    <div class="">
        	<div class="card widget-inline">
        		<div class="card-body">
        			<h4 class="mb-3 header-title"><?php echo get_phrase("resources_info"); ?></h4>
        			<div class="file_details"></div>
        			<div class="saved_name"></div>
        		</div>
        	</div>
        </div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#resource_file_selection').on('change', function (e) {
			var name = e.target.files[0].name, newsname = name.substr(0, name.lastIndexOf('.')+0);
			var size = bytesToSize(e.target.files[0].size);
			$('#input_name_div').attr('class', "");
			$('#file_custom_name').val(newsname);
			$('.file_details').empty();
			$('.saved_name').empty();
			var custom_location = "<?php echo base_url()."uploads/core/lessonnotes/"; ?>";
			$('.custom-file-label').html(name);
			$('.file_details').append("<h5>Selected File Name: "+name+"</h5>");
			$('.file_details').append("<h5>Selected File Size: "+size+"</h5>");
			$('.file_details').append("<h5>Saved File location: "+custom_location+name+"</h5>");
			$('.saved_name').append("<h5>Stored File Name: "+newsname+"</h5>");
			// $('.saved_name').append("<h5></h5>")
		});
		$('#file_custom_name').on('keyup', function() {
			var sname = $('#file_custom_name').val(), newsname = sname.substr(0, sname.lastIndexOf('.')+0);
			$('.saved_name').empty();
			$('.saved_name').append("<h5>Stored File Name: "+sname+"</h5>");
		});
	});
	// function onfileselected(file) {
	// 	// alert('okay');
		
	// }
	function bytesToSize(bytes) {
       var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
       if (bytes == 0) return '0 Byte';
       var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
       return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    }
</script>