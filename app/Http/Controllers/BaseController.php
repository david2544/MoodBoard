<?php

namespace App\Http\Controllers;

use App\Mood;
use Illuminate\Http\Request;

class BaseController extends Controller
{

    /* Receives a post request at /hook and the hook function identifies if its a POST request coming from the
        response of the user when tapping one of the mood buttons or if its an outgoing webhook triggered by
        one of the keywords typed by an user.
    */
    function hook(Request $request)
    {
        /*  Verify if the POST request has a payload parameter inside (meaning it came from the incoming webhook from
            someone interacting with the mood buttons.
        */

        if ($request->has('payload')) {
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
            // Saving
            $mood->save();

        // When outgoing webhooks (keyword within message are used, slack sends another payload to the 
        // URL https://calm-temple-62799.herokuapp.com/hook) are used, the payload does not contain the key 
        //'payload', so the else happens
        } else {
            // prepare URL to send message back to slack
            $url = 'https://hooks.slack.com/services/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';
            // extract values from message received by slack to be able to send personalized message to user
            $user_id = $_POST['user_id'];
            //$user_name = $_POST['user_name'];
            $trigger_word = $_POST['trigger_word'];


            // preparing the payload to be sent back to slack based on the word that triggered the outgoing webhook
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
            // sending the message back to slack via curl using the url provided above and the payload

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

            $response = curl_exec($ch);
        }
    }


    // responsible for displaying the data from the database in the /hook view
    function dump()
    {
        return Mood::all();
    }
}