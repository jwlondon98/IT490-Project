<?php
    require_once('Common.php');

    $friends = array();

    if (isset($_POST['type'])) 
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");

        $request = array();
        $requestType = $_POST['type'];
        DebugLog("PAGE LOADED WITH REQUEST TYPE: " . $requestType);
        $request['type'] = $requestType;

        if (strcmp($requestType, "setFriends") == 0)
        {
            $request['user_id'] = $_SESSION['userID'];
            $request['friend_id'] = $_POST['friend_id'];
            
            $response = $client->send_request($request);
        }
        else if (strcmp($requestType, "getFriends") == 0)
        {
            $request['user_id'] = $_SESSION['userID'];
            $response = $client->send_request($request);
            $friends = $response['friends'];
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
                <form action="Friends.php" method="post">
                    <button class="btn btn-primary btn-lg" name='type' value='getFriends' type="submit">Update Friends List</button>
                </form>
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


