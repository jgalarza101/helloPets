<?php
class user{

	function getUserDetails($username, $con){
		$sql = "SELECT * from user where username='$username'";

		$result = $con->query($sql);
		$row = $result->fetch_assoc();

		return $row;
	}

	function getOtherUserDetails($username, $con){
		$sql = "SELECT * from user where username !='$username'";

		$result = $con->query($sql);

		return $result;
	}

	function isFavorited($username, $bulletinid, $con){
		$sql = "SELECT * from bookmark where Bookmark_Username='$username' and Bookmark_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;
		return $num;
	}

	function isJoined($username, $bulletinid, $con){
		$sql = "SELECT * from accepts where Join_Username='$username' and Join_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;
		return $num;
	}

}

//work in progress
class pet{
function getPetDetails($username, $con){
		$sql = "SELECT * from pet where Owner_Username='$username'";

		$result = $con->query($sql);
		$mypet = $result->fetch_assoc();

		return $mypet;
	}

	function getOtherUserPetDetails($username, $con){
		$sql = "SELECT * from pet where Owner_Username ='$username'";

		$result = $con->query($sql);
		$otherpet = $result->fetch_assoc();

		return $otherpet;
	}



}

class bulletin{
	function getUserBulletinDetails($username, $con){
		$sql = "SELECT * from playdate_bulletin, user where user.username = playdate_bulletin.Username and user.username = '$username' order by playdate_bulletin.Timestamp DESC";

		$result = $con->query($sql);

		return $result;
	}

	function getOtherUserBulletinDetails($username, $con){
		$sql = "SELECT * from playdate_bulletin, user where user.username = playdate_bulletin.Username and user.username != '$username' order by playdate_bulletin.Timestamp DESC";

		$result = $con->query($sql);

		return $result;
	}

	function getUserBulletinFavorites($username, $con){
		$sql= "SELECT * FROM playdate_bulletin, bookmark WHERE bookmark.Bookmark_Playdate_ID = playdate_bulletin.Playdate_ID and bookmark.Bookmark_Username= '$username' order by playdate_bulletin.Timestamp desc";
		$result = $con->query($sql);

		return $result;
	}

	function getUserBulletinJoins($username, $con){
		$sql= "SELECT * FROM playdate_bulletin, accepts WHERE accepts.Join_Playdate_ID = playdate_bulletin.Playdate_ID and accepts.Join_Username= '$username' order by playdate_bulletin.Timestamp desc";
		$result = $con->query($sql);

		return $result;
	}

	function numOfFavorites($bulletinid, $con){
		$sql = "SELECT * from bookmark where Bookmark_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;

		return $num;
	}

	function addToFavorites($username, $bulletinid, $con){
		$numLikes = $this->numOfFavorites($bulletinid, $con);

		$sql = "SELECT * from bookmark where Bookmark_Username='$username' and Bookmark_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;

		if($num>0){
			$sqlDelete = "DELETE from bookmark where Bookmark_Username='$username' and Bookmark_Playdate_ID='$bulletinid'";

			if($con->query($sqlDelete)===TRUE){
				$numLikes = $numLikes-1;
				return "deleted-".$numLikes;
			}

		}
		else{
			$datetime = date('Y-m-d H:i:s');
			$sqlInsert = "INSERT into bookmark values ('$username', '$bulletinid', '$datetime')";

			if($con->query($sqlInsert)===TRUE){
				$numLikes = $numLikes+1;
				return "inserted-".$numLikes;
			}
		}
	}

	function numOfJoins($bulletinid, $con){
		$sql = "SELECT * from accepts where Join_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;

		return $num;
	}

	function addToJoins($username, $bulletinid, $con){
		$numLikes = $this->numOfJoins($bulletinid, $con);

		$sql = "SELECT * from accepts where Join_Username='$username' and Join_Playdate_ID='$bulletinid'";
		$res = $con->query($sql);
		$num = $res->num_rows;

		if($num>0){
			$sqlDelete = "DELETE from accepts where Join_Username='$username' and Join_Playdate_ID='$bulletinid'";

			if($con->query($sqlDelete)===TRUE){
				$numLikes = $numLikes-1;
				return "deleted-".$numLikes;
			}

		}
		else{
			$datetime = date('Y-m-d H:i:s');
			$sqlInsert = "INSERT into accepts values ('$username', '$bulletinid', '$datetime')";

			if($con->query($sqlInsert)===TRUE){
				$numLikes = $numLikes+1;
				return "inserted-".$numLikes;
			}
		}
	}

	function commentForBulletin($tweetMessage, $dateTweet, $username, $commentPlaydateId, $con){
		$sql = "INSERT into comments(User_Comment, Date_Time, Comment_Username, Comment_Playdate_ID) values ('$tweetMessage', '$dateTweet', '$username', '$commentPlaydateId')";

		if($con->query($sql) === TRUE){
			$sqlCount = "SELECT * from comments where Comment_Username = '$username'";
			$res = $con->query($sqlCount);
			$numTweets =  $res->num_rows;

			return "yayy-".$numTweets;
		}
		else{
			return "error";
		}
	}

	function getBulletinComments($commentPlaydateId, $con){
		$sql = "SELECT * from comments WHERE Comment_Playdate_ID = '$commentPlaydateId'";

		$result = $con->query($sql);

		return $result;
	}


}



?>
