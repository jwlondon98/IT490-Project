<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');
?>


<html>
<head>
    <meta charset="utf-8"/ >
    <title>Quote Game</title>
    
    <style>
        * {
            padding: 0; 
            margin: 0
        }
        canvas 
        {
            display: block; 
            margin: 0 auto;
        }
    </style>

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
<br />
        <br />
        <br />
        <div style="margin: 0em 5%">
            <div class="card border-primary mb-3 resp-cont" style="min-height: 50rem;">
                <div class="card-body flex-group">
                    <canvas id="gameCanvas" width="1000" height="600"></canvas>
                    <script id="gameScript" src="quoteGame.js" data-gamemode="chaos" data-userid="<?php echo $_SESSION['userID'];?>"></script>
                </div>
            </div>
        </div>
</body>
</html>
