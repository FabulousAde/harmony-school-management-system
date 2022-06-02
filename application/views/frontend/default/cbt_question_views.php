<?php
	$cbt = $this->crud_model->get_cbtexams($exam_id)->row_array();
	$cbt_hour = explode(':', $cbt['exam_time'])[0];
    $cbt_min = explode(':', $cbt['exam_time'])[1];
    $allSeconds = ($cbt_hour * 60 * 60) + ($cbt_min * 60);
?>
<style type="text/css">
	fieldset, label, .input .container {
		margin-bottom: 0;
	}
	.clock {
		color: #DA3B41;
		font-size: 1.7em;
		font-weight: 900;
		margin-bottom: 20px;
		font-family: Lato, sans-serif;
	}
	.question_remain {
	    position: absolute;
	    top: 12px;
	    display: block;
	    right: 4px;
	    font-weight: 900;
	    font-size: 1.36em;
	    padding-right: 5px;
	    padding-bottom: 10px;
	    text-align: right;
	    float: right;
	}
</style>
<!-- <div class="row"> -->
    <!-- <div class="col-sm-12 col-lg-12"> -->
    	<body>
    		<div class="text-center clock">
	    		<span id="clock_show"> </span>
	    	</div>
	        <div class="card exam_area text-white bg-quiz-result-info mb-3">
	            <div class="card-body">
	                <h5 class="card-title header">CBT Questions.</h5>
	                <form method="post" onsubmit="return false;">
	                	<div></div>
		                <?php
			                // echo count($cc_list);
							foreach ($exams->result_array() as $ckey => $exam) :
								$quiz_questions = $this->crud_model->get_examquestions($exam['id']);
						?>
							<div class="<?php if($ckey != 0) echo 'hidden'; ?>" id = "quiz_form<?php echo $ckey; ?>">
								<div class="text-bold">
									<?=$exam['title'];?>
								</div>
								<p class="card-text"><?php echo $exam['summary']; ?></p>
						        <?php if (count($quiz_questions->result_array()) > 0): ?>
						            <?php foreach ($quiz_questions->result_array() as $key => $quiz_question):
						                $options = json_decode($quiz_question['options']);
						            ?>
						                <input type='hidden' name="lesson_id" value="<?php echo $cbt['id']; ?>">
						                <div class="<?php if($key != 0) echo 'hidden'; ?>" id = "question-number-<?php echo $key+1; echo '-'.$ckey; ?>">
						                	<div class="question_remain"><?= $key+1; ?>/<?=$quiz_questions->num_rows();?></div>
						                    <div class="row justify-content-center">
						                        <div class="col-lg-8">
						                            <div class="card text-left transp">
						                                <div class="card-body">
						                                    <h6 class="card-title"><?php echo get_phrase("question").' '.($key+1); ?> : <strong><?php echo $quiz_question['title']; ?></strong></h6>
						                                </div>
						                                <ul class="list-group list-group-flush">
						                                    <?php
						                                    foreach ($options as $key2 => $option): ?>
						                                    <li class="list-group-item quiz-options">
						                                        <div class="form-check">
						                                        	<fieldset class="input">
						                                        		<label class="container"><?php echo $option; ?>
				                                                          <input class="form-check-input" groupname="<?php echo $key; ?>" type="checkbox" name="<?php echo $exam['id'].'_'.$quiz_question['id']; ?>[]" value="<?php echo $key2+1; ?>" id="quiz-id-<?php echo $quiz_question['id']; ?>-option-id-<?php echo $key2+1; ?>" onclick="enableNextButton('<?php echo $quiz_question['id'];?>')">
				                                                          <span class="checkmark"></span>
							                                            </label>
						                                        	</fieldset>
						                                        </div>
						                                    </li>
						                                    <?php endforeach; ?>
						                                </ul>
						                            </div>
						                        </div>
						                    </div>
						                    <button type="button" name="button" class="btn btn-sign-up mt-2 mb-2" id = "next-btn-<?php echo $quiz_question['id'];?>" onclick="showPrevQuestion('<?php echo $key+2; ?>', '<?php echo $ckey; ?>');"><?= get_phrase('prev'); ?></button>

						                    <?php if($quiz_questions->num_rows() > ($key + 1)): ?><button type="button" name="button" class="btn btn-sign-up mt-2 mb-2" id = "next-btn-<?php echo $quiz_question['id'];?>" style="color: #fff;" <?php if(count($quiz_questions->result_array()) == $key+1):?> onclick="nextOrPrev('<?php echo $ckey; ?>', '<?php echo $list_length; ?>')"<?php else: ?>onclick="showNextQuestion('<?php echo $key+2; ?>', '<?php echo $ckey; ?>')"<?php endif; ?>><?php echo count($quiz_questions->result_array()) == $key+1 ? get_phrase("next") : get_phrase("next"); ?></button>
							                <?php endif; ?>
						                </div>
						            <?php endforeach; ?>
						        <?php endif; ?>
							</div>
						    <div id="quiz-result-<?php echo $ckey; ?>" class="text-left hidden"></div>
						<?php
							endforeach;
						?>
					</form>
	            </div>
	        </div>
	        <div class="sucess_msg hidden">
	        	<div class="card text-white bg-quiz-result-info mb-3">
		            <div class="card-body">
		                <h5 class="card-title header">You have sucessfully completed the Computer Based Test. Your result has been recorded. you may click the Close button.</h5>

		                <a href="<?= site_url('home/cbt'); ?>" class="btn btn-sign-up mt-2 mb-2"><?= get_phrase('close'); ?></a>
		            </div>
		        </div>
	        </div>
	        <div class="text-center btn_submit">
		    	<button type="button" name="button" class="btn btn-sign-up mt-2 mb-2" onclick="xExamRet('<?= $cbt['id']; ?>');"><?= get_phrase('submit_now'); ?></button>
		    </div>
    	</body>


        <script type="text/javascript">
        	$('input[type=checkbox]').click(function() {
		        var groupName = $(this).attr('groupname');
	            if (!groupName) return;

	            var checked = $(this).is(':checked');

	            $("input[groupname='" + groupName + "']:checked").each(function() {
	                $(this).prop('checked', '');
	            });

	            if (checked) $(this).prop('checked', 'checked');
	        });
        	function showNextQuestion(next_question, index) {
				console.log(next_question);
			    $('#question-number-'+(next_question-1)+'-'+index).hide();
			    $('#question-number-'+next_question+'-'+index).show();
			}
			function showPrevQuestion(next_question, index) {
				console.log(next_question);
				console.log(index);
				if(next_question !== '2') {
					$('#question-number-'+(next_question-1)+'-'+index).hide();
				    $('#question-number-'+(next_question-2)+'-'+index).show();
				}
			}
			function enableNextButton(quizID) {
			    $('#next-btn-'+quizID).prop('disabled', false);
			}
			function nextOrPrev(current, t_t) {
				// showNextQuestion();
				console.log('current');
				console.log(current);
				console.log('tt');
				console.log(t_t);
				if(t_t > (parseInt(current) + 1)){
					console.log('here first');
					$('#quiz_form'+(parseInt(current))).hide();
					$('#quiz_form'+(parseInt(current) + 1)).show();
				} else {
					// console.log('here last');
					// $('#quiz_form'+(parseInt(current))).hide();
					// $('#quiz_form0').show();
					// $('#question-number-'+'1'+'-0').show();
					// for (var i = 0; i < parseInt(t_t); i++) {
					// 	$('.card-body .header').hide();
					// 	$('#quiz-result-'+i).show();
					// }
				    // $('#question-number-'+'1+''-1').show();
				}
			}
			function xExamRet(current, t_t) {
				$('.exam_area').hide();
				$('.clock').hide();
				$('.sucess_msg').show();
				$('.btn_submit').hide();
				$('#quiz_form'+current).hide();
				$.ajax({
			        url: '<?php echo site_url('home/submit_cexams'); ?>',
			        type: 'post',
			        data: $('form').serialize(),
			        success: function(response) {
			            // $('#quiz_form'+current).hide();
			            $('#quiz-result-'+current).html(response);
			        }
			    });
				// if(t_t > (parseInt(current) + 1)){
				// 	$('#quiz_form'+(parseInt(current) + 1)).show();
				// } else {
				// 	// $('#quiz_form'+current).hide();
				// 	for (var i = 0; i < parseInt(t_t); i++) {
				// 		$('.card-body .header').hide();
				// 		$('#quiz-result-'+i).show();
				// 	}
				// }
			}
        </script>
        <script>
        	$(document).ready(function () {
        		examTimer('<?=$allSeconds;?>');
        	});
        	var end = 0;
	        function customSubmit(someValue){  
	        	 document.questionForm.minute.value = min;   
	        	 document.questionForm.second.value = sec; 
	        	 document.questionForm.submit();  
        	 }

        	 function timeCal() {
				var days=Math.floor(window.start / 86400);

				var hours = Math.floor((window.start - (days * 86400 ))/3600);
				var minutes = Math.floor((window.start - (days * 86400 ) - (hours *3600 ))/60);
				var secs = Math.floor((window.start - (days * 86400 ) - (hours *3600 ) - (minutes*60)));

				var x = "Time Remaining: " + hours + " Hrs "  + minutes + " Mins "  + secs + " Secs ";
				document.getElementById('clock_show').innerHTML = x;

				window.start= window.start- 1;

				tt = examTimer(window.start);
			 }
	        function examTimer(start) {
	        	window.start = parseFloat(start);

	        	if(window.start >= end ){
					mytime = setTimeout('timeCal()', 1000);
				} else {
					xExamRet('<?= $cbt['id']; ?>');
				}

	   //      	setInterval(function() {
				//   // Get today's date and time
				//   var now = new Date().getTime();

				//   // Find the distance between now and the count down date

				//   // Time calculations for days, hours, minutes and seconds
				//   var days = Math.floor(distance / (1000 * 60 * 60 * 24));
				//   var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
				//   var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
				//   var seconds = Math.floor((distance % (1000 * 60)) / 1000);

				//   // Display the result in the element with id="demo"
				//   document.getElementById("clock_show").innerHTML = hours + "h "
				//   + minutes + "m " + seconds + "s ";

				//   // If the count down is finished, write some text
				//   if (distance < 0) {
				//     clearInterval(x);
				//     document.getElementById("clock_show").innerHTML = "EXPIRED";
				//   }
				// }, 1000);
	     //        if (parseInt(sec) > 0) {
				  //   document.getElementById("clock_show").innerHTML = "Time Remaining: "+hour+" hours:"+min+" Mins, " + sec+" Secs";
	     //            sec = parseInt(sec) - 1;                
	     //            tim = setTimeout("examTimer()", 1000);
	     //        }
	     //        else {
				  //   if (parseInt(min) == 0 && parseInt(sec) == 0){
				  //   	document.getElementById("clock_show").innerHTML = "Time Remaining: "+hour+" hours:"+min+" Mins, " + sec+" Secs";
					 //     alert("Time Up");
					 //     document.questionForm.minute.value=0;
					 //     document.questionForm.second.value=0;
					 //     document.questionForm.submit();
				  //    }

	     //            if (parseInt(sec) == 0) {				
					 //    document.getElementById("clock_show").innerHTML = "Time Remaining: "+hour+" hours:"+min+" Mins, " + sec+" Secs";
	     //                min = parseInt(min) - 1;
						// sec=59;
	     //                tim = setTimeout("examTimer()", 1000);
	     //            }

	     //        }
	        }
	    </script>
    <!-- </div> -->
<!-- </div> -->

<!-- <div class="text-center">
    <button class="btn btn-primary proceed-btn" onclick="getStarted('1')"><?php //echo get_phrase('start'); ?></button>
</div> -->