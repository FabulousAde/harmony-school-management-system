<style>
@media print {
   body {
       font-size: 10pt; line-height: 120%; background: white;
   }
   .card {
       margin: 90px 0;
       /*height: 842px;*/
   }
   .print_header, a.edit-pen, .switch{
       display: none;
   }
}

.header div{
    padding: 2px 0;
}
.header img {
    height: 70px;
    width: 90px;
    margin-top: 14px;
    margin-bottom: 17px;
}
table.pre-table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}
.text-header-div{
    margin: 21px 0;
    font-size: 1.4em;
}
table.pre-table tr.col-space td {
    padding: 20px 0;
}
table.pre-table tr.col-space td {
    padding: 10px 0;
}
.pre-table td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>
<div class="row print_header">
	<div class="col-xl-12">
		<div class="card">
			 <div class="card-body">
			     <div class="row col-sm-12">
			         <div class="col-sm-10 h3">
    	                <h4 class="page-title"> <i class="fa fa-user"></i> <?php echo $user['first_name']." ".$user['last_name']; ?> <span style="color: blue;"><strong>Results</strong></span></h4>
    	             </div>
    	             <div class="col-sm-2"><div class="text-right"><button onclick="javascript:window.print();" class="btn btn-primary btn-block">Print</button></div></div>
			     </div>
	        </div>
		</div>
	</div>
</div>

<?php if($all_result_log->num_rows() < 1): ?>
    <div class="text-center"><?php echo get_phrase('no_result_found'); ?></div>
<?php else: ?>
    <?php foreach($all_result_log->result_array() as $key => $log): ?>
        <?php $all_results = $this->crud_model->get_results($log['id'], $log['class_category']); ?>
        <div class="row">
        	<div class="col-xl-12">
        		<div class="card">
        			 <div class="card-body">
        			     <div class="text-center header">
                            <div style="float: left;">
                                 <label class="switch">
                                  <input id="checkbox" type="checkbox" class="<?php echo $log['id']; ?>" <?php if($log['status'] == 1) echo 'checked'; ?> >
                                  <span class="slider round"></span>
                                </label>
                             </div>
        			         <div class="text-right">
                                <a class="edit-pen" href="<?php echo site_url('user/result/edit/'.$log['id']).'/'.$user['id']; ?>"><i class="fas fa-pencil-alt"></i></a>
                            </div>
        			         <img src="<?php echo site_url('/uploads/system/logo-light.png'); ?>">
        			         <div><b>VICTORIA PRAISE PEARLS SCHOOLS ( VPPS )</b></div>
        			         <div>REPORT CARD</div>
        			         <div><b><?php echo strtoupper(get_phrase($log['session'].'_term')); ?></b></div>
        			     </div><br>
        			     <div class="row">
        			         <div class="col-sm-2">
            			         <div>
                                      <img src="<?php echo $this->user_model->get_user_image_url($user['id']);?>" alt="" height="120" width="110" class="img-fluid img-thumbnail"> <div class="user_status <?php if($user['status'] == '0'): echo 'u__disabled'; else: echo 'u__enabled'; endif; ?>"></div>
                                 </div>
            			     </div>
            			     <div class="col-sm-10">
            			         <div class="table-responsive-sm mt-0">
            			         <table class="pre-table">
                                     <tbody class="table mb-0">
                                         <tr>
                                             <td>CLASS:</td>
                                             <td class="text-center"><b><?php echo strtoupper(get_phrase($log['class'])); ?></b></td>
                                             <td>Times school opened</td>
                                             <td class="text-center"><?php echo $log['total_sopen']; ?></td>
                                         </tr>
                                         <tr>
                                             <td>NAME:</td>
                                             <td class="text-center"><?php echo strtoupper($user['first_name']." ".$user['last_name']); ?></td>
                                             <td>Times present</td>
                                             <td class="text-center"><?php echo $log['time_present']; ?></td>
                                         </tr>
                                         <tr>
                                             <td>AGE:</td>
                                             <td></td>
                                             <td>Times absent</td>
                                             <td class="text-center"><?php echo $log['time_absent']; ?></td>
                                         </tr>
                                         <tr>
                                             <td>SESSION:</td>
                                             <td colspan=1 class="text-center"><?php echo $log['year_session']; ?></td>
                                             <td>GENDER</td>
                                             <td class="text-center"><?php echo $user['gender']; ?></td>
                                         </tr>
                                     </tbody>
                                 </table>
                			     </div>
            			     </div>
        			     </div>
        			     <div class="text-center text-header-div">
        			         <b>COGNITIVE (PERFORMANCE IN SUBJECTS)</b>
        			     </div>
        			     <?php if($log['class_category'] == 'primary'): ?>
            			     <div class="table-responsive-sm mt-0">
            			        <table class="table table-striped table-centered mb-0">
            			            <thead>
                			             <tr>
                			                 <td>Course</td>
                			                 <td>CAT1</td>
                			                 <td>CAT2</td>
                			                 <td>CAT3</td>
                			                 <td>CAT4</td>
                			                 <td>EXAM</td>
                			                 <td>TOTAL</td>
                			                 <td>GRADE</td>
                			             </tr>
                			             <br>
                			         </thead>
                			        <?php foreach($all_results->result_array() as $key => $results): ?>
                			            <tr>
                                            <td><?php echo $results['course_name']; ?></td>
                                            <td><?php  echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['cat1']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' :$results['cat2']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['cat3']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['cat4']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['exam_score']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['total_scores']; ?></td>
                                            <td><?php echo ($results['cat1'] == 0 && $results['cat2'] == 0 && $results['cat3'] == 0 && $results['cat4'] == 0 && $results['exam_score'] == 0) ? 'Nill' : $results['grade']; ?></td>
                                        </tr>
                    			    <?php endforeach;  ?>
                			    </table>
                			  </div>
                	     <?php else: ?>
                	        <div class="table-responsive-sm mt-4">
            			        <table class="table table-striped table-centered mb-0">
            			            <thead>
                			             <tr>
                			                 <td>Course</td>
                			                 <td>REVIEW</td>
                			                 <td>GRADE</td>
                			             </tr>
                			             <div class="row col-sm-12">
                			                 <div class="col-sm-10 h3">
                			                     <?php echo '<span style="color: blue;">'.$log['year_session'].'</span><br><span class="h6">'.get_phrase($log['session'].'_term').'</span>'; ?>
                			                 </div>
                			                 <!--  -->
                			             </div><br>
                			         </thead>
                			        <?php foreach($all_results->result_array() as $key => $results): ?>
                			            <tr>
                			                <td><?php echo $results['course_name']; ?></td>
                			                <td><?php echo $results['review']; ?></td>
                			                <td><?php echo $results['grade']; ?></td>
                			            </tr>
                    			    <?php endforeach;  ?>
                			    </table>
                			  </div>
        			     <?php endif; ?>
        			     <div>
        			         <div class="table-responsive-sm mt-2">
            			         <table class="pre-table">
                                     <thead>
                                         <tr>
                                             <td colspan="3">RESULT SUMMARY</td>
                                         </tr>
                                     </thead>
                                     <tbody class="table mb-0">
                                         <tr>
                                             <td>GRAND TOTAL</td>
                                             <td>AVERAGE</td>
                                             <td>RESUMPTION DATE</td>
                                         </tr>
                                         <tr class="col-space">
                                             <td class="text-center"><?php echo $log['grand_total']; ?></td>
                                             <td class="text-center"><?php echo $log['average']; ?></td>
                                             <td class="text-center"><?php echo $log['date_resume']; ?></td>
                                         </tr>
                                     </tbody>
                                 </table>
                			 </div>
        			     </div>
                         <div>
                             <div class="table-responsive-sm mt-2">
                                <div class="row col-sm-12">
                                    <div class="row col-sm-2">
                                        <span style="font-weight: bold;"><?php echo get_phrase('teachers_comment:'); ?></span>
                                    </div>
                                    <div class="col-sm-8"><?php echo $log['review']; ?></div>
                                    <div class="col-sm-2 text-right"><img style="float: right;" height="50" src="<?php echo site_url('uploads/core/result/'.$log['class'].'.jpeg'); ?>"></div>
                                </div>

                                <div class="row col-sm-12 mt-3">
                                    <div class="row col-sm-2">
                                        <span style="font-weight: bold;"><?php echo get_phrase('head_teachers_comment:'); ?></span>
                                    </div>
                                    <div class="col-sm-8"><?php echo $log['admin_review']; ?></div>
                                     <div class="col-sm-2 text-right"><img style="float: right;" height="50" src="<?php echo site_url('uploads/core/result/head_teacher.jpeg'); ?>"></div>
                                </div>
                             </div>
                         </div>
        	        </div>
        		</div>
        	</div>
        </div>
    <? endforeach; ?>
<?php endif; ?>

<script>
    $('input#checkbox').click(function (){
        var status;
        var post = $(this).attr('class');
        if($(this).prop("checked") == true){
            status = true;
        }
        else if($(this).prop("checked") == false){
            status = false;
        }
        $.ajax({
          type: "POST",
          url: '<?php echo site_url("admin/change_result_status"); ?>',
          data: {status, post},
          dataType  : 'json',
          success: function (val) {
              console.log(val);
          },
          error: function (val) {
              console.log('error');
              console.log(val);
          }
        });
    });
</script>
