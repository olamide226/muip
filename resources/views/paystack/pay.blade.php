<?php
if(!isset($_COOKIE['emv-226'])) {
  die("Error occured");
}
$curl = curl_init();
//live token sk_live_a158626d85329edd2b41caa8f0d1d7eca61d2d07 sk_test_d19851b5f833a45351489a7755a85a3b793b915d
$email = $_COOKIE['emv-226'];
$amount = 300000;  //the amount in kobo. This value is actually NGN 3000.00

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'amount'=>$amount,
    'email'=>$email,
  ]),
  CURLOPT_HTTPHEADER => [
    "authorization: Bearer sk_test_d19851b5f833a45351489a7755a85a3b793b915d", //replace this with your own test key
    "content-type: application/json",
    "cache-control: no-cache"
  ],
));

$response = curl_exec($curl);
$err = curl_error($curl);

if($err){
  // there was an error contacting the Paystack API
  die('Curl returned error: ' . $err);
}

$tranx = json_decode($response, true);

if(!$tranx->status){
  // there was an error from the API
  print_r('API returned error: ' . $tranx['message']);
}

// comment out this line if you want to redirect the user to the payment page
// print_r($tranx);


// redirect to page so User can pay
// uncomment this line to allow the user redirect to the payment page
header('Location: ' . $tranx['data']['authorization_url']);
?>
