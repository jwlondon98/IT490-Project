<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    session_start();

    unset($_SESSION['username']);
    unset($_SESSION['userID']);
    unset($_SESSION['sessionToken']);
    unset($_SESSION['sessionTime']);

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
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
    <h1>Logged Out</h1>
    <br />
    <br />
    <h3>Please Log Back In</h3>
    <div>
        <form action="Login.php" method="post">
            <div style="max-width:40px">
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