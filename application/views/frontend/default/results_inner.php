<?php
    $get_course_details = $this->crud_model->get_course_by_id($id)->row_array();
    if(count($get_course_details) > 0) {
        $course_id = $id;
        if (!file_exists('uploads/certs')) {
            mkdir('uploads/certs', 0777, true);
        }

        $config['source_image'] = 'uploads/system/hbs_certificate.png';
        $config['wm_text'] = $user['first_name'].' '.$user['last_name'];
        $config['wm_type'] = 'text';
        $config['new_image'] = 'uploads/certs/cert_'.$get_course_details['id'].'_'.$user['id'].'.png';
        $config['wm_font_path'] = 'uploads/system/fonts/Lato-Bold.ttf';
        $config['wm_font_size'] = '59';
        $config['wm_font_color'] = '153385';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'center';
        // $config['wm_padding'] = '-70';
        // $config['wm_vrt_alignment'] = 'top';
        // $config['wm_hor_alignment'] = 'left';
        // $config['wm_hor_offset'] = 200; // px
        $config['wm_vrt_offset'] = -160; // px
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();

        $config['source_image'] = 'uploads/certs/cert_'.$get_course_details['id'].'_'.$user['id'].'.png';
        $config['wm_text'] = $get_course_details['title'];
        $config['wm_type'] = 'text';
        $config['new_image'] = 'uploads/certs/cert_'.$get_course_details['id'].'_'.$user['id'].'.png';
        $config['wm_font_path'] = 'uploads/system/fonts/Lato-Regular.ttf';
        $config['wm_font_size'] = '30';
        $config['wm_font_color'] = '153385';
        $config['wm_vrt_alignment'] = 'middle';
        $config['wm_hor_alignment'] = 'center';
        // $config['wm_padding'] = '-70';
        // $config['wm_vrt_alignment'] = 'top';
        // $config['wm_hor_alignment'] = 'left';
        // $config['wm_hor_offset'] = 80; // px
        $config['wm_vrt_offset'] = 140; // px
        $this->image_lib->initialize($config);
        $this->image_lib->watermark();
    }
?>
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
                    <li class="active"><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_certificates'); ?></a></li>
                    <!-- <li><a href="<?php // echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li> -->
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container mt-3 mb-3">
        <img class="img-responsive" src="<?= site_url('uploads/certs/cert_'.$get_course_details['id'].'_'.$user['id'].'.png'); ?>">
    </div>
</section>

<style>
    img.image_session {
       height: 100px;
       width: auto;
    }
    .course-box-2 .course-image {
        width: 24%;
    }
    .print { float: right;  }
    a.back, a.print{
        border: 1px solid #F47A9C;
        padding: 8px 14px;
        border-radius: 20px;
    }
    a.back:hover, a.print:hover {
        background: linear-gradient(to right, #3F4551, #B6CCF3);
        color: #fff;
        transition: .4s ease-in-out;
        border: #fff;
    }
    @media screen and (min-width: 768px){
        img.image_session {
            height: 111px;
            width: auto;
            margin: 18px 0 0 57px;
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
        padding: 10px 0;
    }
    .pre-table td, th {
      border: 1px solid #dddddd;
      text-align: left;
      padding: 8px;
    }
    @media print {
       body {
           font-size: 10pt; line-height: 120%; background: white;
       }
       .card {
           /*margin: 110px 0;*/
           /*height: 842px;*/
       }
       .menu-area, .page-header-area, .footer-area {
           display: none;
       }
       .print_header, a.back, .print{
           display: none;
       }
    }
</style>