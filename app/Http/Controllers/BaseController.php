<?php

namespace App\Http\Controllers;

use App\Mood;
use Illuminate\Http\Request;

class BaseController extends Controller
{   
    /* When user clicks a button, slack sends a payload to https://calm-temple-62799.herokuapp.com/hook
       This is configured within slack
       The following function 
    */
    function hook(Request $request) 
    {
        if ($request->has('payload')) {
            //decoding the payload and savind it in the payload variable
            $payload = json_decode($request->get('payload'));
            // Decoding the payload and saving it into payload variable
            $payload = json_decode($request->get('payload'));
            // Extracting values from the payload and saving it into variables 
            // (which have same names as database columns)
            $mood_value = $payload->actions[0]->value;
            $user_name = $payload->user->name;
            $user_id = $payload->user->id;
            // Inserting data into database
            $mood = new Mood;
            $mood->mood_value = $mood_value;
            $mood->user_name = $user_name;
            $mood->user_id = $user_id;
            $mood->save();
        // When outgoing webhooks (keyword within message are used, slack sends another payload to the 
        // URL https://calm-temple-62799.herokuapp.com/hook) are used, the payload does not contain the key 
        //'payload', so the else happens
        } else {
            // prepare URL to send message back to slack
            $url = 'https://hooks.slack.com/services/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';
            // extract values from message received by slack to be able to send personalized message to user
            $user_id = $_POST['user_id'];
            $user_name = $_POST['user_name'];
            $trigger_word = $_POST['trigger_word'];

            //$payload = "";

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

    // Shows content of database at /dump URL
    function dump()
    {
        return Mood::all();
    }
}