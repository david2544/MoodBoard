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
        } else {
            $url = 'https://hooks.slack.com/services/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';
            $user_id = $_POST['user_id'];
            $user_name = $_POST['user_name'];
            $trigger_word = $_POST['trigger_word'];

            $payload = "";

            if ($trigger_word == "mood") {
                $payload = "{
                    'text': 'Hello <@{$user_id}>, Ive heard you mentioned something about mood.'
                }";
            } else if ($trigger_word == "sad") {
                $payload = "{
	                'attachments': [
                        {
                            'title': 'Dont be sad <@{$user_id}>. Have a cat gif :cat:',
                            'image_url': 'https://media2.giphy.com/media/l1J3pT7PfLgSRMnFC/giphy.gif',
                            'color': '#764FA5'
                        }
                    ]
                }";
            } else if ($trigger_word == "I am sad") {
                $payload = "{
	                'attachments': [
                        {
                            'title': 'Hey <@{$user_id}>, I am sure we can fix that with a cat gif :cat:',
                            'image_url': 'https://media0.giphy.com/media/vFKqnCdLPNOKc/giphy.gif',
                            'color': '#764FA5'
                        }
                    ]
                }";
            } else {
                $payload = "{
                   'text': 'You just ran into a bug :confused:. Idk how but try using one of these commands to summon me : mood, sad, I am sad'
                }";
            }

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
        }
    }

    function dump()
    {
        return Mood::all();
    }
}