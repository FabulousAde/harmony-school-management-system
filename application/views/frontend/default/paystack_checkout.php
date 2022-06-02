<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Paystack</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="<?php echo base_url('assets/payment/css/stripe.css');?>" rel="stylesheet">
        <link name="favicon" type="image/x-icon" href="<?php echo base_url();?>uploads/system/favicon.png" rel="shortcut icon" />
    </head>
    <body>
<!--required for getting the stripe token-->
        <?php
            $paystack_keys = get_settings('paystack_keys');
            $values = json_decode($paystack_keys);
            $key = $values[0]->paystack_live_key;
            // if ($values[0]->testmode == 'on') {
            //     $public_key = $values[0]->public_key;
            //     $private_key = $values[0]->secret_key;
            // } else {
            //     $public_key = $values[0]->public_live_key;
            //     $private_key = $values[0]->secret_live_key;
            // }
        ?>

        <script>
            var stripe_key = '<?php echo $public_key;?>';
        </script>

<!--required for getting the stripe token-->

        <img src="<?php echo base_url().'uploads/system/logo-light.png'; ?>" width="15%;"
             style="opacity: 0.05;">
            <form onsubmit="return false;">
              <!-- <label>
                  <div id="card-element" class="field is-empty"></div>
                  <span><span><?php // echo get_phrase('credit_/_debit_card');?></span></span>
              </label> -->
              <button onclick="payWithPaystack('realosprog@gmail.com', '07015964428')">
                  <?php echo get_phrase('pay');?> <?php echo $amount_to_pay.' NGN';?>
              </button>
              <div class="package-details">
                  <strong><?php echo get_phrase('student_name');?> | <?php echo $user_details['first_name'].' '.$user_details['last_name'];?></strong> <br>
              </div>
          </form>
        <img src="<?= site_url('assets/frontend/default/img/Paystack-mark-white.png'); ?>" width="25%;" style="opacity: 0.05;">
        <script src="<?php echo base_url('assets/payment/js/stripe.js');?>"></script>
        <script src="https://js.paystack.co/v1/inline.js"></script>
        <script type="text/javascript">
            get_stripe_currency('<?php echo get_settings('stripe_currency'); ?>');
        </script>

    </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript">
  // var arr = {reference: "988101498", trans: "1131813037", status: "success", message: "Approved", transaction: "1131813037", trxref: "988101498"};
  // var arrParse = JSON.parse(arr);
  // console.log(arr.status);
  function payWithPaystack(e, p){
    console.log(e);
    console.log(p);
    var handler = PaystackPop.setup({
      key: '<?= $key; ?>',
      email: e,
      amount: <?=$amount_to_pay.'00'; ?>,
      currency: "NGN",
      ref: ''+Math.floor((Math.random() * 1000000000) + 1),
      metadata: {
         custom_fields: [
            {
                display_name: p,
                variable_name: p, 
                value: p
            }
         ]
      },
      callback: function(response){
          // alert('success');
          console.log(response);
          const ref = response.reference;
          // var res = JSON.parse(reference);
          // console.log();

          // $.ajax({
          //   type: "POST",
          //   url: '<?php //echo site_url("admin/change_question_status"); ?>',
          //   data: {status},
          //   dataType  : 'json',
          //   success: function (val) {
          //       console.log(val);
          //   },
          //   error: function (val) {
          //       console.log('error');
          //       console.log(val);
          //   }
          // });

          $.ajax({
             url: '<?php echo site_url('home/paystack_payment_success/'.$user_details['id'].'/'); ?>'+ref+'<?php echo '/'.$amount_to_pay; ?>'
          }).done(function () {
              window.location = '<?php echo site_url('home/shopping_cart');?>';
          });
          console,log('logged');
      },
      onClose: function(){
          alert('window closed');
      }
    });
    handler.openIframe();
  }
</script>