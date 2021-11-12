<?php
    require_once('path.inc');
    require_once('get_host_info.inc');
    require_once('rabbitMQLib.inc');

    DebugLog("test");
    
    if (isset($_POST['type'])) 
    {
        $client = new rabbitMQClient("dbConn.ini","dbServer");
        DebugLog("test2");

        $request = array();
        $request['type'] = 'login';
        $request['username'] = $_POST['username'];
        $request['password'] = $_POST['password'];
        
        $response = $client->send_request($request);

        DebugLog("LOGIN REQUEST SUCCESS: " . $response['login']);
    }

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
    <div style="margin-left: 2em">
        <br />
        <br />
        <h1>Friends</h1>
    
        <div>
            <p>Enter the username of a desired friend:</p>
            <form method="post">
                <span>
                    <input type="text" name="friendUsername" />
                    <button asp-page-handler="AddFriend">Add Friend</button>
                </span>
            </form>
        </div>
        <br />
        <div class="friendsPanel">
            <div class="col1">
                <h2>Friends List</h2>
                <div class="friendsList">
                </div>
            </div>
            <div class="col2">
                <h2> Friend Requests</h2>
                <div class="friendsList">
                        <form action="Friends.php" method="post">
                            <span>
                                <input type="hidden" name="friendUsername" value="" />
                                <button class="btn btn-primary btn-lg" name='type' value='register' type="submit">Register</button>
                                
                                <button asp-page-handler="AcceptFriend">Accept Friend</button>
                            </span>
                        </form>
                        
                    <p>testUsername</p>
                    <input type="text" name="fName" value="testUsername" disabled/>
                    <button asp-page-handler="AcceptFriend">Accept Friend</button>
                    <br />
                    <br />
                </div>
            </div>
        </div>
        <br />
</div>
    </body>
</html>


