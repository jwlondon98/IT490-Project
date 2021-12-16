<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');

    $request = array();
    $request['type'] = 'getWordStats';
    $request['user_id'] = $_SESSION['userID'];

    $response = $client->send_request($request);
    DebugLog("WORD COUNT GET SUCCESS: " . $response['success']);
    if ($response['success'] == true)
    {
        DebugLog("WORD COUNT COUNT: " . count($response['wordList']));
        foreach ($response['wordList'] as $key => $value) {
            DebugLog($key . '  :  ' . $value);
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

    <h1>Word Count</h1>
    <br />
    <h3>Here are your top 10 most used words:</h3>
    
    <div class="friendsList">
        <h5>Word   |   Times Used</h5>
        <?php foreach ($response['wordList'] as $key => $value):
            echo("<h5>" . $key . '    |    ' . $value ."</h5>");?>
        <?php endforeach;?>  
    </div>

    <br />
</div>
</body>
</html>