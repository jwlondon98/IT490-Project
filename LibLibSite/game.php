<?php
    session_start();

    $userid = $_SESSION['userID'];

    DebugLog("game user id: " . $userid);

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
    }
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
</head>

<body>

<canvas id="gameCanvas" width="1000" height="600"></canvas>

<script id="gameScript" src="quoteGame.js" data-gamemode="classic" data-userid="<?php echo $_SESSION['userID'];?>"></script>
    
</body>
</html>
