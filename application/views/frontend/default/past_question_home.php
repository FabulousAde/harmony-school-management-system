<?php
    $class_opt = get_phrase($user['class_options']);
    $this->db->select('id');
    $this->db->distinct("id");
    $this->db->from('category');
    $this->db->where('name', $class_opt);
    $dbcat = $this->db->get();
    $dbcat_data = $dbcat->row();
    $dbcat_data_id = $dbcat_data->id;
    $categories = $this->crud_model->get_categories($dbcat_data_id)->result_array();
?>
<style type="text/css">
    .custom-box {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        box-shadow: 0 0 2em 0 rgba(0, 0, 0, 0.105);
        border-radius: 10px;
        min-height: 148px;
        background-color: #fff;
        padding: 30px 0px;
        margin: 50px 0;
    }
    .text-bold {
        font-weight: bold;
    }
    .btn.proceed-btn {
        margin: 20px 0;
        padding-right: 20px;
        padding-left: 20px;
    }
    .name-underline {
        border-bottom: 1px solid #000111;
        width: auto;
        margin: 0 auto;
    }
    .input .container {
      display: block;
      position: relative;
      padding-left: 30px;
      margin-bottom: 12px;
      cursor: pointer;
      font-size: 12px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
    .input label.container text {
        color: red;
    }
    .input .container input {
      position: absolute;
      opacity: 0;
      cursor: pointer;
      height: 0;
      width: 0;
    }
    .input .checkmark {
      position: absolute;
      top: 0;
      left: 0;
      height: 20px;
      border-radius: 4px;
      width: 20px;
      background-color: #eee;
    }
    .input .container:hover input ~ .checkmark {
      background-color: #ccc;
    }
    .input .container input:checked ~ .checkmark {
      background-color: #2196F3;
    }
    .checkmark:after {
      content: "";
      position: absolute;
      display: none;
    }
    .input .container input:checked ~ .checkmark:after {
      display: block;
    }
    .input .container .checkmark:after {
      left: 7px;
      top: 4px;
      width: 5px;
      height: 10px;
      border: solid white;
      border-width: 0 3px 3px 0;
      -webkit-transform: rotate(45deg);
      -ms-transform: rotate(45deg);
      transform: rotate(45deg);
    }
    .input .text {
        color: #83858D;
        font-size: 0.9em;
    }
    .text-div {
        margin: 0 0 7px 0;
    }
    .transp {
        background-color: transparent;
    }
</style>

<section class="page-header-area my-course-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="page-title"><?php echo get_phrase('purchase_history'); ?></h1>
                <ul>
                    <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                    <li><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
                    <li><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('user_profile'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_results'); ?></a></li>
                    <li><a href="<?php echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li>
                    <?php if(get_settings('use_past_question') == '1'): ?>
                        <li class="active"><a href="<?php echo site_url('home/pastquestion'); ?>"><?php echo get_phrase('past_question'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="lesson_starter_screen">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="custom-box text-center">
                    <div class="col-sm-12">
                        <div class="text-center mt-2">
                            <div class="">
                                <h4 class="text-bold">Welcome Here, "<?php echo ucfirst($user['first_name']).' '.ucfirst($user['last_name']); ?>"</h4>
                            </div>
                        </div>
                        <br>
                        <div>
                            <h6>Start a free past question practice on collections of questions and quiz from past given excersises</h6>
                        </div>
                        <div>
                            <button class="btn btn-primary proceed-btn" onclick="getStarted('0')"><?php echo get_phrase('start'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="lesson_select hidden">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="custom-box text-center">
                    <div class="col-sm-12 pt-4 pb-4 mt-4 mb-4">
                        <div class="text-center mt-2">
                            <h4 class="text-bold">Please select your flows for questions.</h4>
                            <div class="row col-sm-12 col-lg-12 col-xl-12 col-xs-12">
                              <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="text-left ml-4 pl-3 input">
                                        <hr>
                                        <div class="text-div">
                                            <span class="text">Random questions will be shown from all courses.</span>
                                        </div>
                                        <label class="container"><?php echo get_phrase('all_courses'); ?>
                                          <input type="checkbox" checked="checked" disabled>
                                          <span class="checkmark"></span>
                                        </label>
                                        
                                        <hr>
                                        <div class="text-div">
                                            <span class="text">Or you can manually select courses from the list below.</span>
                                        </div>
                                        <div class="course-select">
                                            <?php
                                                foreach ($categories as $key => $category):
                                                    $sub_categories = $this->crud_model->get_sub_categories($category['id']);

                                                    foreach ($sub_categories as $sub_category): ?>
                                                        <label class="container"><?php echo $sub_category['name']; ?>
                                                          <input type="checkbox" checked="checked" name="<?php echo $sub_category['id']; ?>">
                                                          <span class="checkmark"></span>
                                                        </label>
                                             <?php
                                                    endforeach;
                                                endforeach;
                                            ?>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-primary proceed-btn" onclick="getStarted('1')"><?php echo get_phrase('start'); ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="lesson_start hidden">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="custom-box text-center">
                    <div class="col-sm-12 pt-4 pb-4 mt-4 mb-4">
                        <div class="text-center mt-2">
                            <div class="row col-sm-12 col-lg-12 col-xl-12 col-xs-12">
                              <div class="col-sm-1"></div>
                              <div class="col-sm-10 content-card"> </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    let courseList = new Array();
    $(document).ready(function () {
        $('.lesson_starter_screen').hide();
        $('.lesson_select').show();
        $('.lesson_start').hide();

        const input = $('div.course-select input');
        for (var i = 0; i < input.length; i++) {
            courseList.push(input[i].name)
        }
    });
    $('div.course-select input').click(function () {
        var status;
        if($(this).prop("checked") == true){
            status = true;
            courseList.push(this.name);
        } else if($(this).prop("checked") == false){
            status = false;
            let index = courseList.indexOf(this.name);
            delete courseList[index];
        }
       console.log(status);
       console.log(this.name);

    });
    function getStarted(number) {
        if(number == '0') {
            $('.lesson_starter_screen').hide();
            $('.lesson_select').show();
        } else if(number == '1') {
            var list = courseList.filter(Boolean);

            $.ajax({
              type: "POST",
              url: '<?php echo site_url("home/past_questions"); ?>',
              data: {list},
              // dataType  : 'json',
              success: function (val) {
                  console.log(val);
                  $('.lesson_select').hide();
                  $('.lesson_start .content-card').html(val);
                  $('.lesson_start').show();
              },
              error: function (val) {
                  console.log('error');
                  console.log(val);
              }
            });

        //     // $('.lesson_select').hide();
        //     // $('.lesson_start').show();
        }
    }
</script>

