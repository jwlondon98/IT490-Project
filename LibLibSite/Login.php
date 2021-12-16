<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    session_start();

    if (isset($_POST['type'])) 
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");

        $request = array();
        $request['type'] = 'login';
        $request['username'] = $_POST['username'];
        $request['password'] = $_POST['password'];
        
        $response = $client->send_request($request);

        if ($response['login'] == true)
        {
            $_SESSION['username'] = $request['username'];

            $_SESSION['sessionToken'] = $response['sessionToken'];
            $_SESSION['sessionTime'] = $response['sessionTime'];
            $_SESSION['userID'] = $response['userID'];
         
            DebugLog("LOGIN REQUEST SUCCESS: " . $response['login']);
            DebugLog("WELCOME " . $_SESSION['username'] . "(" . $_SESSION['userID']. ")");
            
            RedirectToPlay();
        }
    }

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
    }

    function RedirectToPlay()
    {
        header('Location: Play.php');
        exit();
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
            <nav class="navbar navbar-expand-lg navbar-toggleable-lg navbar-dark bg-primary border-bottom box-shadow mb-3">
                <div class="container">
                    <a class="navbar-brand" asp-area="" asp-page="/Index">Lib Lib</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse d-lg-inline-flex flex-lg-row-reverse">
                        <ul class="navbar-nav flex-grow-1">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Play.php">Play</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Friends.php">Friends</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Chat.php">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Stats.php">Stats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Achievements.php">Achievements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="WordCount.php">Word Count</a>
                            </li>
                        </ul>
                    </div>
                    <div id="conditionalLogin" class="d-flex">
                        <ul class="navbar-nav flex-grow-1 me-lg-2">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Register.php">Register</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Login.php">Login</a>
                            </li>    
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
<div style="margin-left: 2em">
    <br />
    <h1>Login</h1>
    <br />
    <div>
        <form action="Login.php" method="post">
            <div style="max-width:40px">
                <br />
                <span>
                    <label>Username: </label>
                    <input type="text" name="username" />
                </span>
                <br />
                <span>
                    <label>Password: </label>
                    <input type="password" name="password" />
                </span>
                <br/>
                <br/>
                <button class="btn btn-primary btn-lg" name='type' value='login' type="submit">Login</button>
                <br />
            </div>
        </form>
    </div>
    <br />
</div>
</body>
</html>