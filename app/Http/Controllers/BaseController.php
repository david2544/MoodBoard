<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
	function hook(Request $request) {
		$req_dump = print_r($request->all(), TRUE);
		$fp = fopen('request.log', 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
	}
	function dump() {
		 return file_get_contents('request.log');
	}
}
