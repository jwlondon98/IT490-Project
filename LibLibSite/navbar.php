<?php
    session_start();

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
?>
<html>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    </head>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container-fluid">
                    <a class="navbar-brand" href="index.php">LibLib</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarColor01">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="index.php">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="Play.php" role="button" aria-haspopup="true" aria-expanded="false">Play</a>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="game.php">Classic</a>
                                    <a class="dropdown-item" href="gameChaos.php">Chaos</a>
                                    <a class="dropdown-item" href="gameBlind.php">Blind</a>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Friends.php">Friends</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Chat.php">Chat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Stats.php">Stats</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Achievements.php">Achievements</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="WordCount.php">Word Count</a>
                            </li>
                        </ul>
                    </div>

                    <div id="conditionalLogin" class="d-flex">
                        <ul class="navbar-nav flex-grow-1 me-lg-2">
                            <?php if (strcmp($username, "") == 0) { ?>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="Register.php">Register</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link text-light" href="Login.php">Login</a>
                                </li>    
                            <?php } else { ?> 
                                <li class="nav-item">
                                <a class="nav-link text-light">
                                        <?=$username ?> (<?=$userID ?>)
                                    </a>
                                </li> 
                            <?php } ?> 
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    </body>