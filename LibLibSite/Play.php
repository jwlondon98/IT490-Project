<?php
    require_once('Common.php');
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
                <h1 class="display-2">Choose a game mode!</h1>
                <div>
                    <br/>
                    <br/>
                    <a class="btn btn-primary btn-lg" href="game.php">Classic</a>
                    <br/>
                    <br/>
                    <br/>
                    <a class="btn btn-primary btn-lg" href="gameChaos.php">Chaos</a>
                    <br/>
                    <br/>
                    <br/>
                    <a class="btn btn-primary btn-lg" href="gameBlind.php">Blind</a>
                </div>
            </div>
        </div>
    </body>
</html>