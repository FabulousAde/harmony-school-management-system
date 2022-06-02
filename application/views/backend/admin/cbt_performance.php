<style type="text/css">
    @media print {
       body {
           font-size: 10pt; line-height: 120%; background: white;
       }
       .card {
           margin: 110px 0;
           /*height: 842px;*/
       }
       .print_header, a.edit-pen, .switch, a.delete-can{
           display: none;
       }
    }

</style>
<div class="row">
	<div class="col-xl-12">
		<div class="card">
			 <div class="card-body">
	                <div class="row col-sm-12 col-xs-12 col-lg-12">
                        <div class="col-sm-10"><h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4></div>
                        <div class="col-sm-2"><div class="text-right"><button onclick="javascript:window.print();" class="btn btn-primary btn-block">Print</button></div></div>
                    </div>
	        </div>
		</div>
	</div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="table-responsive-sm mt-4">
                <table id="basic-datatable" class="table table-striped table-centered mb-0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th><?php echo get_phrase('photo'); ?></th>
                      <th><?php echo get_phrase('name'); ?></th>
                      <th><?php echo get_phrase('email'); ?></th>
                      <th><?php echo get_phrase('total_gotten'); ?></th>
                      <th><?php echo get_phrase('total_questions'); ?></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($enrols as $key => $enrol): ?>
                        <?php $user = $this->user_model->get_user($enrol['user_id'])->row_array(); ?>
                        <tr>
                            <td><?php echo $key+1; ?></td>
                            <td>
                                <div>
                                  <img src="<?php echo $this->user_model->get_user_image_url($user['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail"> <div class="user_status <?php if($user['status'] == '0'): echo 'u__disabled'; else: echo 'u__enabled'; endif; ?>"></div>
                                </div>
                            </td>
                            <td><?php echo $user['first_name'].' '.$user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><b><?=$enrol['total_gotten'];?></b></td>
                            <td><b><?=$enrol['total_questions'];?></b></td>
                        </tr>
                    <?php endforeach; ?>
                  </tbody>
        </table>
        </div>
    </div>
</div>