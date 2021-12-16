<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

    // $request = array();
    // $request['type'] = 'getUserStats';
    // $request['user_id'] = $_SESSION['userID'];
    // $gamesPlayed = "";
    // $wordsPlayed = "";
    // $gamesWon = "";

    // $response = $client->send_request($request);
    // if ($response['success'] == true)
    // {
    //     $stats = $response['stats'];
    //     $gamesPlayed = $stats['gamesPlayed'];
    //     $wordsPlayed = $stats['wordsPlayed'];
    //     $gamesWon = $stats['gamesWon'];
    // }

    // DebugLog("STATS GET SUCCESS: " . $response['success']);
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
    <h1>Word Count</h1>
    <br />
    <h3>Here are your top 10 most used words:</h3>
    
    <div class="friendsList">
        <!-- <?php for ($i = 0; $i < count($friends); $i++):?>
            <p>Friend ID: <?=$friends[$i]['friend_id'] ?>
        <?php endfor;?>     -->
    </div>

    <br />
</div>
</body>
</html>