<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    session_start();
    
    // if logged out do nothing
    // if (!isset($_SESSION['username']))
    //     return;

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
    $sessionToken = $_SESSION['sessionToken'];
    $sessionTime = $_SESSION['sessionTime'];

    DebugLog("loaded login with username: " . $username);
    DebugLog("user id: " . $userID);
    DebugLog("stored session token: " . $sessionToken);

    ValidateSession($sessionTime);

    if (isset($_POST['type'])) 
    {
        // $client = new rabbitMQClient("dbConn.ini","dbServer");

        // $request = array();
        // $request['type'] = 'login';
        // $request['username'] = $_POST['username'];
        // $request['password'] = $_POST['password'];
        
        // $response = $client->send_request($request);

        // DebugLog("LOGIN REQUEST SUCCESS: " . $response['login']);
    }

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
    }

    function ValidateSession($sessionTime)
    {
        DebugLog("SESSION TIME: " . $sessionTime);

        // logout if no session time exists 
        if (strcmp($sessionTime, "") == 0)
        {
            DebugLog("empty session time.. logging out..");
            RedirectToLogout();
        }

        // logout if session time expired
        if (time() > $sessionTime)
        {
            DebugLog("session expired.. logging out..");
            RedirectToLogout();
        }
        else
        {
            $remTime = time() - $sessionTime;
            DebugLog("session valid.. remaining time: " . $remTime);
        }
    }

    function RedirectToLogout()
    {
        header('Location: Logout.php');
        exit();
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

        <br />
        <br />
        <br />
        <br />
        <div class="text-center">
            <div class="jumbotron">
                <h1 class="display-4">Lib Lib</h1>
                <p>A fun, casual game in which players lib random quotes for points.</p>

                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="Play.php" role="button">Start Playing</a>
                </p>
            </div>
        </div>
    </body>
</html>