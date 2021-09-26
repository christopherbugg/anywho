<html>
<head>
<?php
include 'common.php';
include 'auth.php';
session_start();
$db = initiate_db_connection();
style();

// If user POST'ed here
if(isset($_POST['username']) && isset($_POST['password']))	
{
	// Grab post params
	$username = sanitizeString($_POST['username']);
	$password = sanitizeString($_POST['password']);
	$publickey = sanitizeKey($_POST['publickey']);
	$privatekey = sanitizeKey($_POST['privatekey']);

	// Check if username is already in-use
	$sql = "select 1 from logins where username = ? limit 1";
	$query = $db->prepare($sql);
	$query->execute([$username]);
	$data = $query->fetch();
	if (!$query->fetch())
	{
		// Hash the password
		$hash = password_hash($password, PASSWORD_DEFAULT);

		// Create a new user record
		$sql = "insert into users (publickey, privatekey) values (?, ?) RETURNING userid";
		$query = $db->prepare($sql);
		$query->execute([$publickey, $privatekey]);
		$data = $query->fetch();
		$userid = $data[0];

		// Create a new login record
		$sql = "insert into logins (userid, username, hash) VALUES (?, ?, ?)";
		$query = $db->prepare($sql);
		$query->execute([$userid, $username, $hash]);

		// Authenticate their session
		$_SESSION["userid"] = $userid;

		// Redirect to account page
		header("Location: /account.php");
	}

	// Else inform them that it's already in-use
	echo "Username is already in use!";
	
}

?>

<script src="openpgp.js"></script>

<script type="text/javascript">
	
window.onload = function () 
{

	// Register a handler
	// Doing this since onsubmit wasn't saving the new field values before the POST data was 'locked in'.
	// This seems to be a problem only when enabling HTTPS through cloudflare so it should work eventually
    document.getElementById('submit').onclick = async function generateKeys(){

    	// Grab the username/password
    	const user = document.getElementById('username').value
    	const passphrase = document.getElementById('password').value;

    	// Generate the keys
    	//TODO: Redo example email. Ideally remove requirement for email entirely
    	const { privateKeyArmored, publicKeyArmored, revocationCertificate } = await openpgp.generateKey({
	        userIDs: [{ name: user , email: 'example@example.com' }],        
	        passphrase: passphrase
	    });

    	// Put the keys in the form so the server can save them
	    document.getElementById('publickey').value = publicKeyArmored;
		document.getElementById('privatekey').value = privateKeyArmored;

	    // Decrypt the keys
		// const publicKey = await openpgp.readKey({ armoredKey: publicKeyArmored });
	    const privateKey = await openpgp.decryptKey({
	        privateKey: await openpgp.readKey({ armoredKey: privateKeyArmored }),
	        passphrase: passphrase
	    });

		// Re-Armor the private key so it can be stored
        let your_privateKeyArmoredDecrypted = privateKey.armor()

        // Put the keys in the session so the client can use them
        sessionStorage.setItem("your_ArmoredPrivateKeyDecrypted", your_privateKeyArmoredDecrypted )
        sessionStorage.setItem("your_ArmoredPublicKey", publicKeyArmored )

        // Submit the form
        document.getElementById('signup').submit();

    }
}
    

</script>
</head>
<header>
	<nav>
		<h1 class="logo">Any<u>Who</u></h1>
		<a class="button" href="/">Login!</a>
	</nav>
</header>
<body>
<div class="backgroundBox">
<h1>Sign-Up!</h1>
<form id="signup" action="/signup.php" method="POST">
	<input class="textInput" type="text" name="username" value="<?php echo substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10); ?>" id="username" required readonly>
	<input class="textInput" type="password" name="password" placeholder="Password" id="password" autofocus required>
	<br><br><input id="checkbox" type="checkbox" name="checkbox" required>
	<label for="checkbox">I Agree to abide by the <a href="/about.php#terms">Terms</a></label>
	<textarea name="publickey" id="publickey" required rows="15" cols="63" hidden></textarea>
	<textarea name="privatekey" id="privatekey" required rows="18" cols="63" hidden></textarea>
</form>
<br><button class="saveButton" type="submit" id="submit">Sign-Up!</button>
</div>
</body>
<?php footer(); ?>
</html>