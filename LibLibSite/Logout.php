<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    session_start();

    $username = $_SESSION[''];
    $sessionToken = $_SESSION[''];
    $sessionTime = $_SESSION[''];

    // DebugLog("loaded login with username: " . $username);
    // DebugLog("stored session token: " . $sessionToken);

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
    }
?>

<html>
<head>
    <link rel="stylesheet" href="content/css/bootstrap.min.css" />
    <link rel="stylesheet" href="content/css/bootstrap.css" />
    <link rel="stylesheet" href="content/css/site.css" />
</head>
<body>
<header>
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm navbar-light bg-white border-bottom box-shadow mb-3">
            <div class="container">
                <a class="navbar-brand" asp-area="" asp-page="/Index">Lib Lib</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="navbar-collapse collapse d-sm-inline-flex flex-sm-row-reverse">
                    <ul class="navbar-nav flex-grow-1">
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="index.html">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Play.php">Play</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Friends.php">Friends</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-dark" href="Chat.php">Chat</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex">
                <ul class="navbar-nav flex-grow-1 me-sm-2">
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="Register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-dark" href="Login.php">Login</a>
                    </li>    
                </ul>   
                </div>
            </div>
        </nav>
</header>
<h1>Logged Out</h1>
</body>
</html>