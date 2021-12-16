<?php
    session_start();

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
?>
<html>
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-toggleable-lg navbar-dark bg-primary border-bottom box-shadow mb-3">
                <div class="container">
                    <a class="navbar-brand" asp-area="" asp-page="/Index">Lib Lib</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".navbar-collapse" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse d-lg-inline-flex flex-lg-row-reverse">
                        <ul class="navbar-nav flex-grow-1">
                            <li class="nav-item">
                                <a class="nav-link text-light" href="index.php">Home</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-light" href="Play.php">Play</a>
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