<?php

namespace App\Http\Controllers;

use App\Mood;
use Illuminate\Http\Request;

class BaseController extends Controller
{
	function hook(Request $request)
    {
        if ($request->has('payload')) {
            $payload = json_decode($request->get('payload'));
            $mood_value = $payload->actions[0]->value;
            $user_name = $payload->user->name;
            $user_id = $payload->user->id;
            $mood = new Mood;
            $mood->mood_value = $mood_value;
            $mood->user_name = $user_name;
            $mood->user_id = $user_id;
            $mood->save();
        }
        else{
            $url = 'https://hooks.slack.com/services/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';
            $payload = '{
                "text": '.json_encode($request).'
            }';
            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec( $ch );
        }
    }

//	function outgoing(Request $request) {
//		$payload = $request;
//		$url = 'https://hooks.slack.com/services/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';
//		$ch = curl_init( $url );
//		curl_setopt( $ch, CURLOPT_POST, 1);
//		curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload);
//		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
//		curl_setopt( $ch, CURLOPT_HEADER, 0);
//		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
//
//		$response = curl_exec( $ch );
//	}

	function dump() {
		return Mood::all();
	}
}
