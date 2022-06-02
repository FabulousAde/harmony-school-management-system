<section class="container-lg complete_padding">
    <div class="col-sm-12 col-lg-12 col-xs-12 mb-1 row">
        <div class="col-sm-5 harmony_header pt-5">
            <h1 class=""><strong><?= get_phrase('harmony'); ?></strong></h1>
            <h1 class="primary-color "><strong><?= get_phrase('business'); ?></strong></h1>
            <h1><strong><?= get_phrase('school'); ?></strong></h1>
            <div class="h6">
                <span><?= get_frontend_settings('banner_sub_title'); ?></span>
            </div>
            <div class="home-banner-wrap">
                <form class="" action="<?php echo site_url('home/search'); ?>" method="get">
                    <div class="input-group input-icon pt-1">
                        <input type="text" class="form-control" name = "query" placeholder="What do you want to learn?">
                    </div>
                    
                    <div class="custom-start-btn pt-1">
                        <button class="custom-btn"><?= get_phrase('search_course'); ?></button>
                    </div>
                </form>
                <!-- <div class="mt-2">Or</div> -->
            </div>
        </div>
        <div class="col-sm-7 text-center">
            <img class="img-fluid" src="<?= site_url('assets/frontend/default/img/digital.png'); ?>">
        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3 home-fact-area">
       <div class="container-lg complete_padding pb-3">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center mb-1">
                    <h3><?= get_phrase('partners'); ?></h3>
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 text-center">
                <div class="row text-center">
                    <?php for ($i=0; $i < 6; $i++): ?>
                        <?php if (!file_exists('uploads/partners/partner'.($i + 1).'.jpg')): ?>
                        <?php else: ?>
                            <div class="col-sm-5 col-lg-2 col-md-2 col-xs-5 col-xl-2 d-flex text-center">
                                <img class="mb-3 img-fluid" src="<?= site_url('uploads/partners/partner'.($i + 1).'.jpg'); ?>">
                            </div>
                        <?php endif; ?>
                        
                    <?php endfor; ?>
                </div>
            </div>
        </div> 
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-4">
        <div class="container-lg complete_padding">
            <div class="row">
                <?php if(count($top_courses) > 0): ?>
                    <div class="col-md-3"><h3>Top courses</h3></div>
                    <div class="col-md-4 pt-4">Here are the top selling courses in harmony business school.</div>
                    <div class="col-md-4"></div>
                    <div class="col-md-1">
                        <img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="30">
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <div class="">
                    <?php // for ($i = 0 ; $i < count($top_courses); $i + 4): ?>

                    <?php // endfor; ?>
                    <div id="myCarousel" class="mt-4 carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <?php foreach ($top_courses as $key => $course): ?>
                                <!-- <li data-target="#myCarousel" data-slide-to="<?= $key; ?>" class="<?php if($key < 4) echo 'active'; ?>"></li> -->
                            <?php endforeach; ?>
                        </ol>

                        <div class="row">
                            <div class="carousel-inner col-xs-12 col-md-12 col-lg-12 col-sm-12">
                                <?php for($i = 0 ; $i <= count($top_courses); $i = $i + 4): ?>
                                    <div class="item <?php if($i < 4) echo 'active'; ?>">
                                        <?php for($k = $i; $k < ($i + 4); $k++): ?>
                                            <?php if($k < count($top_courses)): ?>
                                                <?php $course = $top_courses[$k]; ?>
                                                <div class="col-md-3 col-xs-12 col-md-3 col-lg-3 col-sm-3">
                                                    <div class="course-section">
                                                        <img src="<?php echo $this->crud_model->get_course_thumbnail_url($course['id']); ?>" class="img-fluid" />
                                                        <div class="course-amt">
                                                            <a href="<?php echo site_url('home/course/'.slugify($course['title']).'/'.$course['id']); ?>">View Course</a>
                                                        </div>
                                                        <div class="course-section-description">
                                                            <div>
                                                                <span class="second-span"><?= $course['title']; ?></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <div class="mt-3 mb-1">
                            <!-- <div class="row" style="height: 50px; display: block; position: absolute; right: 20px;">
                                <div class="circle-tab">
                                    <a class="left" href="#myCarousel" data-slide="prev">
                                        <div class="cicle-prev">
                                            <i class="fas fa-chevron-left"></i>
                                        </div>
                                    </a>
                                    <a class="right" href="#myCarousel" data-slide="next">
                                        <div class="cicle-next">
                                            <i class="fas fa-chevron-right"></i>
                                        </div>
                                    </a>
                                </div>
                            </div> -->
                        </div><br><br>
                    </div>
               </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3">
        <div class="container-lg complete_padding">
            <div class="row">
                <div class="col-md-11 col-sm-11 col-xs-11"><h3>Features</h3></div>
                <div class="col-sm-1 col-md-1 col-xs-1 text-right">
                    <img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="30">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-4 col-lg-4 col-md-4 col-xs-4 col-xl-4 d-flex">
                    <div class="row col-xl-12 col-md-12">
                        <div class="col-md-3">
                            <object data="<?= base_url('assets/frontend/default/svg/trophy.svg'); ?>" width="40" height="47"> </object>
                        </div>
                        <div class="col-md-7">
                            <div class="feature_tittle">High Quality</div>
                            <div class="feature_desc">Top notch courses</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4 col-md-4 col-xs-4 col-xl-4 d-flex">
                    <div class="row col-xl-12 col-md-12">
                        <div class="col-md-3">
                            <object data="<?= base_url('assets/frontend/default/svg/guarantee.svg'); ?>" width="40" height="47"> </object>
                        </div>
                        <div class="col-md-7">
                            <div class="feature_tittle">Certification</div>
                            <div class="feature_desc">Top notch certification</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4 col-lg-4 col-md-4 col-xs-4 col-xl-4 d-flex">
                    <div class="row col-xl-12 col-md-12">
                        <div class="col-md-3">
                            <object data="<?= base_url('assets/frontend/default/svg/customer-support.svg'); ?>" width="40" height="47"> </object>
                        </div>
                        <div class="col-md-7">
                            <div class="feature_tittle">24 / 7 Support</div>
                            <div class="feature_desc">Dedicated support</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3 home-fact-area">
        <div class="container-lg complete_padding big-card">
            <div class="row mt-4">
                <div class="col-md-6">
                    <object data="<?= base_url('assets/frontend/default/svg/image_smile.svg'); ?>" width="374" height="350" class="img-responsive"> </object>
                </div>
                <div class="col-md-6">
                    <h1><strong><?= get_phrase('become'); ?></strong></h1>
                    <h1 class="primary-color"><strong><?= get_phrase('an_instructor'); ?></strong></h1>
                    <div>
                        <?= get_frontend_settings('banner_instructor_text'); ?>
                    </div>
                    <div class="mt-3">
                        <div class="custom-become-btn pt-1">
                            <button class="custom-btn" onclick="javascript:window.location.href = '<?= site_url('home/instructor'); ?>';"><?= get_phrase('apply_now'); ?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12">
        <div class="container-lg complete_padding">
            <div class="row header-tag">
                <?php if(count($top_selling_courses) > 0): ?>
                    <div class="col-md-3 col-sm-3"><h3>Top Selling courses</h3></div>
                    <div class="col-md-8 col-sm-8 pt-4">Here are the top Course in harmony business school.</div>
                    <div class="col-md-1 col-sm-1 text-right">
                        <img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="30">
                    </div>
                <?php endif; ?>
            </div>
            <div id="myCarousel" class="mt-4 carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <!-- <li data-target="#myCarousel" data-slide-to="0" class="active"></li> -->
                  <!-- <li data-target="#myCarousel" data-slide-to="1"></li> -->
                  <!-- <li data-target="#myCarousel" data-slide-to="2"></li> -->
                </ol>
                <!-- top_selling_courses  -->

                <div class="row">
                    <div class="carousel-inner col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <?php for($i = 0 ; $i <= count($top_selling_courses); $i = $i + 3): ?>
                            <div class="item <?php if($i < 3) echo 'active'; ?>">
                                <?php for($k = $i; $k < ($i + 3); $k++): ?>
                                    <?php if($k < count($top_selling_courses)): ?>
                                        <?php 
                                            $db_bought_course = $top_selling_courses[$k];
                                            $course = $this->crud_model->get_course_by_id($db_bought_course['course_id'])->row_array();
                                        ?>
                                        <div class="col-md-4 col-xs-12 col-md-4 col-lg-4 col-sm-4">
                                            <div class="latest-post">
                                                <div class="latest-post-media">
                                                   <a href="<?= site_url('home/course/'.slugify($course['title']).'/'.$course['id']); ?>" class="latest-post-img">
                                                   <img class="img-responsive" src="<?= $this->crud_model->get_course_thumbnail_url($course['id']); ?>" alt="img">
                                                   </a>
                                                </div>
                                                <div class="post-body">
                                                   <h4 class="post-title">
                                                      <?= $course['title']; ?>
                                                   </h4>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="mt-3 mb-1">
                    <div class="row" style="height: 50px; display: block; position: absolute; right: 20px;">
                        <div class="circle-tab">
                            <a class="left" href="#myCarousel" data-slide="prev">
                                <div class="cicle-prev">
                                    <i class="fas fa-chevron-left"></i>
                                </div>
                            </a>
                            <a class="right" href="#myCarousel" data-slide="next">
                                <div class="cicle-next">
                                    <i class="fas fa-chevron-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div><br><br>
            </div>

        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3">
        <div class="container-lg complete_padding">
            <div class="row">
                <div class="col-md-11"><h3><?= get_phrase('our_category'); ?></h3></div>
                <div class="col-md-1">
                    <img src="<?php echo base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="30">
                </div>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3">
                <div class="row">
                    <div class="col-md-4"> 
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/vector_cat1.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Executive<br>Courses <? // get_phrase('_courses'); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('executive_training_course')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/social-media.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Regular<br>Training <? // get_phrase(''); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('regular_training')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4"> 
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/social-media.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Professional<br>Courses<? get_phrase(''); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('professional_courses')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/web-development.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Professional<br>Diplomas<? get_phrase(''); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('professional_diplomas')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/briefcase.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Vocational<br>Courses<? get_phrase('vocational_courses'); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('vocational_courses')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="cat-card">
                            <object data="<?= base_url('assets/frontend/default/svg/vector_cat1.svg'); ?>" width="90" height="150"> </object>
                            <div class="desc">
                                <div><h6>Affiliated<br>Courses <? // get_phrase('_courses'); ?></h6></div>
                                <div class="text-mini"><?= count($this->crud_model->get_course_category_count('affiliated_courses')); ?> courses</div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-3 home-fact-area">
        <div class="container-lg complete_padding text-center">
            <div class="">
                <img src="<?= base_url().'uploads/system/logo-dark.png'; ?>" alt="" height="30">
            </div>
            <div class="">
                <h2 class="text-bold">Learn from the best online digital</h2>
                <h2 class="text-bold"><strong class="primary-color">business</strong> school.</h2>
                <div class="mt-3">
                    <div class="custom-become-btn pt-1">
                        <button class="custom-btn" onclick="javascript:window.location.href = '<?= site_url('home/sign_up'); ?>'"><?= get_phrase('get_started'); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-4 mb-4">
        <div class="container-lg complete_padding mb-3 pb-3">
            <div class="row col-md-12">
                <div class="col-md-6">
                    <h1 class="text-bold">
                        Trusted by <span class="primary-color">15,000+</span> happy students around the World
                    </h1>
                </div>
                <div class="col-md-3">
                    <div>
                        <h1 class="text-bold">15k+</h1>
                    </div>
                    <div>
                        <i class="fas fa-heart text-love"></i>
                        <i class="fas fa-heart text-love"></i>
                        <i class="fas fa-heart text-love"></i>
                        <i class="fas fa-heart text-love"></i>
                        <i class="fas fa-heart text-love"></i>
                    </div>
                    <div>
                        <?= get_phrase('users'); ?>
                    </div>
                </div>
                <div class="col-md-3">
                    <div>
                        <h1 class="text-bold"><strong>4.7</strong></h1>
                    </div>
                    <div>
                        <i class="far fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                        <i class="far fa-star text-warning"></i>
                    </div>
                    <div>
                        <?= get_phrase('rating'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if(count($top_activities) > 0): ?>
    <section>
        <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 col-xl-12 mt-4 home-fact-area">
            <div class="container-lg complete_padding big-card">
                <div class="row col-md-12 mt-4">
                    <div class="col-md-6 mb-2">
                        <h1><strong><?= get_phrase('our'); ?></strong></h1>
                        <h1 class="primary-color"><strong><?= get_phrase('sessional_activities'); ?></strong></h1>
                        <h4><?= $top_activities['tittle']; ?></h4>
                        <div>
                            <?= htmlspecialchars_decode($top_activities['note']); ?>
                            <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin aliquet pellentesque aliquet. Maecenas lectus velit, malesuada id interdum et, maximus nec purus. Pellentesque finibus nunc luctus nisi imperdiet posuere. Vivamus a ex id nibh auctor vehicula ac et dui. Proin pharetra nibh sapien, id ullamcorper nisl commodo vel. Vestibulum feugiat justo lorem, id vestibulum augue hendrerit a. Vivamus efficitur, ligula tincidunt finibus rhoncus, augue augue volutpat sapien, quis malesuada augue eros quis erat. Donec hendrerit dolor ac euismod condimentum. Aenean ut mattis lacus. -->
                        </div>
                        <div class="mt-3">
                            <div class="custom-become-btn pt-1">
                                <button onclick="javascript:window.location.href = '<?= site_url('home/activiities'); ?>'" class="custom-btn"><?= get_phrase('view_all'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <object data="<?= base_url('assets/frontend/default/svg/image_meeting.svg'); ?>" width="574" height="450"> </object>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php endif; ?>

<style>
    .cat-card {
        height: 220px;
        background-color: #E9F6FC;
        /*color: #031017;*/
        padding: 22px 35px;
        margin: 10px 0;
    }
    .cat-card object {
        /*float: right;
        top: 34px;
        right: 40px;
        position: initial;*/
        float: right;
        top: 42px;
        right: 71px;
        position: absolute;
    }
    .circle-tab {
        display: inline-flex;
        /*padding: 0 33px;*/
    }
    .cicle-prev {
        background-color: #BAD0FB;
        color: #258AFF;
        margin-right: 5px;
    }
    .cicle-next {
        background-color: #4285F4;
        color: #FFF;
        margin-right: 5px;
    }
    .cicle-prev, .cicle-next {
        height: 40px;
        width: 40px;
        line-height: 41px;
        text-align: center;
        font-size: 1.1em;
        border-radius: 100%;
    }
    .text-love {
        color: #FF523D;
    }
    h2.text-bold {
        font-weight: 900;
        font-size: 2.0em;
    }
    h1.text-bold {
        font-weight: 900;
    }
    .cat-card .desc {
        top: 70px;
        left: -2px;
        /*font-size: 1.39;*/
        position: relative;
        line-height: 10px;
    }
    .cat-card .desc h6 {
        font-size: 1.6em;
        font-weight: 900;
    }
    .cat-card .desc .text-mini {
        color: #258AFF;
        font-size: 0.81em;
    }
    .header-tittle-sec {
        color: #fff;
    }
    .latest-post img {
        width: 100%;
        height: 290px;
    }
    .sub-hash {
        color: #253757;
    }
    @media screen and (min-width: 1024px){
        .complete_padding {
            padding-right: 10%;
            padding-left: 10%;
        }
    }
    @media screen and (max-width: 425px) {
        .cat-card object {
            float: none;
            top: initial;
            right: initial;
            position: initial;
            display: block;
            margin: 0 auto;
        }
        .cat-card .desc {
            top: -24px;
            left: 0;
            position: relative;
            line-height: 0px;
            margin: 0 auto;
            text-align: center;
        }
        .cat-card .desc h3 {
            font-size: 1.45em;
        }
        .big-card object {
            height: 200px;
            width: auto;
            display: block;
            text-align: center;
            margin: 0 auto;
        }
        .header-tag img {
            display: none;
        }
    }
    /*.latest-post {

    }*/
    .latest-post .post-body .post-title {
        font-size: 0.87em;
        line-height: 40px;
        font-weight: 800;
    }
    .latest-post .post-body .post-title {

    }
    .feature_tittle {
        color: #3A3A3A;
        font-family: Lato;
        font-style: normal;
        font-weight: bold;
        font-size: 0.88em;
    }
    .feature_desc {
        color: #898989;
        font-family: Lato;
        font-style: normal;
        font-weight: 300;
        font-size: 0.88em;
    }
    /*.home-banner-wrap .btn{
        padding: 10px 14px;
        font-size: 20px;
        height: 43px;
        background: #fff;
        border-top-right-radius: 0;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
        color: #563d7c;
        border-top: 1px solid #1D293F;
        border-left: 1px solid #1D293F;
        border-bottom: 1px solid #1D293F;
    }*/
    a.register-button{
       height: 40px;
       text-align: center;
       background-color: #563d7c;
       border-radius: 5px;
       width: 100px;
       line-height: 34px;
       color: #fff;
       padding: 14px 28px;
    }
    .header-sep {
        border: 1px solid #2B5841; 
        padding: 0;
        width: 100px;
        text-align: center;
        margin: 19px auto;
    }
    .header-sep-sec{
        border: 1px solid #FFF;
        padding: 0;
        width: 100px;
        text-align: center;
        margin: 19px auto;
    }
    .content-section-1 {
        /* background-color: #6d7e88; */
        font-weight: 600;
        padding: 60px;
        /* color: #fff; */
        border-radius: 5px;
        box-shadow: 0px 0px 12px rgba(0,0,0,0.2);
        min-height: 600px;
        transition: .4s ease-in-out;
    }
    .content-section-1:hover, .content-section:hover{
        box-shadow: 0px 0px 26px rgba(0,0,0,0.2);
        transition: .4s ease-in-out;
    }
    .content-section{
        background-color: #2B5841;
        font-weight: 600;
        padding: 60px;
        color: #fff;
        min-height: 600px;
        border-radius: 5px;
        transition: .4s ease-in-out;
    }
    .course-section{
        /*box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.12);*/
        margin: 10px 0;
        padding: 0 0 10px 0;
    }
    .course-section img{
        height: 184px;
        width: 100%;
        object-fit: cover;
    }
    .course-section .course-section-description{
        margin-top: 10px;
        text-align: center;
        /*padding: 25px;*/
        min-height: 48px;
    }
    .course-section .course-section-description .first-span{
        color: #2B5841;
        display: block;
        font-size: 17px;
        font-weight: 600;
        font-weight: bolder;
    }
    .course-section .course-section-description .second-span{
        display: block;
        font-size: 14px;
        font-weight: 600;
    }
    .course-amt a{
        display: block;
        height: 36px;
        /* width: 100%; */
        text-align: center;
        line-height: 34px;
        background-color: #258AFF;
        /*border-radius: 4px;*/
        font-size: 0.9em;
        color: #ffffff;
        font-weight: 800;
    }
    .bg-dark-light{
        background-color: #f0f0f1 !important;
    }
    .author_desc{
        font-size: 0.91em;
        margin-bottom: .2rem; */
        font-family: inherit;
        font-weight: 500;
        line-height: 1.2;
        color: inherit;
    }
    @media screen and (max-width: 760px){
        .content-section-1, .content-section{
            padding: 60px 20px;
        }
    }
    @media (min-width: 576px){
        .modal-dialog {
            max-width: 620px;
        }
    }
    .modal-body-item{
        width: 100%;
        margin: 0 auto;
    }
    .modal-body-item img {
        width: 99%;
    }
    .testimonial.carousel {
        /*width: 650px;*/
        margin: 0 auto;
        padding-bottom: 50px;
    }
    .testimonial.carousel .item {
        color: #999;
        font-size: 14px;
        text-align: center;
        overflow: hidden;
        min-height: 340px;
        margin: auto;
    }
    .testimonial.carousel .item a {
        color: #eb7245;
    }
    .testimonial.carousel .img-box {
        width: 74%;
        height: 100%;
        margin: 0 auto;
        border-radius: 50%;
    }
    .testimonial.carousel .img-box img { 
        width: 97%;
        height: 97%;
        display: block;
        box-shadow: 0px 6px 7px 1px rgba(0,0,0,0.22);
        border-radius: 4px;
        /*padding: 5px 0;*/
    }
    .testimonial.carousel .testimonial {    
        padding: 30px 0 10px;
    }
    .testimonial.carousel .overview {   
        text-align: center;
        padding-bottom: 5px;
    }
    .testimonial.carousel .overview b {
        margin-top: 33px;
        color: #333;
        font-size: 15px;
        text-transform: uppercase;
        display: block; 
        padding-bottom: 5px;
    }
    .testimonial.carousel .star-rating i {
        font-size: 18px;
        color: #ffdc12;
    }
    .testimonial.carousel .carousel-control {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #999;
        text-shadow: none;
        top: 4px;
    }
    .testimonial.carousel-control i {
        font-size: 20px;
        margin-right: 2px;
    }
    .testimonial.carousel-control.left {
        left: auto;
        right: 40px;
    }
    .testimonial.carousel-control.right i {
        margin-right: -2px;
    }
    .testimonial.carousel .carousel-indicators {
        bottom: 15px;
    }
    .testimonial.carousel-indicators li, .carousel-indicators li.active {
        /*width: 11px;*/
        /*height: 11px;*/
        margin: 1px 5px;
        /*border-radius: 50%;*/
    }
    .testimonial.carousel-indicators li {   
        background: #e2e2e2;
        border-color: transparent;
    }
    .testimonial.carousel-indicators li.active {
        border: none;
        background: #888;       
    }
    @media screen and (min-width: 768px){
        .testimonial.carousel {
            width: 80%;
        }
        .testimonial.carousel .carousel-control{
            top: 30%;
        }
        .testimonial.carousel .img-box{
            width: 55%;
            height: 70%;
        }
    }
    .authors_span-area img{
        height: 300px;
        width: 263px;
    }
    .pd-10{
        padding: 30px 0 0;
    }
</style>

<script type="text/javascript">
    $(document).ready(function(){
        // $('#myModal').modal('show');
    });

    function handleWishList(elem) {

        $.ajax({
            url: '<?php echo site_url('home/handleWishList');?>',
            type : 'POST',
            data : {course_id : elem.id},
            success: function(response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }else {
                    if ($(elem).hasClass('active')) {
                        $(elem).removeClass('active')
                    }else {
                        $(elem).addClass('active')
                    }
                    $('#wishlist_items').html(response);
                }
            }
        });
    }

    function handleCartItems(elem) {
        url1 = '<?php echo site_url('home/handleCartItems');?>';
        url2 = '<?php echo site_url('home/refreshWishList');?>';
        $.ajax({
            url: url1,
            type : 'POST',
            data : {course_id : elem.id},
            success: function(response)
            {
                $('#cart_items').html(response);
                if ($(elem).hasClass('addedToCart')) {
                    $('.big-cart-button-'+elem.id).removeClass('addedToCart')
                    $('.big-cart-button-'+elem.id).text("<?php echo get_phrase('add_to_cart'); ?>");
                }else {
                    $('.big-cart-button-'+elem.id).addClass('addedToCart')
                    $('.big-cart-button-'+elem.id).text("<?php echo get_phrase('added_to_cart'); ?>");
                }
                $.ajax({
                    url: url2,
                    type : 'POST',
                    success: function(response)
                    {
                        $('#wishlist_items').html(response);
                    }
                });
            }
        });
    }

    function handleEnrolledButton() {
        $.ajax({
            url: '<?php echo site_url('home/isLoggedIn');?>',
            success: function(response)
            {
                if (!response) {
                    window.location.replace("<?php echo site_url('login'); ?>");
                }
            }
        });
    }
</script>
