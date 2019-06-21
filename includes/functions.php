<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "db.php";
include "class.user.php";

$username = $_SESSION['username'];
$bulletinob = new bulletin();

$option = trim($_POST['option']);


if($option=='tweetforuser'){
	$tweetMessage = trim($_POST['tweetMessage']);
  $commentPlaydateId = trim($_POST['commentPlaydateId']);
	$dateTweet = date('Y-m-d H:i:s');

	// $result = $tweetob->tweetForUser($tweetMessage, $dateTweet, $username, $con);
  $result = $bulletinob->commentForBulletin($tweetMessage, $dateTweet, $username, $commentPlaydateID, $con);
	echo $result;

}

if($option=='likeBulletin'){
	$username = $_SESSION['username'];
	$bookmarkPlaydateId = trim($_POST['bookmarkPlaydateId']);
	$result = $bulletinob->addToFavorites($username, $bookmarkPlaydateId, $con);
	echo $result;
}

if($option=='joinBulletin'){
	$username = $_SESSION['username'];
	$joinPlaydateId = trim($_POST['joinPlaydateId']);
	$result = $bulletinob->addToFavorites($username, $joinPlaydateId, $con);
	echo $result;
}

?>
