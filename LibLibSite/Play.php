<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');
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
            <br/>
            <br/>
            <div class="card border-primary mb-3 resp-cont" style="min-height: 30rem;">
                <div class="text-center" style="margin-top:2rem;">
                    <p class="rh1">Choose a game mode!</p>
                    <div>
                        <br/>
                        <br/>
                        <a class="btn btn-dark bg-primary btn-lg" href="game.php">Classic</a>
                        <br/>
                        <br/>
                        <br/>
                        <a class="btn btn-dark bg-primary btn-lg" href="gameChaos.php">Chaos</a>
                        <br/>
                        <br/>
                        <br/>
                        <a class="btn btn-dark bg-primary btn-lg" href="gameBlind.php">Blind</a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>