<html>
<head>
<?php
include 'common.php';
include 'auth.php';
session_start();	
$db = initiate_db_connection();
$userid = userid_or_redirect($db);
login($db, $userid);
style();
?>
</head>
<header>
	<nav>
		<h1 class="logo">Any<u>Who</u><sub style="font-size: medium;">(Alpha)</sub></h1>
		<a class="button" href="/signup.php">Sign-Up!</a>
	</nav>
</header>
<body>

<div class="backgroundBox">
<p>AnyWho is currently in development and is not yet stable. Any information entered may be deleted.</p>
</div>

<div class="backgroundBox">
<h1>Login!</h1>
<form action="/" method="POST">
	<input class="textInput" type="text" name="username" placeholder="Username" autofocus required>
	<input class="textInput" type="password" name="password" placeholder="Password" required>
	<button class="saveButton" type="submit">Login</button>
</form>
</div>
</body>
<?php footer(); ?>
</html>