<?php
include 'common.php';
include 'auth.php';
session_start();	
$db = initiate_db_connection();
$userid = userid_or_redirect($db);

// Get your data
$sql = "select privatekey, publickey from users where userid = ? limit 1";
$query = $db->prepare($sql);
$query->execute([$userid]);
$data = $query->fetch();

$your_ArmoredPrivateKey = $data['privatekey'];
$your_ArmoredPublicKey = $data['publickey'];

// Put your private key in your session storage
echo '<script>sessionStorage.setItem("your_ArmoredPrivateKey",`'.$your_ArmoredPrivateKey.'` );</script>';
echo '<script>sessionStorage.setItem("your_ArmoredPublicKey",`'.$your_ArmoredPublicKey.'` );</script>';

//TODO: GET RID OF THIS!!!
// Get the password from the SERVER session storage
$your_password = $_SESSION["password"];

// Put the password in the BROWSER session storage
echo '<script>sessionStorage.setItem("password",`'.$your_password.'` );</script>';

// Clear our the password value since we're done with it
$_SESSION["password"] = '';

?>

<script src="openpgp.js"></script>

<script type="text/javascript">

window.onload = async function () 
{
	// Get the keys!
	let your_ArmoredPublicKey = sessionStorage.getItem('your_ArmoredPublicKey');
	let your_ArmoredPrivateKey = sessionStorage.getItem('your_ArmoredPrivateKey');
	let your_password = sessionStorage.getItem('password');

    // Decrypt the keys
	// const publicKey = await openpgp.readKey({ armoredKey: your_ArmoredPublicKey });
    const privateKey = await openpgp.decryptKey({
        privateKey: await openpgp.readKey({ armoredKey: your_ArmoredPrivateKey }),
        passphrase: your_password
    });

    // Clear the password so it doesn't hang around in the session
    sessionStorage.setItem('password', '');

	// Re-Armor the private key so it can be stored
    let your_privateKeyArmoredDecrypted = privateKey.armor()

    // Put the keys in the session so the client can use them
    sessionStorage.setItem("your_ArmoredPrivateKeyDecrypted", your_privateKeyArmoredDecrypted )
    sessionStorage.setItem("your_ArmoredPublicKey", your_ArmoredPublicKey )

	// Redirect since we're done
	window.location.replace("/account.php");

}

</script>