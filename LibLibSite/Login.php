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