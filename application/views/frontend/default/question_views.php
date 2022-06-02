<style type="text/css">
	fieldset, label, .input .container {
		margin-bottom: 0;
	}
</style>
<!-- <div class="row"> -->
    <!-- <div class="col-sm-12 col-lg-12"> -->
        <div class="card text-white bg-quiz-result-info mb-3">
            <div class="card-body">
                <h5 class="card-title header">E-learning questions.</h5>
                <?php
					foreach ($cc_list as $ckey => $courses_id) :
						$current = $this->db->get_where('lesson', array('id' => $courses_id))->row_array();
						$quiz_questions = $this->crud_model->get_quiz_questions($courses_id);
				?>
					<form class="<?php if($ckey != 0) echo 'hidden'; ?>" id = "quiz_form<?php echo $ckey; ?>" action="" method="post">
						<p class="card-text"><?php echo $current['summary']; ?></p>
				        <?php if (count($quiz_questions->result_array()) > 0): ?>
				            <?php foreach ($quiz_questions->result_array() as $key => $quiz_question):
				                $options = json_decode($quiz_question['options']);
				            ?>
				                <input type='hidden' name="lesson_id" value="<?php echo $current['id']; ?>">
				                <div class="<?php if($key != 0) echo 'hidden'; ?>" id = "question-number-<?php echo $key+1; echo '-'.$ckey; ?>">
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
		                                                          <input class="form-check-input" groupname="<?php echo $key; ?>" type="checkbox" name="<?php echo $quiz_question['id']; ?>[]" value="<?php echo $key2+1; ?>" id="quiz-id-<?php echo $quiz_question['id']; ?>-option-id-<?php echo $key2+1; ?>" onclick="enableNextButton('<?php echo $quiz_question['id'];?>')">
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
				                    <button type="button" name="button" class="btn btn-sign-up mt-2 mb-2" id = "next-btn-<?php echo $quiz_question['id'];?>" style="color: #fff;" <?php if(count($quiz_questions->result_array()) == $key+1):?>onclick="submitQuiz('<?php echo $ckey; ?>', '<?php echo $list_length; ?>')"<?php else: ?>onclick="showNextQuestion('<?php echo $key+2; ?>', '<?php echo $ckey; ?>')"<?php endif; ?> disabled><?php echo count($quiz_questions->result_array()) == $key+1 ? get_phrase("next") : get_phrase("submit_&_next"); ?></button>
				                </div>
				            <?php endforeach; ?>
				        <?php endif; ?>
				    </form>
				    <div id="quiz-result-<?php echo $ckey; ?>" class="text-left hidden"></div>
				<?php
					endforeach;
				?>
            </div>
        </div>


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
			    $('#question-number-'+(next_question-1)+'-'+index).hide();
			    $('#question-number-'+next_question+'-'+index).show();
			}
			function enableNextButton(quizID) {
			    $('#next-btn-'+quizID).prop('disabled', false);
			}
			function submitQuiz(current, t_t) {
				// showNextQuestion();
				$('#quiz_form'+current).hide();
				$.ajax({
			        url: '<?php echo site_url('home/submit_questions'); ?>',
			        type: 'post',
			        data: $('form#quiz_form'+current).serialize(),
			        success: function(response) {
			            // $('#quiz_form'+current).hide();
			            $('#quiz-result-'+current).html(response);
			        }
			    });
				if(t_t > (parseInt(current) + 1)){
					$('#quiz_form'+(parseInt(current) + 1)).show();
				} else {
					// $('#quiz_form'+current).hide();
					for (var i = 0; i < parseInt(t_t); i++) {
						$('.card-body .header').hide();
						$('#quiz-result-'+i).show();
					}
				}
				
			}
        </script>
    <!-- </div> -->
<!-- </div> -->

<!-- <div class="text-center">
    <button class="btn btn-primary proceed-btn" onclick="getStarted('1')"><?php //echo get_phrase('start'); ?></button>
</div> -->