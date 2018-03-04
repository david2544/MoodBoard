<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
	function hook() {
		$req_dump = print_r($_POST, TRUE);
		$fp = fopen('request.log', 'a');
		fwrite($fp, $req_dump);
		fclose($fp);
	}
}
