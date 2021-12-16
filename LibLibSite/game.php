<?php
    require_once('Common.php');
?>

<html >
<?php $session_value = $_SESSION['userID']; ?>
<head>
    <meta charset="utf-8"/ >
    <title>Quote Game</title>
    <style>
	* {padding: 0; margin: 0}
	canvas {background: #eee; display: block; margin: 0 auto;}
    </style>
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
<canvas id="gameCanvas" width="1000" height="600"></canvas>

<script id="gameScript" src="quoteGame.js" data-gamemode="classic" data-userid="<?php echo $_SESSION['userID'];?>"></script>
    
</body>
</html>
