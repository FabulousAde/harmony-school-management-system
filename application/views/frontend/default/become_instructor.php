<section class="category-header-area">
    <div class="container-lg">
        <div class="row">
            <div class="col">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo site_url('home'); ?>"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item">
                            <a href="#">
                                <?php echo $page_title; ?>
                            </a>
                        </li>
                    </ol>
                </nav>
                <h1 class="category-name">
                    <?php echo get_phrase('register_yourself'); ?>
                </h1>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
              <div class="user-dashboard-box mt-3">
                  <div class="user-dashboard-content w-100 register-form">
                      <div class="content-title-box">
                          <div class="title"><?php echo get_phrase('instructors_registration_form'); ?></div>
                          <div class="subtitle"><?php echo get_phrase('sign_up_and_start_learning'); ?>.</div>
                      </div>
                      <form action="<?php echo site_url('login/register/instructor'); ?>" method="post">
                          <div class="content-box">
                              <div class="basic-group">
                                  <div class="form-group">
                                      <label for="first_name"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php echo get_phrase('first_name'); ?>:</label>
                                      <input type="text" class="form-control" name = "first_name" id="first_name" placeholder="<?php echo get_phrase('first_name'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="last_name"><span class="input-field-icon"><i class="fas fa-user"></i></span> <?php echo get_phrase('last_name'); ?>:</label>
                                      <input type="text" class="form-control" name = "last_name" id="last_name" placeholder="<?php echo get_phrase('last_name'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                    <label for="course_type"><?= get_phrase('select_course_interest'); ?></label>
                                    <select name="course_type" id="course_type" class="form-control selection_height category_option" style="height: 47px;" required>
                                      <option value="old"><?= get_phrase('an_existing_course'); ?></option>
                                      <option value="new"><?= get_phrase('a_new_course'); ?></option>
                                    </select>
                                  </div>
                                  <div class="form-group">
                                      <label for="last_name"><span class="input-field-icon"><i class="fas fa-award"></i></span> <?php echo get_phrase('select_class_to_take'); ?>:</label>
                                      <select name="class_options" class="category_option form-control selection_height" style="height: 47px;" required>
                                        <?php
                                          $categories = $this->crud_model->get_categories()->result_array();
                                          foreach ($categories as $key => $category):
                                        ?>
                                          <option value="<?= $category['name']; ?>"><?php echo $category['name']; ?></option>
                                        <?php endforeach; ?>
                                      </select>
                                  </div>
                                  <div class="">
                                    <div class="class_options"></div>
                                  </div>
                                  <div class="form-group">
                                      <label for="registration-email"><span class="input-field-icon"><i class="fas fa-envelope"></i></span> <?php echo get_phrase('email'); ?>:</label>
                                      <input type="email" class="form-control" name = "email" id="registration-email" placeholder="<?php echo get_phrase('email'); ?>" value="" required>
                                  </div>
                                  <div class="form-group">
                                      <label for="registration-password"><span class="input-field-icon"><i class="fas fa-lock"></i></span> <?php echo get_phrase('password'); ?>:</label>
                                      <input type="password" class="form-control" name = "password" id="registration-password" placeholder="<?php echo get_phrase('password'); ?>" value="" required>
                                  </div>
                              </div>
                          </div>
                          <div class="content-update-box">
                              <button type="submit" class="btn"><?php echo get_phrase('sign_up'); ?></button>
                          </div>
                      </form>
                  </div>
              </div>
            </div>
        </div>
    </div>
</section>
<style>
  .selection_height{
    height: 47px;
  }
</style>

<script type="text/javascript">
  $(document).ready(function () {
    console.log('herr');
    $('#course_type').on('change', function() {
      console.log('here ');
    });
  });
</script>