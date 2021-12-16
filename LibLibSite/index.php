<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');
    require_once('Session.php');
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

        <br />
        <br />
        <br />
        <br />
        <div class="text-center">
            <div class="jumbotron">
                <h1 class="display-4">Lib Lib</h1>
                <p>A fun, casual game in which players lib random quotes for points.</p>

                <p class="lead">
                    <a class="btn btn-primary btn-lg" href="Play.php" role="button">Start Playing</a>
                </p>
            </div>
        </div>
    </body>
</html>