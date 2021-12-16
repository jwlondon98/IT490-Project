<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

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
        <br/>
        <br/>
        <div style="margin: 0em 5%">
            <div class="card border-primary mb-3 resp-cont" style="min-height: 30rem;">
                <div class="text-center" style="margin-top:2rem;">
                    <p style="font-size: 5rem">Player Stats</p>
                    <p class="rh1">Games Played: <?=$gamesPlayed?></p>
                    <p class="rh1">Words Played: <?=$wordsPlayed?></p>
                    <p class="rh1">Games Won: <?=$gamesWon?></p>
                </div>
            </div>
        </div>
    </body>
</html>