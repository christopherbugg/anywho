<?php

function initiate_db_connection() 
{
	$user = "postgres";
	$password = "postgres";
	// $host = "anywho-sql1";
	$host = "127.0.0.1";
	$database = "postgres";

	return new PDO("pgsql:host=$host;dbname=$database", $user, $password);
}

function navbar($userid)
{
	echo '<nav>
		<a  class="button" href="/browse.php">Browse</a>
		<a  class="button" href="/account.php">Account</a>
		<a  class="button" href="/logout.php">Logout</a>
	</nav>';
}

function footer()
{
	echo '<div class="backgroundBox">
		<footer>
			&copy 2021 Chris Bugg
			<a  class="button" href="/about.php">About</a>
		</footer>
		</div>';
}

function style()
{
	echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
	echo '<link rel="stylesheet" href="style.css">';
}

function block_redirect($db, $your_userid, $their_userid)
{
	$sql = "select 1 from blocks
where (blockfrom = ? and blockto = ?)
or (blockfrom = ? and blockto = ?)
limit 1";
	$query = $db->prepare($sql);
	$query->execute([$your_userid, $their_userid, $their_userid, $your_userid]);

	if($query->fetch())
	{
		header("Location: /browse.php");
	}
}

?>