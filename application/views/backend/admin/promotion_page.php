<style>
    table, .table-responsive-sm {
        overflow-x: scroll;
    }
    /*.table td {*/
        /*padding: .80em;*/
    /*}*/
</style>
<?php
$all_users = $users->result_array();
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
            </div>
            </h4>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                
                <form class="row" action="<?php echo site_url('admin/user_form/promote'); ?>" method="get">
                    <div class="col-xl-3">
                            <div class="form-group">
                                <label for="main_category"><?php echo get_phrase('categories'); ?></label>
                                <select class="form-control select2" data-toggle="select2" name="main_category" id="main_category">
                                    <option value="<?php echo 'all'; ?>" <?php if($main_category == 'all') echo 'selected'; ?>><?php echo get_phrase('all'); ?></option>
                                    <?php
                                    foreach($categories as $key => $cat):
                                        $current_phrase = $cat['name'];
                                    ?>
                                    <option value="<?php echo underscore($cat['name']); ?>" <?php if($main_category == underscore($cat['name'])) echo 'selected'; ?>><?php echo $cat['name']; ?></option>
                                    <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                <div class="col-xl-2">
                    <label for=".." class="text-white"><?php echo get_phrase('..'); ?></label>
                    <button type="submit" class="btn btn-primary btn-block" name="button"><?php echo get_phrase('filter'); ?></button>
                </div>
            </form>
                
                
                <div class="table-responsive-sm mt-4">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>Photo</td>
                                <td>Email</td>
                                <td>Full name</td>
                                <?php foreach($categories as $key => $cat) : ?>
                                        <td><?php echo $cat['name']; ?></td>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 0; ?>
                            <?php foreach($all_users as $key => $users): ?>
                            <!--<?php ?>-->
                                <tr id="bitx_row_<?php echo $count; ?>">
                                    <td><?php echo $key+1; ?></td>
                                    <td>
                                        <div>
                                            <img src="<?php echo $this->user_model->get_user_image_url($users['id']);?>" alt="" height="50" width="50" class="img-fluid rounded-circle img-thumbnail">
                                        </div>
                                    </td>
                                    <td>
                                        <?php echo $users['email']; ?>
                                    </td>
                                    <td>
                                        <?php echo $users['last_name']; ?>
                                    </td>
                                    <?php
                                        $usr = $users['id'];
                                        foreach($categories as $key => $cat) : ?>
                                            <?php $cat_id = $cat['id']; ?>
                                            <td>
                                                <input type="radio" <?php if(underscore($cat['name']) == $users['class_options']) echo 'checked'; ?> onchange="changed(<?php echo $usr; ?>, <?php echo $cat_id; ?>, <?php echo $count; ?>)" name="<?php echo $count; ?>_marked" id="<?php echo $count; ?>_marked">
                                            </td>
                                    <?php
                                        endforeach;
                                    ?>
                                    
                                </tr>
                            <?php
                                $count++;
                                endforeach;
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function changed(uid, cid, key) {
        console.log({uid, cid});
        // var divinput = $('#'+divnumber+' input').val();
        $.ajax({
            url: '<?php echo site_url('admin/promotion_submit_ajax'); ?>',
            method: 'post',
            data: {uid, cid},
            dataType: 'json',
            success: function(response) {
                console.log(response);
                $('tr#bitx_row_'+key).css('background-color', '#21A59A');
            }
        });
    }
</script>