<?php
    $social_links = json_decode($user_details['social_links'], true);
 ?>
 <section class="page-header-area my-course-area">
     <div class="container">
         <div class="row">
             <div class="col">
                 <h1 class="page-title"><?php echo get_phrase('user_profile'); ?></h1>
                 <ul>
                     <li><a href="<?php echo site_url('home/my_courses'); ?>"><?php echo get_phrase('all_courses'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_messages'); ?>"><?php echo get_phrase('my_messages'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_assignments'); ?>"><?php echo get_phrase('my_assignments'); ?></a></li>
                     <li><a href="<?php echo site_url('home/study_history'); ?>"><?php echo get_phrase('study_history'); ?></a></li>
                     <li class="active"><a href=""><?php echo get_phrase('user_profile'); ?></a></li>
                     <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_certificates'); ?></a></li>
                     <!-- <li><a href="<?php // echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li> -->
                     <?php if(get_settings('use_past_question') == '1'): ?>
                        <li><a href="<?php echo site_url('home/pastquestion'); ?>"><?php echo get_phrase('past_question'); ?></a></li>
                    <?php endif; ?>
                 </ul>
             </div>
         </div>
     </div>
 </section>

<section class="user-dashboard-area">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="user-dashboard-box">
                    <div class="user-dashboard-sidebar">
                        <div class="user-box">
                            <img src="<?php echo base_url().'uploads/user_image/'.$this->session->userdata('user_id').'.jpg';?>" alt="" class="img-fluid">
                            <div class="name">
                                <div class="name"><?php echo $user_details['first_name'].' '.$user_details['last_name']; ?></div>
                            </div>
                        </div>
                        <div class="user-dashboard-menu">
                            <ul>
                                <li class="active"><a href="<?php echo site_url('home/profile/user_profile'); ?>"><?php echo get_phrase('profile'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_credentials'); ?>"><?php echo get_phrase('account'); ?></a></li>
                                <li><a href="<?php echo site_url('home/profile/user_photo'); ?>"><?php echo get_phrase('photo'); ?></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="user-dashboard-content">
                        <div class="content-title-box">
                            <div class="title"><?php echo get_phrase('profile'); ?></div>
                            <div class="subtitle"><?php echo get_phrase('add_information_about_yourself_to_share_on_your_profile'); ?>.</div>
                        </div>
                        <form action="<?php echo site_url('home/update_profile/update_basics'); ?>" method="post">
                            <div class="content-box">
                                <div class="basic-group">
                                    <div class="form-group">
                                        <label for="FristName"><?php echo get_phrase('first_name'); ?>:</label>
                                        <input type="text" class="form-control" name = "first_name" id="FristName" placeholder="<?php echo get_phrase('first_name'); ?>" value="<?php echo $user_details['first_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="last_name"><?php echo get_phrase('other_name'); ?>:</label>
                                        <input type="text" class="form-control" id="last_name" name = "last_name" placeholder="<?php echo get_phrase('last_name'); ?>" value="<?php echo $user_details['last_name']; ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="gender"><?php echo get_phrase('gender'); ?>:</label>
                                        <select class="form-control" name="gender" id="gender">
                                            <option>----Select Gender----</option>
                                            <option value="male" <?php if($user_details['gender'] == 'male') echo 'selected'; ?>>Male</option>
                                            <option value="female" <?php if($user_details['gender'] == 'female') echo 'selected'; ?>>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="lga"><?php echo get_phrase('lga'); ?>:</label>
                                        <input type="text" id="lga" name="lga" value="<?php echo get_phrase($user_details['lga']); ?>" class="form-control" placeholder="LGA">
                                    </div>
                                    <div class="form-group">
                                        <label for="state"><?php echo get_phrase('state_of_origin'); ?>:</label>
                                        <input type="text" name="state" id="state" value="<?php echo get_phrase($user_details['state']); ?>" class="form-control" placeholder="State of Origin">
                                    </div>
                                    <div class="form-group">
                                        <label for="nationality"><?php echo get_phrase('nationality'); ?>:</label>
                                        <input type="text" name="nationality" id="nationality" value="<?php echo get_phrase($user_details['nationality']); ?>" class="form-control" placeholder="Nationality">
                                    </div>
                                    <div class="form-group">
                                        <label for="current-class"><?php echo get_phrase('current_class'); ?>:</label>
                                        <input type="text" id="current-class" value="<?php echo get_phrase($user_details['class_options']); ?>" name="class" class="form-control" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="address"><?php echo get_phrase('residential_address'); ?>:</label>
                                        <input type="text" id="address" value="<?php echo get_phrase($user_details['address']); ?>" name="address" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="phone"><?php echo get_phrase('phone_number'); ?>:</label>
                                        <input type="phone" id="phone" value="<?php echo get_phrase($user_details['phone']); ?>" name="phone" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="genotype"><?php echo get_phrase('genotype'); ?>:</label>
                                        <input type="text" id="genotype" maxlength="10" value="<?php echo get_phrase($user_details['genotype']); ?>" name="genotype" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="blood_group"><?php echo get_phrase('blood_group'); ?>:</label>
                                        <input type="text" id="blood_group" value="<?php echo get_phrase($user_details['blood_group']); ?>" name="blood_group" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="allergies"><?php echo get_phrase('allergies'); ?>:</label>
                                        <input type="text" id="allergies" maxlength="10" value="<?php echo get_phrase($user_details['allergies']); ?>" name="allergies" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label for="Biography"><?php echo get_phrase('biography'); ?>:</label>
                                        <textarea class="form-control author-biography-editor" name = "biography" id="Biography"><?php echo $user_details['biography']; ?></textarea>
                                    </div>
                                </div>
                                <div class="link-group">
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "twitter_link" placeholder="<?php echo get_phrase('twitter_link'); ?>" value="<?php echo $social_links['twitter']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_your_twitter_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "facebook_link" placeholder="<?php echo get_phrase('facebook_link'); ?>" value="<?php echo $social_links['facebook']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_your_facebook_link'); ?>.</small>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" maxlength="60" name = "linkedin_link" placeholder="<?php echo get_phrase('linkedin_link'); ?>" value="<?php echo $social_links['linkedin']; ?>">
                                        <small class="form-text text-muted"><?php echo get_phrase('add_your_linkedin_link'); ?>.</small>
                                    </div>
                                </div>
                            </div>
                            <div class="content-update-box">
                                <button type="submit" class="btn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
