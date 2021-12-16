<?php
    require_once('Common.php');

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

        <br/>
        <br/>
        <br/>
        <br/>
        <div class="jumbotron">
            <div class="text-center">
                <h1 class="display-2">Player Stats</h1>
                <h2 class="display-5">Games Played: <?=$gamesPlayed?></h2>
                <h2 class="display-5">Words Played: <?=$wordsPlayed?></h2>
                <h2 class="display-5">Games Won: <?=$gamesWon?></h2>
            </div>

        <br/>
        <br/>

        </div>
    </body>
</html>