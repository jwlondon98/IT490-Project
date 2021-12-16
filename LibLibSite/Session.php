<?php
    session_start();

    $username = $_SESSION['username'];
    $userID = $_SESSION['userID'];
    $sessionToken = $_SESSION['sessionToken'];
    $sessionTime = $_SESSION['sessionTime'];

    DebugLog("loaded login with username: " . $username);
    DebugLog("user id: " . $userID);
    DebugLog("stored session token: " . $sessionToken);

    ValidateSession($sessionTime);

    $client = new rabbitMQClient("dbConn.ini","dbServer");

    function DebugLog($msg) 
    {
        echo "<script>console.log('" . $msg . "');</script>";
    }

    function ValidateSession($sessionTime)
    {
        DebugLog("SESSION TIME: " . $sessionTime);

        // logout if no session time exists 
        if (strcmp($sessionTime, "") == 0)
        {
            DebugLog("empty session time.. logging out..");
            RedirectToLogout();
        }

        // logout if session time expired
        if (time() > $sessionTime)
        {
            DebugLog("session expired.. logging out..");
            RedirectToLogout();
        }
        else
        {
            $remTime = time() - $sessionTime;
            DebugLog("session valid.. remaining time: " . $remTime);
        }
    }

    function RedirectToLogout()
    {
        header('Location: Logout.php');
        exit();
    }
?>