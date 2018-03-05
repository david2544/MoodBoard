<!DOCTYPE html>
<html>
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Webhooks testing</title>
<div id="result"></div>

</head>
<body>
	<script>
		window.onload = function mood(){

			var url = "https://hooks.slack.com/services/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";

			var payload = {
				"text": "Hey! Would you like to introduce your input for today?",
				"attachments": [
				{
					"text": "Please choose one of the moods displayed below",
					"fallback": "You are unable to choose a game",
					"callback_id": "wopr_game",
					"color": "#3AA3E3",
					"attachment_type": "default",
					"actions": [
					{
						"name": "mood",
						"text": "Happy :grin:",
						"type": "button",
						"value": "5"
					},
					{
						"name": "mood",
						"text": "Sick :face_with_head_bandage:",
						"type": "button",
						"value": "2"
					},
					{
						"name": "mood",
						"text": "Sad :pensive:",
						"style": "danger",
						"type": "button",
						"value": "1",
						"confirm": {
							"title": "We are sad to hear that.",
							"text": "Would you like to tell me why?",
							"ok_text": "Yes",
							"dismiss_text": "No"
						}
					}
					]
				}
				]
			};

			$.post(url,JSON.stringify(payload),function(data){
				$('#result').text(data);
			})
			setTimeout(mood, 3600000);
		}
	</script>
</body>
</html>