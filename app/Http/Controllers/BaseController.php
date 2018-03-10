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
            $user_id = $_POST['user_id'];
            $trigger_word = $_POST['trigger_word'];

            $payload = "";

            if ($trigger_word == "mood")
            {
                $payload = "{
                    'text': 'Hello {$user_id}, Ive heard you mentioned something about mood'
                }";
            }
            else{
                $payload = '{
                   "text": "This is an outgoing webhook reply to one of the keywords: mood, moodboard"
                }';
            }

            $ch = curl_init( $url );
            curl_setopt( $ch, CURLOPT_POST, 1);
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt( $ch, CURLOPT_HEADER, 0);
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec( $ch );
        }
    }

	function dump() {
		return Mood::all();
	}
}