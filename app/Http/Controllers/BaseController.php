<?php

namespace App\Http\Controllers;

use App\Mood;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	function hook(Request $request) {
		// $req_dump = print_r($request->all(), TRUE);
		// $fp = fopen('request.log', 'a');
		// fwrite($fp, $req_dump);
		// fclose($fp);
		$payload = json_decode($request->get('payload'));
		$mood_value = $payload->actions[0]->value;
		$mood = new Mood;
		$mood->mood_value = $mood_value;
		$mood->save();
	}

	function dump() {
		 //return file_get_contents('request.log');
	}
}
