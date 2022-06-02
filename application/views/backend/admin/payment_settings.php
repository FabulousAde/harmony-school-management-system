<?php
// $paypal_settings = $this->db->get_where('settings', array('key' => 'paypal'))->row()->value;
// $paypal = json_decode($paypal_settings);
$paystack_settings = $this->db->get_where('settings', array('key' => 'paystack_keys'))->row()->value;
$paystack = json_decode($paystack_settings);
$stripe_settings = $this->db->get_where('settings', array('key' => 'stripe_keys'))->row()->value;
$stripe = json_decode($stripe_settings);
?>
<!-- start page title -->
<div class="row ">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <h4 class="page-title"> <i class="mdi mdi-apple-keyboard-command title_icon"></i> <?php echo get_phrase('setup_payment_informations'); ?></h4>
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div>

<div class="row">
    <div class="col-md-7" style="padding: 0;">
        <!-- System Currency Settings -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title"><p><?php echo get_phrase('system_currency_settings'); ?></p></h4>
                    <form class="" action="<?php echo site_url('admin/payment_settings/system_currency'); ?>" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label><?php echo get_phrase('system_currency'); ?></label>
                            <select class="form-control select2" data-toggle="select2" id = "system_currency" name="system_currency" required>
                                <option value=""><?php echo get_phrase('select_system_currency'); ?></option>
                                <?php
                                $currencies = $this->crud_model->get_currencies();
                                foreach ($currencies as $currency):?>
                                <option value="<?php echo $currency['code'];?>"
                                    <?php if (get_settings('system_currency') == $currency['code'])echo 'selected';?>> <?php echo $currency['code'];?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('currency_position'); ?></label>
                        <select class="form-control select2" data-toggle="select2" id = "currency_position" name="currency_position" required>
                            <option value="left" <?php if (get_settings('currency_position') == 'left') echo 'selected';?> ><?php echo get_phrase('left'); ?></option>
                            <option value="right" <?php if (get_settings('currency_position') == 'right') echo 'selected';?> ><?php echo get_phrase('right'); ?></option>
                            <option value="left-space" <?php if (get_settings('currency_position') == 'left-space') echo 'selected';?> ><?php echo get_phrase('left_with_a_space'); ?></option>
                            <option value="right-space" <?php if (get_settings('currency_position') == 'right-space') echo 'selected';?> ><?php echo get_phrase('right_with_a_space'); ?></option>
                        </select>
                    </div>

                    <div class="row justify-content-md-center">
                        <div class="form-group col-md-6">
                            <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_system_currency'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><p><?php echo get_phrase('setup_paypal_settings'); ?></p></h4>
                <form class="" action="<?php echo site_url('admin/payment_settings/paypal_settings'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><?php echo get_phrase('active'); ?></label>
                        <select class="form-control select2" data-toggle="select2" id = "paypal_active" name="paypal_active">
                            <option value="0" <?php if ($paypal[0]->active == 0) echo 'selected';?>> <?php echo get_phrase('no');?></option>
                            <option value="1" <?php if ($paypal[0]->active == 1) echo 'selected';?>> <?php echo get_phrase('yes');?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('mode'); ?></label>
                        <select class="form-control select2" data-toggle="select2" id = "paypal_mode" name="paypal_mode">
                            <option value="sandbox" <?php if ($paypal[0]->mode == 'sandbox') echo 'selected';?>> <?php echo get_phrase('sandbox');?></option>
                            <option value="production" <?php if ($paypal[0]->mode == 'production') echo 'selected';?>> <?php echo get_phrase('production');?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('paypal_currency'); ?></label>
                        <select class="form-control select2" data-toggle="select2" id = "paypal_currency" name="paypal_currency" required>
                            <option value=""><?php echo get_phrase('select_paypal_currency'); ?></option>
                            <?php
                            $currencies = $this->crud_model->get_paypal_supported_currencies();
                            foreach ($currencies as $currency):?>
                            <option value="<?php echo $currency['code'];?>"
                                <?php if (get_settings('paypal_currency') == $currency['code'])echo 'selected';?>> <?php echo $currency['code'];?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('client_id').' ('.get_phrase('sandbox').')'; ?></label>
                    <input type="text" name="sandbox_client_id" class="form-control" value="<?php echo $paypal[0]->sandbox_client_id;?>" required />
                </div>

                <div class="form-group">
                    <label><?php echo get_phrase('client_id').' ('.get_phrase('production').')'; ?></label>
                    <input type="text" name="production_client_id" class="form-control" value="<?php echo $paypal[0]->production_client_id;?>" required />
                </div>

                <div class="row justify-content-md-center">
                    <div class="form-group col-md-6">
                        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_paypal_keys'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div> -->

    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><p><?php echo get_phrase('setup_paystack_settings'); ?></p></h4>
                <form class="" action="<?php echo site_url('admin/payment_settings/paystack_settings'); ?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><?php echo get_phrase('active'); ?></label>
                        <select class="form-control select2" data-toggle="select2" id = "paystack_active" name="paystack_active">
                            <option value="0" <?php if ($paystack[0]->active == 0) echo 'selected';?>> <?php echo get_phrase('no');?></option>
                            <option value="1" <?php if ($paystack[0]->active == 1) echo 'selected';?>> <?php echo get_phrase('yes');?></option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label><?php echo get_phrase('paystack_live_key'); ?></label>
                        <input type="text" name="paystack_live_key" class="form-control" value="<?php echo $paystack[0]->paystack_live_key;?>" required />
                    </div>

                <div class="row justify-content-md-center">
                    <div class="form-group col-md-6">
                        <button class="btn btn-block btn-primary" type="submit"><?php echo get_phrase('update_paystack_keys'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- </div> -->
</div>
<div class="col-md-5">
    <div class="alert alert-info" role="alert">
        <h4 class="alert-heading"><?php echo get_phrase('heads_up'); ?>!</h4>
        <p><?php echo get_phrase('please_make_sure_that').' "'.get_phrase('system_currency').'", '.'"'.get_phrase('paypal_currency').'" and '.'"'.get_phrase('stripe_currency').'" '.get_phrase('are_same'); ?>.</p>
    </div>
</div>
</div>
