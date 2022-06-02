<?php
$activities = $all_activities->row_array();
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
                    <li><a href=""><?php echo get_phrase('user_profile'); ?></a></li>
                    <li><a href="<?php echo site_url('home/my_results'); ?>"><?php echo get_phrase('my_certificates'); ?></a></li>
                    <!-- <li class="active"><a href="<?php // echo site_url('home/activiities'); ?>"><?php echo get_phrase('activities'); ?></a></li> -->
                    <?php if(get_settings('use_past_question') == '1'): ?>
                        <li><a href="<?php echo site_url('home/pastquestion'); ?>"><?php echo get_phrase('past_question'); ?></a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="category-course-list-area">
    <div class="container">
        <div class="row">
            <div class="col category-course-list" style="padding: 35px;">
                <ul>
                    <?php
                        if($all_activities->num_rows() < 1):
                    ?>
                    <div class="col-md-12">
                        <div class="card mg-10">
                            <div class="card-body">
                                <div class="text-center"><?php echo get_phrase("no_activity_available"); ?></div>
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                        else:
                    ?>
                     <div class="col-md-12 col-sm-12 col-lg-12">
                         <div class="">
                                <div class="card p-4 p-3 col-sm-12">
                                    <div class="col-sm-12">
                                        <strong class="h4 strong box-tittle">
                                            <?php echo $activities['tittle']; ?>
                                        </strong>
                                    </div><br>
                                    <div class="col-sm-12">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("description").": </span>"; ?>
                                            <?php echo $activities['note']; ?>
                                        </strong>
                                    </div>
                                    <div class="col-sm-12">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("session").": </span>".$activities['activity_year'];?>
                                        </strong>
                                    </div>
                                    <div class="col-sm-12">
                                        <strong class="h6">
                                            <?php echo "<span style='font-weight: bold;'>".get_phrase("media").": </span>"; ?>
                                            <?php echo '<a href="'.site_url().''.$activities['reource_loc'].'">link</a>'; ?>
                                        </strong>
                                    </div>
                                </div>
                            </div>
                     </div>
                    <?php
                        endif;
                    ?>
                </ul> 
            </div>
        </div>
    </div>
</section>
<style>
    .p-3{
        padding: 20px 30px;
    }
</style>