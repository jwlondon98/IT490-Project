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
        
        <br />
        <br />

        <div style="margin: 0em 5%">
            <div class="card border-primary mb-3 resp-cont" style="min-height: 30rem;">
                <div class="text-center" style="margin-top:2rem;">
                    <p style="font-size: 5rem">LibLib</p>
                    <br/>
                    <p class="rh2">A fun, casual game in which players lib random quotes for points.</p>
                    <br/>
                    <br/>
                    <p class="lead">
                        <a class="btn btn-dark bg-primary btn-lg" href="Play.php" role="button">Start Playing</a>
                    </p>
                </div>
            </div>
        </div>
    </body>
</html>