<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
$userid = userid_or_redirect($db);

$their_userid = sanitizeInt($_GET['their_userid']);
$your_userid = $userid;

// $message = $_POST['body'];
$message = file_get_contents('php://input');

$sql = "insert into messages (senderid, chatid, message) values 
(
	?
	, (
		select c.chatid from chats c 
		where (c.userid1 = ? and c.userid2 = ?)
		or (c.userid1 = ? and c.userid2 = ?) limit 1
	)
	, ?
)";
$query = $db->prepare($sql);
$query->execute([$your_userid, $your_userid, $their_userid, $their_userid, $your_userid, $message]);

?>