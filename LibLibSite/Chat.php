<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

    $messages = array();

    if (isset($_POST['type'])) 
    {
        $request = array();

        if (strcmp ($_POST['type'], 'sendChat') == 0)
        {
            $request['type'] = 'sendChat';
            $request['user_id'] = $_SESSION['userID'];
            $request['message'] = $_POST['message'];

            $response = $client->send_request($request);

            DebugLog("CHAT SEND SUCCESS: " . $response['success']);
        }
        else if (strcmp ($_POST['type'], 'getChat') == 0)
        {
            $request['type'] = 'getChat';
            $response = $client->send_request($request);
            $chat = $response['chat'];

            // DebugLog("CHAT TEST: " . $response['success']);
            DebugLog("CHAT GET SUCCESS: " . $response['success']);
            DebugLog("CHAT MESSAGE COUNT: " . count($chat));
            DebugLog($chat[0]['user_id']);
            DebugLog($chat[0]['message']);
            // for ($i = 0 ; $i < count($messages); $i++)
            //     DebugLog("MSG: " . $messages[$i]['message']);
        }
    }
?>

<html>
<head>
    <link rel="stylesheet" href="content/css/bootstrap.min.css" />
    <link rel="stylesheet" href="content/css/bootstrap.css" />
    <link rel="stylesheet" href="content/css/site.css" />
    <script src="jquery/jquery.js"></script>
</head>
<body>
<header>
    <script>
        $(document).ready(function()
        {
            $('#navbar').load('navbar.php');
        });
    </script>
    <div id='navbar'></div>
</header>
<div style="margin-left: 2em">
    <br />
    <h1>Chat</h1>
        
    <div>
        <form action="Chat.php" method="post">
            <div style="max-width:400px">
                <br />
                <div class="friendsPanel">
                    <div class="col1">
                        <div class="friendsList">
                            <?php for ($i = 0; $i < count($chat); $i++):?>
                                <p>(<?=$chat[$i]['user_id']?>)  <?=$chat[$i]['message']?> </p>
                                <br/>
                            <?php endfor;?>    
                        </div>
                    </div>
                </div>
                <br/>
                <button class="btn btn-primary btn-lg" name='type' value='getChat' type="submit">Update Chat</button>
                <br />
            </div>
        </form>
    </div>

    <br />
    <div>
        <form action="Chat.php" method="post">
            <div style="max-width:150px">
                <br />
                <span>
                    <label>Send a message: </label>
                    <input type="text" name="message" />
                </span>
                <br/>
                <button class="btn btn-primary btn-lg" name='type' value='sendChat' type="submit">Send Message</button>
                <br />
            </div>
        </form>
    </div>

    <br />
</div>
</body>
</html>