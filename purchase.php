<?php include 'assets/PHP/Checkout.php'; ?><!DOCTYPE html>
<html lang="en">
  <head>
    <title>QSSBoosting | Checkout</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="shortcut icon" href="assets/img/logo/logoAccentDark.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
  </head>
  <body>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script type="application/javascript" src="assets/js/jquery-ui/jquery-ui.js"></script>
    <script type="application/javascript" src="assets/js/jqBootstrapValidation.js"></script>
    <script type="application/javascript" src="assets/js/contact_me.js"></script>
    <title></title>
  </body>
  <body>
    <script src="https://www.paypal.com/sdk/js?client-id=ASKutvc6bYb6PJ2RTXRLjj0NftBRdsl4hJYaAHQX0nDrlRKfHH-kqyy67eUJHrqcwd6N86Xh9Oy9aj-t"></script>
    <script type="application/javascript">
      var isReady = true;
      let credentials;
        
      function validateTransaction() {
        let email = $('#emailPurchase').val();
        let message = $('#inquiryPurchase').val();
        let cost = <?php echo $finalPrice; ?>;
        let soloDuo = '<?php echo $soloDuo ?>';
        let rank = '<?php echo $currentRank." ".$currentDiv ?>';
        let server = '<?php echo $server ?>';
        let boostType = '<?php echo $displayBoost; ?>';
        if(soloDuo == 'Solo') {
          credentials = "Login Username: "+$('#loginPurchase').val()+" Login Password: "+$('#passPurchase').val();
        } else {
          credentials = "In game name: "+$('#usernamePurchase').val();
        }
        let desire = "";
        if(boostType == "Net Wins") {
          desire = <?php echo $numOfGames ?>;
        } else {
          desire = '<?php echo $wishRank." ".$wishDiv ?>';
        }
        $.ajax({
          url: "https://formcarry.com/s/EMCJs4AOmQa",
          type: "POST",
          data: {
            Email: email,
            Credentials: credentials,
            SoloDuo: soloDuo,
            Rank: rank,
            TypeOfBoost: boostType,
            Desire: desire,
            AmountPaid: cost,
            Server: server,
            Message: message
          },
          cache: false,
          success: function() {
            // Success message
            $('.row').html('<h1 style="color: #1AB188;" class="txt-center"><i class="fa fa-check-circle fa-3x"></i></h1><h2 class="txt-grey txt-center">Your order has been received! We will get back to you as soon as possible. Please join our discord channel to follow up with your order.</h2>');
          },
          error: function(jqXHR, textStatus, errorThrown) {
            //- Exception
            if(textStatus == "error") {
              $('.row').html('<h1 style="color: #1AB188;" class="txt-center"><i class="fa fa-check-circle fa-3x"></i></h1><h2 class="txt-grey txt-center">Your order has been received! We will get back to you as soon as possible. Please join our discord channel to follow up with your order.</h2>');
            } else {
              // Fail message
              $('.row').html('<h1 style="color: #e01e22;" class="txt-center"><i class="fa fa-exclamation-triangle fa-3x"></i></h1><h2 class="txt-grey txt-center">Your order has been received! There was an issue in our servers, please join our discord channel and let us know!</h2>');
            }
          }
        });
      }
      paypal.Buttons({
        createOrder: function(data, actions) {
          //- Setup the transaction
          $('.required').each(function() {
            if(this.value == "") {
              this.style.borderBottomColor = "red";
              isReady = false;
            }
          })
          if(!isReady){
            $('.forms').append('<div class="alert alert-danger col-xs-12"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Please fill in the required (*) forms.</div>');
            isReady = true;
            return
          }
          return actions.order.create({
            purchase_units: [{
              amount: {
                value: <?php echo $finalPrice; ?>
              }
            }]
          });
        },
        onApprove: function(data, actions) {
          //- Capture the funds from the transaction
          return actions.order.capture().then(function(details) {
            validateTransaction();
            //- Call your server to save the transaction
          });
        }
      }).render('.paypalButtonLocation');
      
    </script><a href="https://discord.gg/GEwcEag" target="_blank" class="discord"><span class="fab fa-discord"></span>DISCORD</a>
    <header class="relative">
      <div class="logo"><img src="assets/img/logo/qsslogoAccent.png" alt="logo"></div>
    </header>
    <div class="container">
      <h1 class="sm-mar-top txt-primary">Checkout</h1>
      <hr>
      <div class="row">
        <div class="col-xs-12 col-sm-push-6 col-sm-6">
          <h2 class="txt-primary">Cart</h2>
          <h2 class="sm-mar-top"> <span class="txt-stylish">Duo/Solo: </span><span class="txt-primary soloDuo"><?php echo $soloDuo; ?></span></h2>
          <h2 class="sm-mar-top"> <span class="txt-stylish">Current Rank: </span>
            <div class="checkoutRank"><?php echo $rankImg; ?></div>
          </h2>
          <h2 class="sm-mar-top"> <span class="txt-stylish">Boost Type: </span><span class="txt-primary"><?php echo $displayBoost; ?></span></h2><?php echo $wish; ?>
          <h2 class="sm-mar-top"> <span class="txt-stylish">Server: </span><span class="txt-primary"><?php echo $server; ?></span></h2>
          <h2 class="sm-mar-top"><span class="txt-stylish">Final Price: </span><span class="txt-primary">$<?php echo $finalPrice; ?></span></h2>
          <div class="paypalButtonLocation"></div>
        </div>
        <div class="col-xs-12 col-sm-pull-6 col-sm-6 forms">
          <h2 class="txt-primary">Billing</h2>
          <div class="tb-container sm-mar-top">
            <input id="emailPurchase" name="Email" type="text" placeholder=" " autocomplete="new-name" class="aumd-tb required txt-grey purchaseInputs">
            <label for="Email" class="aumd-tb-label">Email*</label><span class="validation"></span>
          </div><?php echo $forms; ?>
          <div class="tb-container sm-mar-top">
            <textarea id="inquiryPurchase" name="Text" type="text" placeholder="Special requests or instructions..." class="txt-grey purchaseInputs"></textarea>
          </div>
          <div class="tb-container sm-mar-top">
            <h3> <b>NOTE: </b>Please make sure the LoL account information for the inputs above are accurate.</h3>
          </div>
        </div>
      </div>
    </div>
    <!-- Start of Tawk.to Script-->
    <script type="text/javascript">
      var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
      (function(){
      var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
      s1.async=true;
      s1.src='https://embed.tawk.to/5d3b30009b94cd38bbe97e09/default';
      s1.charset='UTF-8';
      s1.setAttribute('crossorigin','*');
      s0.parentNode.insertBefore(s1,s0);
      })();
    </script>
    <!-- End of Tawk.to Script-->
  </body>
</html>