<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');
    
    if (isset($_POST['type'])) 
    {
        if (strcmp ($_POST['type'], 'match') == 0)
        {
            $request = array();

            $request['clientUsername'] = $username; 
            $request['clientID'] = $userID;

            // socket_write($request);

            DebugLog('match make attempt by ws');
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
            $('#navbar').load('navbar.php');
        });
    </script>
    <div id='navbar'></div>
</header>
<div style="margin-left: 2em">
    <br />
    <h1>Player Matching</h1>
        
    <div>
        <!-- <form action="Matching.php" method="post">
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
                <button class="btn btn-primary btn-lg" name='type' value='match' type="submit">Start Matching</button>
                <br />
            </div>
        </form> -->
    </div>

    <br />
</div>
</body>
</html>