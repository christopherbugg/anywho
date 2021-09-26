<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
$userid = userid_or_redirect($db);

if(isset($_GET['profileid']))
{
	$their_userid = sanitizeInt($_GET['profileid']);
	$your_userid = $userid;

	// See if the block doesn't already exist
	$sql = "select 1 from blocks m where m.blockfrom = ? and m.blockto = ? limit 1";
	$query = $db->prepare($sql);
	$query->execute([$your_userid, $their_userid]);

	if(!$query->fetch())
	{
		// Since it doesn't exist yet, create it!
		$sql = "insert into blocks (blockfrom, blockto) values (?, ?)";
		$query = $db->prepare($sql);
		$query->execute([$your_userid, $their_userid]);

		// Remove any existing match
		$sql = "delete from matches where useridfrom = ? and useridto = ?";
		$query = $db->prepare($sql);
		$query->execute([$your_userid, $their_userid]);

		// TODO: Remove any existing chat and messages

	}
	else
	{
		// Remove the existing block
		$sql = "delete from blocks where blockfrom = ? and blockto = ?";
		$query = $db->prepare($sql);
		$query->execute([$your_userid, $their_userid]);
	}

}

// Return them to whence they came
$referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");

?>