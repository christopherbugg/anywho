<?php

// Returns userid of authenticated user or redirects unathenticated user to login (unless already there)
function userid_or_redirect($db)
{

	// Check if user's session is authenticated
	if(isset($_SESSION["userid"]) && ($_SESSION["userid"] != ""))
	{
		return $_SESSION["userid"];
	}

	// Else redirect to login (unless we're already there)
	if( $_SERVER['REQUEST_URI'] != "/")
	{
		redirect_to_login();
	}
	else
	{
		return "";
	}
}

function redirect_to_login()
{
	header("Location: /");
}

function login($db, $userid)
{
	// If user is authenticated, redirect to next page in login
	if( $userid != "")
	{
		header("Location: /account.php");
	}

	// If user POST'ed here
	if(isset($_POST['username']) && isset($_POST['password']))	
	{
		// Grab username and password
		$username = sanitizeString($_POST['username']);
		$password = sanitizeString($_POST['password']);

		// Get hash from database
		$sql = "select hash, userid from logins where username = ? limit 1";
		$query = $db->prepare($sql);
		$query->execute([$username]);
		$data = $query->fetch();

		$hash = $data['hash'];
		$userid = $data['userid'];

		// Validate their password
		if (password_verify($password, $hash))
		{
			// Authenticate their session
			$_SESSION["userid"] = $userid;


			//TODO: GET RID OF THIS!!!
			$_SESSION["password"] = $password;
			// Put their password in the browser's session storage
			// echo '<script>sessionStorage.setItem("password",`'.$password.'` );</script>';

			// Redirect to next page in login
			header("Location: /decrypt.php");

		}
		else
		{
			// Display 'incorrect login' prompt
			echo "invalid password probably";
		}		
	}
}

function sanitizeString($input)
{
	// Trim whitespace on both ends
	$input = trim($input);

	// Strips tags, high and low ascii, and backticks
	$input = filter_var($input, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);

	// Trims down string to no more than max size
	$input = substr($input, 0, 120);

	return $input;
}

function sanitizeKey($input)
{
	// Trim whitespace on both ends
	$input = trim($input);

	// Strips tags
	$input = filter_var($input, FILTER_SANITIZE_STRING);

	// Trims down string to no more than max size
	$input = substr($input, 0, 1000);

	return $input;
}

function sanitizeInt($input)
{
	// Trim whitespace on both ends
	$input = trim($input);

	// Remove all characters except digits, plus and minus sign, but also converts to string!?
	$input = filter_var($input, FILTER_SANITIZE_NUMBER_INT);

	// Validates value as integer and converts to int on success
	$input = filter_var($input, FILTER_VALIDATE_INT);

	return $input;
}

function sanitizeFloat($input)
{
	// Trim whitespace on both ends
	$input = trim($input);

	// TODO: Fix this. Does a bit too much fixing
	// Remove all characters except digits, plus and minus sign, but also converts to string!?
	// $input = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT);

	// Validates value as float and converts to float on success
	$input = filter_var($input, FILTER_VALIDATE_FLOAT);

	return $input;
}

function sanitizeDate($input)
{
	// Trim whitespace on both ends
	$input = trim($input);

	// Create date object
	$date = date_create($input);

	// Format and return string
	$date = date_format($date, 'Y-m-d');

	return $date;
}

?>