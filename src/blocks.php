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
?>
</header>
<body>
<div class="backgroundBox">
<h1>Users You've Blocked</h1>
</div>

<?php

	$sql = "select distinct u.userid
, u.displayname 
, case when v1.visibility <> 'Public' then '??' else
cast(EXTRACT(years FROM justify_interval(AGE(u.dateofbirth))) as text) end as age
, case when v4.visibility <> 'Public' then '?????' else
u.displaylocation end as displaylocation
, i.image as profilepicture
, v3.visibility as profilepicturevisibility
from users u
inner join blocks b on u.userid = b.blockto
inner join visibility v1 on u.agevisibilityid = v1.visibilityid
inner join visibility v2 on u.gendervisibilityid = v2.visibilityid
inner join visibility v3 on u.profileimagevisibilityid = v3.visibilityid
inner join visibility v4 on u.displaylocationvisibilityid = v4.visibilityid
left join images i on u.profileimageid = i.imageid
where b.blockfrom = ?";
	$query = $db->prepare($sql);
	$query->execute([$userid]);
	$data = $query->fetchAll();

	echo '<table class="outerlist">';

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
					echo '<td rowspan="3"><img src="';
					if($profilepicturevisibility != 'Private')
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

					echo '<td>'.$age.' | '.$displaylocation.'</td>';

				echo '</tr>';

				echo '<tr>';

					echo '<td><a  class="button" href="/block.php?profileid='.$profileid.'">Un-Block</a></td>';

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