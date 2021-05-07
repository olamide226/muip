<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaystackController extends Controller
{

        public function __construct()
    {
        $this->middleware('auth');
    }


    public function mail()
    {
    	// include 'mail.php';
    	return view('mail');
    }
    public function pay(Request $request){

    	$curl = curl_init();
		$email = $request->user()->email;
		$referral = $request->user()->referral;
		$sub_account = DB::select("SELECT subaccount_code from users where email = ? LIMIT 1",[$referral]);
		$amount = 300000;  //the amount in kobo. This value is actually NGN 3000.00
        $my_json = json_encode([
            'amount' => $amount,
            'email' => $email
        ]);
        //if there's a subaccount then add it to the API
        if ($sub_account){
            if (!empty($sub_account[0]->subaccount_code)) {
                $my_json = json_encode([
                    'amount' => $amount,
                    'email' => $email,
                    'subaccount' => $sub_account[0]->subaccount_code
                ]);
            }
        }

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.paystack.co/transaction/initialize",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $my_json,
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

		if(!$tranx['status']){
		  // there was an error from the API
		  print_r('API returned error: ' . $tranx['message']);
		}

		// comment out this line if you want to redirect the user to the payment page
		// print_r($tranx);


		// redirect to page so User can pay
		// uncomment this line to allow the user redirect to the payment page
		// header('Location: ' . $tranx['data']['authorization_url']);
		return redirect()->away($tranx['data']['authorization_url']);

    	// return view('paystack.pay')->withUser($user);
    }

    public function callback(Request $request)
    {
    	// $redirection = olabt0rfzc $_SERVER['REQUEST_SCHEME']. '://' .$_SERVER['HTTP_HOST'] ;

		$curl = curl_init();
		$reference = $request->has('reference') ? $request->reference : '';
		if(!$reference){
		  die('No reference supplied');
		}

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://api.paystack.co/transaction/verify/" . rawurlencode($reference),
	    CURLOPT_RETURNTRANSFER => true,
		CURLOPT_HTTPHEADER => [
		    "accept: application/json",
		    "authorization: Bearer sk_test_d19851b5f833a45351489a7755a85a3b793b915d",
		    "cache-control: no-cache"
		  ],
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		if($err){
		    // there was an error contacting the Paystack API
		  die('Curl returned error: ' . $err);
		}

		$tranx = json_decode($response);

		if(!$tranx->status){
		  // there was an error from the API
		  die('API returned error: ' . $tranx->message);
		}

		if('success' == $tranx->data->status){
            include "helper.php";
            $user_email = $request->user()->email;
            $user_bank = $request->user()->bank_code;
            $user_nuban = $request->user()->nuban;
            $user_name = $request->user()->name;

            $subAccount = createSubAccount($user_bank, $user_nuban, $user_email, $user_name);
            if ($subAccount['status']){
                $saveSubAccount = DB::update("UPDATE `users` SET subaccount_code = ?, acct_status = ?  where `email` = ?",
                    [$subAccount['data']['subaccount_code'], $subAccount['data']['active'], $user_email ]);
                if ($saveSubAccount) session(['sub_status', 'success']);
            }else{
                session(['sub_status', $subAccount['message']]);
            }


		  $verify = DB::update("UPDATE `users` SET `user_status` = 'V' where `email` = ?", [$user_email]);

		  $ref_link = route('register') . '?ref='. $user_email;
		  include 'mail.php';
		   session(['checks',$checks]);

		  return  redirect('home')->with('status', 'success');
		  // transaction was successful...
		  // please check other things like whether you already gave value for this ref
		  // if the email matches the customer who owns the product etc
		  // Give value
		}
	}



}
