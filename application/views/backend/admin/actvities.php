<?php
$activities = $all_activities->result_array();
?>
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?>
                    <a href="<?php echo site_url('admin/activities/new'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle"  style="margin-right: 10px;"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_new_activity'); ?></a>
                    <a href="<?php echo site_url('admin/activities/add_resources'); ?>" class="btn btn-outline-primary btn-rounded alignToTitle" style="margin-right: 10px;"><i class="mdi mdi-plus"></i><?php echo get_phrase('add_activities_resourse'); ?></a>
                </h4>
        
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive-sm mt-4 card p-3">
                    <table id="basic-datatable" class="table table-striped table-centered mb-0">
                        <thead>
                            <tr>
                                <td>#</td>
                                <td>tittle</td>
                                <td><?php echo get_phrase('year'); ?></td>
                                <td><?php echo get_phrase('is_top'); ?></td>
                                <td><?php echo get_phrase('actions'); ?></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($activities as $key => $activity): ?>
                                <tr class="card-body">
                                    <td><?php echo ++$key; ?></td>
                                    <td><?php echo $activity['tittle']; ?></td>
                                    <td><?php echo $activity['activity_year']; ?></td>
                                    <td>
                                        <input type="radio" name="is_top" value="$key" <?php if($activity['is_top'] == '1') echo "checked"; ?> onchange="changeTopActivity('<?= $activity['id']; ?>')">
                                    </td>
                                    <td>
                                        <div class="dropright dropright">
                                            <button type="button" class="btn btn-sm btn-outline-primary btn-rounded btn-icon" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="<?php echo site_url('admin/activities/edit/'.$activity['id']) ?>"><?php echo get_phrase('edit'); ?></a></li>
                                                <li><a class="dropdown-item" href="#" onclick="confirm_modal('<?php echo site_url('admin/activities/delete/'.$activity['id']); ?>');"><?php echo get_phrase('delete'); ?></a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>    
                    
                <div class="row ">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-body">
                                
                            </div> <!-- end card body-->
                        </div> <!-- end card -->
                    </div><!-- end col-->
                </div>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<script type="text/javascript">
    function changeTopActivity(keyRef) {
        console.log(keyRef);
        $.ajax({
          type: "POST",
          url: '<?php echo site_url("admin/change_top_activity"); ?>',
          data: {keyRef},
          dataType  : 'json',
          success: function (val) {
              console.log(val);
          },
          error: function (val) {
              console.log('error');
              console.log(val);
          }
        });
    }
</script>
