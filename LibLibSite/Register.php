<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    if (isset($_POST['type'])) 
    {   
        $client = new rabbitMQClient("dbConn.ini","dbServer");

        $request = array();
        $request['type'] = 'register';
        $request['email'] = $_POST['email'];
        $request['username'] = $_POST['username'];
        $request['password'] = $_POST['password'];
        
        $response = $client->send_request($request);

        DebugLog("REGISTER REQUEST SUCCESS: " . $response['success']);
        DebugLog("REGISTER REQUEST MESSAGE: " . $response['message']);
    }

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
    <h1>Register</h1>
    <br />
    <div>
        <form action="Register.php" method="post">
            <div style="max-width:40px">
                <br />
                <span>
                    <label>Email: </label>
                    <input type="text" name="email" />
                </span>
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
                <button class="btn btn-primary btn-lg" name='type' value='register' type="submit">Register</button>
                <br />
            </div>
        </form>
    </div>
    <br />
</div>
</body>
</html>