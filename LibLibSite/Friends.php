<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

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
            <div class="card border-primary mb-3 resp-cont" style="min-height: 30rem;">
                <div class="card-header flex-group">
                    <p class="rh1">Friends</p>
                </div>  

                <div class="card-body scrollList resp-text" style="margin-left:1rem;">
                    <?php for ($i = 0; $i < count($friends); $i++):?>
                        <p>Friend ID: <?=$friends[$i]['friend_id'] ?>
                    <?php endfor;?>    
                </div>
                <div style="margin: 2rem 1rem 0rem 1rem">
                    <form action="Friends.php" method="post">
                        <button class="btn btn-dark bg-primary btn-lg" name='type' value='getFriends' type="submit">Update Friends List</button>
                    </form>  
                </div>
                <br/>
                <br/>
                <div class="card-footer">
                    <p class="card-body resp-text rh2">Enter the ID of a desired friend:</p>
                    <form action="Friends.php" method="post">
                        <input type="text" name="friend_id" style="margin-left:2em"/>
                        <button class="btn btn-dark bg-primary btn-lg" style="margin-left:2em" name='type' value='setFriends' type="submit">Add Friend</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>


