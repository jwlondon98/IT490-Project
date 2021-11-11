<?php



function setFriends($user_id, $friend_id)
{
	$dbGame = $GLOBALS['dbGame'];

	$params = array();
	$params[':user_id'] = $user_id;
	$params[':friend_id'] = $friend_id;

	$stmt = $dbGame->prepare("INSERT INTO Friends(user_id, friend_id) VALUES(:userID, :friendID)");
	
	$r = $stmt->execute($params);
	$e = $stmt->errorInfo();

	if($e[0] == "00000")
	{
		$message = "Friends added";
		$success = true;
	}
	else
	{
		$message = "No Friends added";
		$success = false;
	}

	$set_Friends
	return array("set_Friends" => $set_friend);
}


function getFriends($user_id, $friends_id)
{
	$dbGame = $GLOBALS['dbGame'];

	$params = array();
	$params[':user_id'] = $user_id;
        $params[':friend_id'] = $friend_id;
       
       	$stmt = $dbGame->prepare("SELECT user_id, friend_id from Friends WHERE user_id = :user_id, friend_id = :friend_id");

        $r = $stmt->execute($params);
        $e = $stmt->errorInfo();

        if($e[0] == "00000")
        {
                $message = "Friends added";
                $success = true;
        }
        else
        {
                $message = "No Friends added";
                $success = false;
	}

        return array("get_Friends" => $get_Friends);
}       




?>
