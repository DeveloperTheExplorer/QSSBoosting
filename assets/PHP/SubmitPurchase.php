<?php
// Check for empty fields
if(empty($_POST['email'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
     echo "No arguments Provided!";
     return false;
   }

$email_address = strip_tags(htmlspecialchars($_POST['email']));
$message = strip_tags(htmlspecialchars($_POST['message']));
$credentials = strip_tags(htmlspecialchars($_POST['credentials']));
$rank = strip_tags(htmlspecialchars($_POST['rank']));
$soloDuo = strip_tags(htmlspecialchars($_POST['soloDuo']));
$server = strip_tags(htmlspecialchars($_POST['server']));
$boostType = strip_tags(htmlspecialchars($_POST['boostType']));
$desire = strip_tags(htmlspecialchars($_POST['desire']));
$cost = strip_tags(htmlspecialchars($_POST['cost']));

// Create the email and send the message
$to = 'qssboosting@gmail.com'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
$email_subject = "New Purchase Received!";
$email_body = "You have received a new boosting order from your website.\n\n"."Here are the details:\n\nEmail: $email_address\n\nAmount paid: \$$cost\n\nCurrent rank: $rank\n\nSolo/Duo: $soloDuo\n\nType of boost: $boostType\n\nDesired wins/rank: $desire\n\nServer: $server\n\nCredientials: $credentials\n\nSpecial instructions:\n$message";
$headers = "From: noreply@qssboosting.com\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
$headers .= "Reply-To: $email_address";
mail($to,$email_subject,$email_body,$headers);
echo 'success';
return true;
?>
