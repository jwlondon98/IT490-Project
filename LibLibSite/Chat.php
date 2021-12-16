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
            for ($i = 0 ; $i < count($chat); $i++)
                DebugLog("MSG: " . $chat[$i]['message']);
        }
    }
?>

<html>
<head>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/bootstrap.css" />
    <link rel="stylesheet" href="css/site.css" />
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
<div style="margin: 0em 5%">
    <br />
    <br />
    <br />
    <div class="card border-primary mb-3 resp-cont" style="min-height: 50rem;">
        <div class="card-header flex-group">
                <p class="rh1">Chat</p>
                <form action="Chat.php" method="post">
                    <!-- <button class="btn btn-dark bg-primary btn-lg" name='type' value='getChat' type="submit">Update Chat</button> -->
                    <button class="clean-btn" name='type' value='getChat' type="submit" style="margin: 1rem 2rem 0rem 0rem">
                        <svg xmlns="http://www.w3.org/2000/svg" width="2rem" height="2rem" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2v1z"/>
                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466z"/>
                    </svg>
                </button>
            </form>
        </div>
        <div class="card-body scrollList resp-text">
            <?php for ($i = 0; $i < count($chat); $i++):?>
                <p>(<?=$chat[$i]['user_id']?>)  <?=$chat[$i]['message']?> </p>
                <br/>
            <?php endfor;?>    
        </div>
        <div class="card-footer">
            <form action="Chat.php" method="post">
                <div class="form-group">
                    <p class="card-body rh2 resp-text">Send Message</p>
                    <textarea class="form-control" id="exampleTextarea" rows="3" style="resize:none;"></textarea>
                </div>
                <br/>
                <button class="btn btn-dark bg-primary btn-lg" name='type' value='sendChat' type="submit">Send Message</button>
            </form>
        </div>
    </div>

    <br />
    

    <br />
</div>
</body>
</html>