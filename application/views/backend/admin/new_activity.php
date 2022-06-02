<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-datetimepicker.css"> -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css"> 
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css"> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>
    
    
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo $page_title; ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-xl-12 col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="">
                    <form action="/admin/new_activities" method="post">
                        <div class="form-group">
                            <label for="activities_name"><?php echo get_phrase('activity_tittle'); ?></label>
                            <input type="text" class="form-control" id='activities_name' name="activities_name" required>
                        </div>
                        <div class="form-group">
                            <div class="">
                                    <label for="activities_name"><?php echo get_phrase('activity_resourses'); ?></label>
                                      <select class="form-control select2" data-toggle="select2" name="search_resources" id="search_resources" onchange="file_change(this.value)">
                                          <option value="0"><?php echo get_phrase('none'); ?></option>
                                          <?php foreach ($resources as $activityresources): ?>
                                                  <option value="<?php echo $activityresources['stored_location']; ?>"><?php echo $activityresources['file_name']; ?></option>
                                          <?php endforeach; ?>
                                      </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="activity_note"><?php echo get_phrase('activity_note'); ?></label>
                            <textarea name="activity_note" id = "activity_note" class="form-control" rows="5" required><?php echo get_phrase('enter_activity_note_here ...'); ?></textarea>
                        </div>
                        <div class="row col-sm-12">
                            <div class='row col-sm-3'>
                                <div class="form-group">
                                    <label for='year'><?php echo get_phrase('select_activity_year'); ?></label>
                                    <select class="form-control select2" data-toggle="select2" id = "year" name="year" required>
                                        <?php 
                                            $year = date('Y');
                                            for($i = date('Y'); $i > ($year- 5); $i--):
                                        ?>
                                            <option value="<?php echo $i."/".($i-1); ?>"> <?php echo $i."/".($i-1); ?> </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="session"><?php echo get_phrase('session'); ?></label>
                                    <select class="form-control select2" data-toggle="select2" id = "session" name="session" required>
                                        <option value="first"> <?php echo get_phrase('first_term');?></option>
                                        <option value="second"> <?php echo get_phrase('second_term');?></option>
                                        <option value="third"> <?php echo get_phrase('third_term');?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="session"><?php echo get_phrase('start_date'); ?></label>
                                    <div class='input-group date' id='datetimepicker1'>
                                        <input type="text" id="dpd1" name="dpd1" class="form-control date-selector" placeholder="&#xf073;" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="session"><?php echo get_phrase('end_date'); ?></label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type="text" id="dpd2" name="dpd2" class="form-control date-selector" placeholder="&#xf073;" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row justify-content-md-center">
                                <div class="form-group col-md-3 mt-4">
                                    <button type="submit" class="btn btn-block btn-primary">Upload</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function () {
    initSummerNote(['#activity_note']);
  });
  if(jQuery('#dpd1').length){
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
     
    var checkin = $('#dpd1').datepicker({
      onRender: function(date) {
        return date.valueOf() < now.valueOf() ? '' : '';
      }
    }).on('changeDate', function(ev) {
      if (ev.date.valueOf() > checkout.date.valueOf()) {
        var newDate = new Date(ev.date)
        newDate.setDate(newDate.getDate() + 1);
        checkout.setValue(newDate);
      }
      checkin.hide();
      $('#dpd2')[0].focus();
    }).data('datepicker');
    var checkout = $('#dpd2').datepicker({
      onRender: function(date) {
        return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
      }
    }).on('changeDate', function(ev) {
      checkout.hide();
    }).data('datepicker');
}
</script>