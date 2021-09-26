<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
$userid = userid_or_redirect($db);

$their_userid = sanitizeInt($_GET['their_userid']);
$your_userid = $userid;

$sql = "select m.messageid, m.senderid, m.chatid, message from messages m
inner join chats c on m.chatid = c.chatid
where (c.userid1 = ? and c.userid2 = ?)
or (c.userid1 = ? and c.userid2 = ?) 
order by m.messageid desc limit 10";
$query = $db->prepare($sql);
$query->execute([$their_userid, $your_userid, $your_userid, $their_userid]);
$data = $query->fetchAll();

$json = json_encode($data);

echo $json;

?>