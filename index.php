<html><body>
<?php
    // POST Contnet from LINE SERVER
    $json_string = file_get_contents('php://input');
    $json_object = json_decode($json_string);
    
    $events = $json_object->events;
    $event_type = (string)($events[0]->type);
    $replay_token = (string)($events[0]->replyToken);
    
    // LINE BOT Messages :: settings
    // LINE API Reference : https://devdocs.line.me/ja/#send-message-object
    $message = array();
    $message['text'] = array(
        array(
            'type' => 'text',
            'text' => (string)($events[0]->message->text)
        )
    );
    $message['follow'] = array(
        array(
            'type' => 'text',
            'text' => 'Hello World!'
        )
    );
    
    // LINE BOT Messages :: reply
    if($event_type == 'message'){
        api_post_request($replay_token, $message['text']);
    }else if($event_type == 'follow'){
        api_post_request($replay_token, $message['follow']);
    }
    
    //  Define POST Request with cURL
    function api_post_request($token, $messages) {
        $url = 'https://api.line.me/v2/bot/message/reply';
        $channel_access_token = 'lTKJ7aeGFlWbUHabWTM5n3xj5PKLtuzyQOFul3eFwUz4KFqA9r0TdS0Ho2HPl/5y1Y7JX1XrTC11UT9LybUHSSrhmTSniH09Kx7YUmob6IVsUplk6JDloeDh6ySP4V6FCrl2sYoO99q8WdXJsbYIgAdB04t89/1O/w1cDnyilFU=';
        $headers = array(
            'Content-Type: application/json',
            "Authorization: Bearer {$channel_access_token}"
        );
        if($message == "mcserver"){
            //$file = fopen("https://ggmc.herokuapp.com/","r");
            //$test = fread($file,"1024");
            //fclose($file);
            $test = "TEST";
            $post = array(
                'replyToken' => $token,
                'messages' => $test
            );
        }else{
            $post = array(
                'replyToken' => $token,
                'messages' => $messages
            );
        }
    
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_exec($curl);
    }
?>
</body>
</html>
