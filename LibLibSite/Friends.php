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
    DebugLog("stored session token: " . $sessionToken);
    
    ValidateSession($sessionTime);

    $friends = GetFriends();

    if (isset($_POST['type'])) 
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");

        $request = array();
        $request['type'] = 'setFriends';
        $request['user_id'] = $_SESSION['userID'];
        $request['friend_id'] = $_POST['friend_id'];
        
        $response = $client->send_request($request);

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

    function GetFriends()
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");

        $request = array();
        $request['type'] = 'getFriends';
        $request['user_id'] = $_SESSION['userID'];
        
        $response = $client->send_request($request);
        $friends = $response['friends'];
       
        return $friends; 
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
    <div style="margin-left: 2em">
        <br />
        <br />
        <h1>Friends</h1>
        <br />
    
        
        <div class="friendsPanel">
            <div class="col1">
                <div class="friendsList">
                    <?php for ($i = 0; $i < count($friends); $i++):?>
                        <p>Friend ID: <?=$friends[$i]['friend_id'] ?>
                    <?php endfor;?>    
                </div>
            </div>
        </div>
        <br/>
        <br/>

        <div class="friendsPanel">
            <p>Enter the ID of a desired friend:</p>
            <form action="Friends.php" method="post">
                <span>
                    <label>Friend ID: </label>
                    <input type="text" name="friend_id" />
                    <button class="btn btn-primary btn-lg" style="margin-left:1em" name='type' value='setFriends' type="submit">Add Friend</button>
                </span>
        </form>
        </div>
    </body>
</html>


