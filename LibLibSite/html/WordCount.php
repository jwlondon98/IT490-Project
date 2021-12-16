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

            <div class="card border-primary mb-3 resp-cont" style="min-height: 50rem;">
                <div class="card-header flex-group">
                    <p class="rh1">Word Count</p>
                </div>

                <div class="card-body resp-text">
                    <p class="rh1">Here are your top 10 most used words:</p>
                    <p class="rh2">Word   |   Times Used</p>
                    <?php foreach ($response['wordList'] as $key => $value):
                        echo("<p class='rh2'>" . $key . '    |    ' . $value ."</p>");?>
                    <?php endforeach;?>  
                </div>
            </div>
        </div>
    </body>
</html>