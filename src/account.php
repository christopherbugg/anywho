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
<h1>Your Account</h1>
</div>

<div class="backgroundBox">
<a  class="button" href="/matches.php">Your Matches!</a>
<br>
<a  class="button" href="/editprofile.php">Edit Profile</a>
<br>
<?php
echo '<a  class="button" href="/profile.php?profileid='.$userid.'">Your Profile</a>';
?>
<br>
<a  class="button" href="/blocks.php">Blocked Users</a>
<br>
<a  class="button" href="/about.php">Payments-WIP</a>
</div>
</body>
<?php footer(); ?>
</html>