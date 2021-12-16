<?php
    require_once('Common.php');

    $messages = array();

    if (isset($_POST['type'])) 
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");

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
            $('#navbar').load('navbar.html');
        });
    </script>
    <div id='navbar'></div>
</header>
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" asp-area="" asp-page="/Index">Lib Lib</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Play.php">Play</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Friends.php">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Chat.php">Chat</a>
                        </li>
                        <li class="nav-item">
                                <a class="nav-link text-dark" href="Stats.php">Stats</a>
                            </li>
                    </ul>
                </div>
                <div id="conditionalLogin" class="d-flex">
                        <ul class="navbar-nav flex-grow-1 me-sm-2">
                            <?php if (strcmp($username, "") == 0) { ?>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="Register.php">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-dark" href="Login.php">Login</a>
                                </li>    
                            <?php } else { ?> 
                                <li class="nav-item">
                                <a class="nav-link text-dark">
                                        <?=$username ?> (<?=$userID ?>)
                                    </a>
                                </li> 
                            <?php } ?> 
                        </ul>
                    </div>
            </div>
        </nav>
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