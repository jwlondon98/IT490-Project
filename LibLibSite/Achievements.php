
<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

    $request = array();
    $request['type'] = 'getAchievements';
    $request['user_id'] = $userID;
    $response = $client->send_request($request);
    $aches = $response['achievements'];

    DebugLog("ACH GET SUCCESS: " . $response['success']);
    DebugLog("ACH COUNT: " . count($aches));
    DebugLog($aches['play1']);
    foreach ($aches as $key => $value) {
        DebugLog("Key: $key  Value: $value");
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
    <h1>Achievements</h1>
    <br />

    <h3>Completed</h3>
    <div class="friendsList">
        <?php foreach ($aches as $key => $value):
            if ($value == 1)
            echo("<p>" . $key ."</p>");?>
        <?php endforeach;?>  
    </div>

    <br />

    <h3>Incomplete</h3>
    <div class="friendsList">
        <?php foreach ($aches as $key => $value):
            if ($value == 0)
            echo("<p>" . $key ."</p>");?>
        <?php endforeach;?>  
    </div>
    <br />
</div>
</body>
</html>