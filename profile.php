<html>
<head>
<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
$userid = userid_or_redirect($db);
style();
echo "</head>";
echo "<header>";
navbar($userid);
echo "</header>";
echo "<body>";

$profileid = sanitizeInt($_GET['profileid']);

// If there's a block, redirect user to browse page
block_redirect($db, $userid, $profileid);

$sql = "select u.userid
	, u.displayname
	, u.dateofbirth
	, v1.visibility as dateofbirthvisibility
	, g.gendersingular
	, v2.visibility as gendervisibility
	, EXTRACT(years FROM justify_interval(AGE(dateofbirth))) as age
	, v3.visibility as agevisibility
	, v4.visibility as profilepicturevisibility
	, i.image as profilepicture
	, u.displaylocation
	, v5.visibility as displaylocationvisibility
	, u.aboutme
	, v6.visibility as aboutmevisibility
from users u
inner join visibility v1 on u.dateofbirthvisibilityid = v1.visibilityid
inner join visibility v2 on u.gendervisibilityid = v2.visibilityid
inner join visibility v3 on u.agevisibilityid = v3.visibilityid
inner join visibility v4 on u.profileimagevisibilityid = v4.visibilityid
inner join visibility v5 on u.displaylocationvisibilityid = v5.visibilityid
inner join visibility v6 on u.aboutmevisibilityid = v6.visibilityid
left join images i on u.profileimageid = i.imageid
left join genders g on u.genderid = g.genderid 
where userid = ? limit 1";
$query = $db->prepare($sql);
$query->execute([$profileid]);
$data = $query->fetch();

$displayname = $data['displayname'];
$dateofbirth = $data['dateofbirth'];
$dateofbirthvisibility = $data['dateofbirthvisibility'];
$gender = $data['gendersingular'];
$gendervisibility = $data['gendervisibility'];
$age = $data['age'];
$agevisibility = $data['agevisibility'];
$profilepicture = $data['profilepicture'];
$profilepicturevisibility = $data['profilepicturevisibility'];
$displaylocation = $data['displaylocation'];
$displaylocationvisibility = $data['displaylocationvisibility'];
$aboutme = $data['aboutme'];
$aboutmevisibility = $data['aboutmevisibility'];

// Show profile pic or default
echo '<img src="';
if($profilepicturevisibility == 'Public')
{
	echo $profilepicture;
}
else 
{
	echo '/images/default.png';
}
echo '" width="200" height="200" class="thumbRounded">';

?>
<br>
<div class="backgroundBox">
<table>
<tr>
<?php

// Display Name
echo "<td>";
echo $displayname;
echo "</td>";

// If we're matched with this person or not (yet)
$isMatched = false;

// If this profile is not yet liked
$sql1 = "select 1 from matches m where m.useridfrom = ? and m.useridto = ? limit 1";
$query1 = $db->prepare($sql1);
$query1->execute([$userid, $profileid]);

$sql2 = "select 1 from matches m where m.useridfrom = ? and m.useridto = ? limit 1";
$query2 = $db->prepare($sql2);
$query2->execute([$profileid, $userid]);

if(!$query1->fetch())
{
	echo '<td colspan="2"><a  class="button" href="/like.php?profileid='.$profileid.'">Like!</a>';
}
// If the profile is liked, if it's not a Match yet
else if(!$query2->fetch())
{
	echo '<td colspan="2"><a  class="button" href="/like.php?profileid='.$profileid.'">Liked!</a>';
}
// If it's a match!
else
{
	echo '<td><a  class="button" href="/chat.php?profileid='.$profileid.'">Chat!</a></td>';
	echo '<td><a  class="button" href="/like.php?profileid='.$profileid.'">Matched!</a>';
	
	$isMatched = true;
}

echo "</td>";
echo "</tr>";
echo "<tr>";
echo "<td class='whiteBorder'>";

if(($isMatched && ($agevisibility != 'Private')) || ($agevisibility == 'Public'))
{
	echo "$age";
}
else 
{
	echo "??";
}
echo " | ";
if(($isMatched && ($displaylocationvisibility != 'Private')) || ($displaylocationvisibility == 'Public'))
{
	echo "$displaylocation";
}
else 
{
	echo "?????";
}

echo "</td>";
?>

<td><a  class="button" href="/block.php?profileid=<?php echo $profileid; ?>">Block</a></td>
<td><a  class="button" href="/report.php?profileid=<?php echo $profileid; ?>">Report</a></td>
</tr>
</table>
</div>
<div class="backgroundBox">
<table>
<?php

// If we're a match and it's not private or it's public, show it!
if(($isMatched && ($dateofbirthvisibility != 'Private')) || ($dateofbirthvisibility == 'Public'))
{
	echo "<tr>
				<th>DOB:</th>
				<td>$dateofbirth</td>
			</tr>";
}
if(($isMatched && ($agevisibility != 'Private')) || ($agevisibility == 'Public'))
{
	echo "<tr>
				<th>Age:</th>
				<td>$age</td>
			</tr>";
}
if(($isMatched && ($gendervisibility != 'Private')) || ($gendervisibility == 'Public'))
{
	echo "<tr>
				<th>Gender:</th>
				<td>$gender</td>
			</tr>";
}
if(($isMatched && ($aboutmevisibility != 'Private')) || ($aboutmevisibility == 'Public'))
{
	echo "<tr>
				<th>About me:</th>
				<td>$aboutme</td>
			</tr>";
}


?>	
</table>
</div>
</body>
<?php footer(); ?>
</html>