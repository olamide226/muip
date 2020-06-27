<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    
	public function getIndex()
	{
		$name = "Olamide ADebayo";
		return view('welcome')->withFullname($name); 
	}

	public function getRegister()
	{
		session(['ref' => 'olam']);
		return view('register');
	}

	public function postHelper(Request $request)
	{	
		if ($request->isMethod('post') && $request->has('req')) {

		include 'helper.php';

		switch ($request->req) {
		  // Invalid request
		  default:
		    echo "ERRor";
		    break;

		  case "fetch_banks":
		    getBanks();
		    break;

		  case "fetch_acct":
		    getAccount($_POST['code'], $_POST['acct']);
		    // echo "OK";
		    break;
		}
 
		}
		
		
	}

	public function postContact($value='')
	{
		# code...
	}



}