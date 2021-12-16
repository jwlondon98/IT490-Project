
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
    // DebugLog("ACH COUNT: " . count($aches));
    // DebugLog($aches['play1']);
    // foreach ($aches as $key => $value) {
    //     DebugLog("Key: $key  Value: $value");
    // }
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
                    <p class="rh1">Achievements</p>
                </div>

                <div class="card-body resp-text">
                    <p class="rh1">Completed</p>
                    <?php foreach ($aches as $key => $value):
                        if ($value == 1)
                        echo("<p>" . $key ."</p>");?>
                    <?php endforeach;?>  
                </div>

                <div class="card-body resp-text">
                    <p class="rh1">Incomplete</p>
                    <?php foreach ($aches as $key => $value):
                        if ($value == 0)
                        echo("<p>" . $key ."</p>");?>
                    <?php endforeach;?>  
                </div>
            </div>
        </div>
    </body>
</html>