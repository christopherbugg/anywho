<html>
<head>
<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
$userid = userid_or_redirect($db);
?>

<head>
	<?php style();?>
   <link rel="stylesheet" href="leaflet.css"/>
   <script src="leaflet.js"></script>

   <script type="text/javascript">

window.onload = async function () 
{

	let old_long = document.getElementById('long').value
	let old_lat = document.getElementById('lat').value

    // Create new map object and set coords
    var map = L.map('mapid').setView([old_lat, old_long], 5);

    // Add the imagery behind it (the pictures that make the coordinate plane look like a map)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add a marker to the map
    L.marker([old_lat, old_long], {draggable: true, autoPan: true}).addTo(map).on('moveend', onMove)

    // Get the coordinates whenever the user drags the marker to a new place
    function onMove(e) {
        // console.log('Detected Marker Move')
        // console.log(e.target._latlng);
        // console.log(e.target._latlng.lat)
        // console.log(e.target._latlng.lng)

        // Put the keys in the form so the server can save them
	    document.getElementById('long').value = e.target._latlng.lng;
		document.getElementById('lat').value = e.target._latlng.lat;

    }

}

</script> 

</head>
<header>
<?php navbar($userid); ?>
</header>
<?php

// Thumbnail generator

//Ex call:
//$src="1494684586337H.jpg";
//$dest="new.jpg";
//$desired_width="200";
//make_thumb($src, $dest, $desired_width);
function make_thumb($src, $dest, $desired_width, $fileType) {

    /* read the source image */
    switch ($fileType) {
    	case "jpg":
		$source_image = imagecreatefromjpeg($src);
    		break;
    	case "png":
		$source_image = imagecreatefrompng($src);
    		break;
    	case "jpeg":
		$source_image = imagecreatefromjpeg($src);
    		break;
    	case "gif":
		$source_image = imagecreatefromgif($src);
    		break;    		    			
    }   
    $width = imagesx($source_image);
    $height = imagesy($source_image);

    /* find the "desired height" of this thumbnail, relative to the desired width  */
    $desired_height = floor($height * ($desired_width / $width));

    /* create a new, "virtual" image */
    $virtual_image = imagecreatetruecolor($desired_width, $desired_height);

    /* copy source image at a resized size */
    imagecopyresampled($virtual_image, $source_image, 0, 0, 0, 0, $desired_width, $desired_height, $width, $height);

    /* create the physical thumbnail image to its destination */
    imagepng($virtual_image, $dest);
}

// If user POST'ed here
if($_SERVER['REQUEST_METHOD'] === 'POST')
{

	// Grab values out of the post
	$new_displayname = sanitizeString($_POST['displayname']);
	$new_dateofbirth = sanitizeDate($_POST['dateofbirth']);
	$new_dateofbirthvisibility = sanitizeString($_POST['dateofbirthvisibility']);
	$new_genderid = sanitizeInt($_POST['genderid']);
	$new_gendervisibility = sanitizeString($_POST['gendervisibility']);
	$new_seekinggendersvisibility = sanitizeString($_POST['seekinggendersvisibility']);
	$new_seekingagegroupsvisibility = sanitizeString($_POST['seekingagegroupsvisibility']);
	$new_agevisibility = sanitizeString($_POST['agevisibility']);
	$new_profilepicturevisibility = sanitizeString($_POST['profilepicturevisibility']);
	$new_lat = sanitizeFloat($_POST['lat']);
	$new_long = sanitizeFloat($_POST['long']);
	$new_displaylocation = sanitizeString($_POST['displaylocation']);
	$new_displaylocationvisibility = sanitizeString($_POST['displaylocationvisibility']);
	$new_aboutme = sanitizeString($_POST['aboutme']);
	$new_aboutmevisibility = sanitizeString($_POST['aboutmevisibility']);

	// Update the record
	$sql = "update users set 
	displayname = ?
	, dateofbirth = ?
	, dateofbirthvisibilityid = (select visibilityid from visibility where visibility = ?)
	, genderid = ?
	, gendervisibilityid = (select visibilityid from visibility where visibility = ?)
	, seekinggendersvisibilityid = (select visibilityid from visibility where visibility = ?)
	, seekingagegroupsvisibilityid = (select visibilityid from visibility where visibility = ?)
	, agevisibilityid = (select visibilityid from visibility where visibility = ?)
	, profileimagevisibilityid = (select visibilityid from visibility where visibility = ?)
	, location = point(?, ?)
	, displaylocation = ?
	, displaylocationvisibilityid = (select visibilityid from visibility where visibility = ?)
	, aboutme = ?
	, aboutmevisibilityid = (select visibilityid from visibility where visibility = ?)
	where userid = ?";
	$query = $db->prepare($sql);
	$query->execute([$new_displayname, $new_dateofbirth, $new_dateofbirthvisibility, $new_genderid, $new_gendervisibility, $new_seekinggendersvisibility, $new_seekingagegroupsvisibility, $new_agevisibility, $new_profilepicturevisibility, $new_long, $new_lat, $new_displaylocation, $new_displaylocationvisibility, $new_aboutme, $new_aboutmevisibility, $userid]);

	// Update seeking genders
	if(isset($_POST['seekinggendersids']))
	{
		// Grab the new values out of the post
		$new_seekinggendersids = $_POST['seekinggendersids'];

		// TODO: clean this up so we aren't dumping just to re-add
		// Delete the existing values in the db
		$sql = "DELETE FROM seekinggenders where userid = ?";
			$query = $db->prepare($sql);
			$query->execute([$userid]);

		// Add the updated values back/in
		foreach ($new_seekinggendersids as $new_seekinggenderid)
		{
			$sql = "INSERT INTO seekinggenders(userid, genderid)
	select ?, ? where not exists
	(select 1 from seekinggenders where userid = ? and genderid = ?)";
			$query = $db->prepare($sql);
			$query->execute([$userid, sanitizeInt($new_seekinggenderid), $userid, sanitizeInt($new_seekinggenderid)]);
		}
	}

	// Update seeking age groups
	if(isset($_POST['seekingagegroupsids']))
	{
		// Grab the new values out of the post
		$new_seekingagegroupsids = $_POST['seekingagegroupsids'];

		// TODO: clean this up so we aren't dumping just to re-add
		// Delete the existing values in the db
		$sql = "DELETE FROM seekingagegroups where userid = ?";
			$query = $db->prepare($sql);
			$query->execute([$userid]);

		// Add the updated values back/in
		foreach ($new_seekingagegroupsids as $new_seekingagegroupid)
		{
			$sql = "INSERT INTO seekingagegroups(userid, agegroupid)
	select ?, ? where not exists
	(select 1 from seekingagegroups where userid = ? and agegroupid = ?)";
			$query = $db->prepare($sql);
			$query->execute([$userid, sanitizeInt($new_seekingagegroupid), $userid, sanitizeInt($new_seekingagegroupid)]);
		}
	}

	// Update profile picture
	if((isset($_FILES['profilepicture'])) && ($_FILES['profilepicture']["name"]) != "")
	{

		// For the thumbnail generator...
		$target_dir = "uploads/";
		$target_file = $target_dir . sanitizeString(basename($_FILES["profilepicture"]["name"]));
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$desired_width = "400";
		make_thumb($_FILES['profilepicture']['tmp_name'], $_FILES['profilepicture']['tmp_name'], $desired_width, $imageFileType);

		$file_base64 = base64_encode(file_get_contents($_FILES['profilepicture']['tmp_name']));

		$file = 'data:image/'.$imageFileType.';base64,'.$file_base64;

		// Add to images table
		$new_imageid = $db->query("insert into images (image) values ('$file') RETURNING imageid")->fetch()[0];

		// Set users profile picture to new upload
		$sql = "update users set profileimageid = ? where userid = ?";
		$query = $db->prepare($sql);
		$query->execute([$new_imageid, $userid]);

	}
		
}

// Get user profile info
$sql = "select u.userid
	, u.displayname
	, u.dateofbirth
	, v1.visibility as dateofbirthvisibility
	, u.genderid
	, v2.visibility as gendervisibility
	, EXTRACT(years FROM justify_interval(AGE(dateofbirth))) as age
	, v3.visibility as agevisibility
	, v4.visibility as profilepicturevisibility
	, i.image as profilepicture
	, u.location[0] as long
	, u.location[1] as lat
	, u.displaylocation
	, v5.visibility as displaylocationvisibility
	, v6.visibility as seekinggendersvisibility
	, v7.visibility as seekingagegroupsvisibility
	, u.aboutme
	, v8.visibility as aboutmevisibility
from users u
inner join visibility v1 on u.dateofbirthvisibilityid = v1.visibilityid
inner join visibility v2 on u.gendervisibilityid = v2.visibilityid
inner join visibility v3 on u.agevisibilityid = v3.visibilityid
inner join visibility v4 on u.profileimagevisibilityid = v4.visibilityid
inner join visibility v5 on u.displaylocationvisibilityid = v5.visibilityid
inner join visibility v6 on u.seekinggendersvisibilityid = v6.visibilityid
inner join visibility v7 on u.seekingagegroupsvisibilityid = v7.visibilityid
inner join visibility v8 on u.aboutmevisibilityid = v8.visibilityid
left join images i on u.profileimageid = i.imageid
where userid = ? limit 1";
$query = $db->prepare($sql);
$query->execute([$userid]);
$data = $query->fetch();

$displayname = $data['displayname'];
$dateofbirth = $data['dateofbirth'];
$dateofbirthvisibility = $data['dateofbirthvisibility'];
$genderid = $data['genderid'];
$gendervisibility = $data['gendervisibility'];
$age = $data['age'];
$agevisibility = $data['agevisibility'];
$profilepicture = $data['profilepicture'];
$profilepicturevisibility = $data['profilepicturevisibility'];
$long = $data['long'];
$lat = $data['lat'];
$displaylocation = $data['displaylocation'];
$displaylocationvisibility = $data['displaylocationvisibility'];
$seekinggendersvisibility = $data['seekinggendersvisibility'];
$seekingagegroupsvisibility = $data['seekingagegroupsvisibility'];
$aboutme = $data['aboutme'];
$aboutmevisibility = $data['aboutmevisibility'];

// Existing Seeking Gender Values
$sql = "select genderid from seekinggenders where userid = ?";
$query = $db->prepare($sql);
$query->execute([$userid]);

$seekinggendersids = $query->fetchAll();

// Existing Seeking Age Group Values
$sql = "select agegroupid from seekingagegroups where userid = ?";
$query = $db->prepare($sql);
$query->execute([$userid]);

$seekingagegroupsids = $query->fetchAll();

// Gender Values
$sql = "select genderid, gendersingular, genderplural from genders";
$query = $db->prepare($sql);
$query->execute();

$genders = $query->fetchAll();

// Age values
$sql = "select agegroupid, agegroup from agegroups";
$query = $db->prepare($sql);
$query->execute();

$agegroups = $query->fetchAll();

?>
<body>
<div class="backgroundBox">
<h1>Edit Your Profile!</h1>
<form action="/editprofile.php" method="POST" enctype="multipart/form-data">
</div>

<div class="backgroundBox">
<section>
<h3>Display Name:</h3>
<input class="textInput" type="text" name="displayname" value="<?php echo $displayname; ?>" required>
<br>Always Public
</section>
</div>

<div class="backgroundBox">
<section>
<h3>Profile Pic:</h3>
<?php
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
<input class="fileInput" type="file" name="profilepicture">
<br><br><input  class="radioInput" type="radio" name="profilepicturevisibility" id="Private" value="Private" 
<?php if($profilepicturevisibility == "Private"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="profilepicturevisibility" id="Matches" value="Matches"
<?php if($profilepicturevisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="profilepicturevisibility" id="Public" value="Public"
<?php if($profilepicturevisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>	
</div>

<div class="backgroundBox">
<section>
<h3>Your Location:</h3>
<div id="mapid"></div>	
<br>Always Public
</section>	
</div>

<div class="backgroundBox">
<section>
<h3>Display Location:</h3>
<input  class="textInput" type="text" name="displaylocation" value="<?php echo $displaylocation; ?>">
<br><br><input  class="radioInput" type="radio" name="displaylocationvisibility" id="Private" value="Private" 
<?php if($displaylocationvisibility == "Private"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="displaylocationvisibility" id="Matches" value="Matches"
<?php if($displaylocationvisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="displaylocationvisibility" id="Public" value="Public"
<?php if($displaylocationvisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>	
</div>	

<div class="backgroundBox">
<section>
<h3>DOB:</h3>
<input  class="dateInput" type="date" name="dateofbirth" value="<?php echo $dateofbirth; ?>">
<br><br><input  class="radioInput" type="radio" name="dateofbirthvisibility" id="Private" value="Private" 
<?php if($dateofbirthvisibility == "Private"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="dateofbirthvisibility" id="Matches" value="Matches"
<?php if($dateofbirthvisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="dateofbirthvisibility" id="Public" value="Public"
<?php if($dateofbirthvisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>
</div>

<div class="backgroundBox">
<section>
<h3>Age:</h3>
<input  class="textInput" type="text" name="age" value="<?php echo $age; ?>" disabled></td>
<br><br><input  class="radioInput" type="radio" name="agevisibility" id="Private" value="Private" 
<?php if($agevisibility == "Private"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="agevisibility" id="Matches" value="Matches"
<?php if($agevisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="agevisibility" id="Public" value="Public"
<?php if($agevisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>	
</div>	

<div class="backgroundBox">
<section>
<h3>I am a:</h3>
<select class="dropdown" name="genderid">
	<?php 
		foreach($genders as $row) 
		{			

			$option_genderid =  $row['genderid'];
			$option_gendersingular = $row['gendersingular'];
			$selected = "";

			// Define selected attribute
			if($option_genderid == $genderid)
			{
				$selected = "selected";
			}

			echo '<option value="'.$option_genderid.'"'.$selected.'>'.$option_gendersingular.'</option>';
		}
	?>
</select>
<br><br><input class="radioInput" type="radio" name="gendervisibility" id="Private" value="Private" 
<?php if($gendervisibility == "Private"){ echo "Checked"; } ?>>
<label class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="gendervisibility" id="Matches" value="Matches"
<?php if($gendervisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="gendervisibility" id="Public" value="Public"
<?php if($gendervisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>	
</div>

<div class="backgroundBox">
<section>
<h3>Seeking:</h3>
<select class="dropdown" name="seekinggendersids[]" multiple>
	<?php 
		foreach($genders as $row) 
		{			

			$option_genderid =  $row['genderid'];
			$option_genderplural = $row['genderplural'];
			$selected = "";

			// Define selected attributes
			foreach ($seekinggendersids as $selection)
			{	
				if($option_genderid == $selection['genderid'])
				{
					$selected = "selected";
				}
			}

			echo '<option value="'.$option_genderid.'"'.$selected.'>'.$option_genderplural.'</option>';
		}
	?>
</select>
<br><br><input class="radioInput" type="radio" name="seekinggendersvisibility" id="Private" value="Private" 
<?php if($seekinggendersvisibility == "Private"){ echo "Checked"; } ?>>
<label class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="seekinggendersvisibility" id="Public" value="Public"
<?php if($seekinggendersvisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public but not on profile</label>
</section>	
</div>

<div class="backgroundBox">
<section>
<h3>Who Are:</h3>
<select class="dropdown" name="seekingagegroupsids[]" multiple>
	<?php 
		foreach($agegroups as $row) 
		{			

			$option_agegroupid =  $row['agegroupid'];
			$option_agegroup = $row['agegroup'];
			$selected = "";

			// Define selected attributes
			foreach ($seekingagegroupsids as $selection)
			{	
				if($option_agegroupid == $selection['agegroupid'])
				{
					$selected = "selected";
				}
			}

			echo '<option value="'.$option_agegroupid.'"'.$selected.'>'.$option_agegroup.'</option>';
		}
	?>
</select>
<br><br><input class="radioInput" type="radio" name="seekingagegroupsvisibility" id="Private" value="Private" 
<?php if($seekingagegroupsvisibility == "Private"){ echo "Checked"; } ?>>
<label class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="seekingagegroupsvisibility" id="Public" value="Public"
<?php if($seekingagegroupsvisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public but not on profile</label>
</section>	
</div>

<div class="backgroundBox">
<section>
<h3>About me:</h3>
<input  class="textInput" type="text" name="aboutme" value="<?php echo $aboutme; ?>">
<br><br><input  class="radioInput" type="radio" name="aboutmevisibility" id="Private" value="Private" 
<?php if($aboutmevisibility == "Private"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Private">Private</label>
<input  class="radioInput" type="radio" name="aboutmevisibility" id="Matches" value="Matches"
<?php if($aboutmevisibility == "Matches"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Matches">Matches</label>
<input  class="radioInput" type="radio" name="aboutmevisibility" id="Public" value="Public"
<?php if($aboutmevisibility == "Public"){ echo "Checked"; } ?>>
<label  class="radioLabel" for="Public">Public</label>
</section>	
</div>	

<div class="backgroundBox">
<input type="hidden" name="long" id="long" value="<?php echo $long; ?>" required>
<input type="hidden" name="lat" id="lat" value="<?php echo $lat; ?>" required>
<br><button class="saveButton" type="submit">Save Changes!</button>
</div>
</form>
</div>
</body>
<?php footer(); ?>
</HTML