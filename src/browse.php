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
?>

<body>
<div class="backgroundBox">
<h1>Users Near You!</h1>
</div>
<table class="outerlist">
<?php

	$sql = "select distinct u.userid
, u.displayname 
, case when v1.visibility <> 'Public' then '??' else
cast(EXTRACT(years FROM justify_interval(AGE(u.dateofbirth))) as text) end as age
, case when v4.visibility <> 'Public' then '?????' else
u.displaylocation end as displaylocation
, i.image as profilepicture
, v3.visibility as profilepicturevisibility
, u.location <-> (select u.location from users where u.userid = ? limit 1) as donotuse
from users u
inner join visibility v1 on u.agevisibilityid = v1.visibilityid
inner join visibility v2 on u.gendervisibilityid = v2.visibilityid
inner join visibility v3 on u.profileimagevisibilityid = v3.visibilityid
inner join visibility v4 on u.displaylocationvisibilityid = v4.visibilityid
inner join visibility v5 on u.seekinggendersvisibilityid = v5.visibilityid
inner join visibility v6 on u.seekingagegroupsvisibilityid = v6.visibilityid
inner join agegroups ag 
on EXTRACT(years FROM justify_interval(AGE(u.dateofbirth))) 
between ag.agestart and ag.ageend
or u.dateofbirth is null
inner join genders g on u.genderid = g.genderid
or u.genderid is null
left join images i on u.profileimageid = i.imageid
where 
-- Your gender is what they're seeking, or you can't see their seeking
(
	(select u2.genderid from users u2 where u2.userid = ? limit 1) 
		in (select s.genderid from seekinggenders s where s.userid = u.userid)
	or v5.visibility <> 'Public'
)
-- Their gender is what you're seeking, or you can't see their gender
and (
	g.genderid in (select s.genderid from seekinggenders s where s.userid = ?)
	or v2.visibility <> 'Public'
	)
-- Your agegroup is what they're seeking, or you can't see their seeking or your DOB is null
and (
	(select ag2.agegroupid from users u2
	 inner join agegroups ag2 on 
	 EXTRACT(years FROM justify_interval(AGE(u2.dateofbirth))) 
		between ag2.agestart and ag2.ageend
	 where u2.userid = ? limit 1) 
		in (select s.agegroupid from seekingagegroups s where s.userid = u.userid)
	or v6.visibility <> 'Public'
	or exists (select 1 from users u2 where u2.userid = ? and u2.dateofbirth is null limit 1)
)
-- Their agegroup is what you're seeking, or you can't see their agegroup
and (
	ag.agegroupid in (select s.agegroupid from seekingagegroups s where s.userid = ?)
	or v1.visibility <> 'Public'
	)	
and not exists (
select 1 from blocks
where (blockfrom = ? and blockto = u.userid)
or (blockfrom = u.userid and blockto = ?)
limit 1)	 
ORDER BY donotuse 
LIMIT 50";
	$query = $db->prepare($sql);
	$query->execute([$userid, $userid, $userid, $userid, $userid, $userid, $userid, $userid]);
	$data = $query->fetchAll();
	
	foreach($data as $row) {

		$profileid =  $row['userid'];
		$displayname = $row['displayname'];
		$age = $row['age'];
		$displaylocation = $row['displaylocation'];
		$profilepicture = $row['profilepicture'];
		$profilepicturevisibility = $row['profilepicturevisibility'];

		echo '<tr class="outerlist">';

			echo '<td class="outerlist">';
			echo '<table>';

				echo '<tr>';

					// Show profile pic or default
					echo '<td rowspan="2"><img src="';
					if($profilepicturevisibility == 'Public')
					{
						echo $profilepicture;
					}
					else 
					{
						echo '/images/default.png';
					}
					echo '" width="200" height="200" class="thumbCircle"></td>';

					echo '<td><a  class="button" href="/profile.php?profileid='.$profileid.'">'.$displayname.'</a></td>';

				echo '</tr>';

				echo '<tr>';

					echo '<td class="whiteBorder">'.$age.' | '.$displaylocation.'</td>';

				echo '</tr>';

			echo '</table>';
			echo '</td>';

		echo '</tr>';
	}
?>	
</table>
</body>
<?php footer(); ?>
</html>