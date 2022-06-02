<?php 
    $button_status = get_settings('use_past_question');
?>
<style type="text/css">
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

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('system_settings'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('system_settings');?></h4>

                    <form class="required-form" action="<?php echo site_url('admin/system_settings/system_update'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="system_name"><?php echo get_phrase('website_name'); ?><span class="required">*</span></label>
                            <input type="text" name = "system_name" id = "system_name" class="form-control" value="<?php echo get_settings('system_name');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="system_title"><?php echo get_phrase('website_title'); ?><span class="required">*</span></label>
                            <input type="text" name = "system_title" id = "system_title" class="form-control" value="<?php echo get_settings('system_title');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="website_keywords"><?php echo get_phrase('website_keywords'); ?></label>
                            <input type="text" class="form-control bootstrap-tag-input" id = "website_keywords" name="website_keywords" data-role="tagsinput" style="width: 100%;" value="<?php echo get_settings('website_keywords');  ?>"/>
                        </div>

                        <div class="form-group">
                            <label for="website_description"><?php echo get_phrase('website_description'); ?></label>
                            <textarea name="website_description" id = "website_description" class="form-control" rows="5"><?php echo get_settings('website_description');  ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="author"><?php echo get_phrase('author'); ?></label>
                            <input type="text" name = "author" id = "author" class="form-control" value="<?php echo get_settings('author');  ?>">
                        </div>

                        <div class="form-group">
                            <label for="slogan"><?php echo get_phrase('slogan'); ?><span class="required">*</span></label>
                            <input type="text" name = "slogan" id = "slogan" class="form-control" value="<?php echo get_settings('slogan');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="system_email"><?php echo get_phrase('system_email'); ?><span class="required">*</span></label>
                            <input type="text" name = "system_email" id = "system_email" class="form-control" value="<?php echo get_settings('system_email');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="address"><?php echo get_phrase('address'); ?></label>
                            <textarea name="address" id = "address" class="form-control" rows="5"><?php echo get_settings('address');  ?></textarea>
                        </div>

                        <div class="form-group">
                            <label for="phone"><?php echo get_phrase('phone'); ?></label>
                            <input type="text" name = "phone" id = "phone" class="form-control" value="<?php echo get_settings('phone');  ?>">
                        </div>

                        <div class="form-group">
                            <label for="youtube_api_key"><?php echo get_phrase('youtube_API_key'); ?><span class="required">*</span> &nbsp; <a href = "https://developers.google.com/youtube/v3/getting-started" target = "_blank" style="color: #a7a4a4">(<?php echo get_phrase('get_YouTube_API_key'); ?>)</a></label>
                            <input type="text" name = "youtube_api_key" id = "youtube_api_key" class="form-control" value="<?php echo get_settings('youtube_api_key');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="vimeo_api_key"><?php echo get_phrase('vimeo_API_key'); ?><span class="required">*</span> &nbsp; <a href = "https://www.youtube.com/watch?v=Wwy9aibAd54" target = "_blank" style="color: #a7a4a4">(<?php echo get_phrase('get_Vimeo_API_key'); ?>)</a></label>
                            <input type="text" name = "vimeo_api_key" id = "vimeo_api_key" class="form-control" value="<?php echo get_settings('vimeo_api_key');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="purchase_code"><?php echo get_phrase('purchase_code'); ?><span class="required">*</span></label>
                            <input type="text" name = "purchase_code" id = "purchase_code" class="form-control" value="<?php echo get_settings('purchase_code');  ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="language"><?php echo get_phrase('system_language'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="language" id="language">
                                <?php foreach ($languages as $language): ?>
                                    <option value="<?php echo $language; ?>" <?php if(get_settings('language') == $language) echo 'selected'; ?>><?php echo ucfirst($language); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="language"><?php echo get_phrase('student_email_verification'); ?></label>
                            <select class="form-control select2" data-toggle="select2" name="student_email_verification" id="student_email_verification">
                                <option value="enable" <?php if(get_settings('student_email_verification') == "enable") echo 'selected'; ?>><?php echo get_phrase('enable'); ?></option>
                                <option value="disable" <?php if(get_settings('student_email_verification') == "disable") echo 'selected'; ?>><?php echo get_phrase('disable'); ?></option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="footer_link"><?php echo get_phrase('footer_link'); ?></label>
                            <input type="text" name = "footer_link" id = "footer_link" class="form-control" value="<?php echo get_settings('footer_link');  ?>">
                        </div>

                        <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase('save'); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
    <div class="col-xl-5">
        <div class="card">
            <div class="card-body">
                <div class="col-lg-12">
                    <h4 class="mb-3 header-title"><?php echo get_phrase('update_product');?></h4>

                    <form action="<?php echo site_url('updater/update'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group mb-2">
                            <label><?php echo get_phrase('file'); ?></label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="file_name" name="file_name" required onchange="changeTitleOfImageUploader(this)">
                                    <label class="custom-file-label" for="file_name"><?php echo get_phrase('update_product'); ?></label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary"><?php echo get_phrase('update'); ?></button>
                    </form>
                </div>
            </div> <!-- end card body-->
        </div>

        <?php if($this->session->userdata('admin_login') == true && $this->session->userdata('user_id') == '1'): ?>
          <div class="card">
              <div class="card-body">
                  <div class="col-lg-12">
                      <label><?php echo get_phrase('switch_question_area'); ?></label>
                      <div style="">
                           <label class="switch">
                            <input id="checkbox" type="checkbox" class="<?php echo $log['id']; ?>" <?php if($button_status == 1) echo 'checked'; ?> >
                            <span class="slider round"></span>
                          </label>
                       </div>
                  </div>
              </div>
          </div>
        <?php endif; ?>
        <div class="card">
              <div class="card-body">
                <form class="required-form" action="<?php echo site_url('admin/system_settings/socia_media'); ?>" method="post">
                  <div class="col-lg-12">
                      <h4 class="mb-3 header-title"><?php echo get_phrase('socia_media');?></h4>
                      <div class="form-group">
                           <label for="facebook"><?= get_phrase('facebook'); ?></label>
                            <input type="text" name="facebook" id="facebook" value="<?= get_settings('facebook'); ?>" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="instagram"><?= get_phrase('instagram'); ?></label>
                            <input type="text" name="instagram" id="instagram" value="<?= get_settings('instagram'); ?>" class="form-control">
                       </div>
                       <div class="form-group">
                           <label for="twitter"><?= get_phrase('twitter'); ?></label>
                            <input type="text" name="twitter" id="twitter" value="<?= get_settings('twitter'); ?>" class="form-control">
                       </div>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="checkRequiredFields()"><?php echo get_phrase('update'); ?></button>
                </form>
              </div>
          </div>
    </div>
</div>

<script>
    $('input#checkbox').click(function (){
        var status;
        // var post = $(this).attr('class');
        if($(this).prop("checked") == true){
            status = true;
        }
        else if($(this).prop("checked") == false){
            status = false;
        }
        $.ajax({
          type: "POST",
          url: '<?php echo site_url("admin/change_question_status"); ?>',
          data: {status},
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
