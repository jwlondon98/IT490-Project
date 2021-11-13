<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    session_start();

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
    $sessionToken = $_SESSION['sessionToken'];
    $sessionTime = $_SESSION['sessionTime'];

    DebugLog("loaded login with username: " . $username);
    DebugLog("user id: " . $userID);
    DebugLog("stored session token: " . $sessionToken);
    
    ValidateSession($sessionTime);


    $client = new rabbitMQClient("dbConn.ini","dbServer");

    $request = array();
    $request['type'] = 'getUserStats';
    $request['user_id'] = $_SESSION['userID'];
    $gamesPlayed = "";
    $wordsPlayed = "";
    $gamesWon = "";

    $response = $client->send_request($request);
    if ($response['success'] == true)
    {
        $stats = $response['stats'];
        $gamesPlayed = $stats['gamesPlayed'];
        $wordsPlayed = $stats['wordsPlayed'];
        $gamesWon = $stats['gamesWon'];
    }

    DebugLog("STATS GET SUCCESS: " . $response['success']);

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
    </head>
    <body>
    <header>
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
                                        <?=$username ?> 
                                    </a>
                                </li> 
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
            </nav>
    </header>

        <br/>
        <br/>
        <br/>
        <br/>
        <div class="jumbotron">
            <div class="text-center">
                <h1 class="display-2">Player Stats</h1>
                <h2 class="display-5">Games Played: <?=$gamesPlayed?></h2>
                <h2 class="display-5">Words Played: <?=$wordsPlayed?></h2>
                <h2 class="display-5">Games Won: <?=$gamesWon?></h2>
            </div>

        <br/>
        <br/>

        </div>
    </body>
</html>