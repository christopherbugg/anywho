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

if(isset($_GET['profileid']))
{
	$profileid = sanitizeInt($_GET['profileid']);

	// If there's a block, redirect user to browse page
	block_redirect($db, $userid, $profileid);

	// Get their data
	$sql = "select u.userid
, u.displayname 
, i.image as profilepicture
, u.publickey
, v1.visibility as profilepicturevisibility
from users u
inner join visibility v1 on u.profileimagevisibilityid = v1.visibilityid
left join images i on u.profileimageid = i.imageid
where userid = ? limit 1";
	$query = $db->prepare($sql);
	$query->execute([$profileid]);
	$data = $query->fetch();

	$their_displayname = $data['displayname'];
	$their_userid = $data['userid'];
	$their_profilepicture = $data['profilepicture'];
	$their_profilepicturevisibility = $data['profilepicturevisibility'];
	$their_ArmoredPublicKey = $data['publickey'];

	echo '<script>sessionStorage.setItem("their_ArmoredPublicKey",`'.$their_ArmoredPublicKey.'` );</script>';

	// Get your data
	$sql = "select userid, displayname from users where userid = ? limit 1";
	$query = $db->prepare($sql);
	$query->execute([$userid]);
	$data = $query->fetch();

	$your_displayname = $data['displayname'];
	$your_userid = $data['userid'];

	// See if the chat doesn't already exist
	$sql = "select 1 from chats c where (c.userid1 = ? and c.userid2 = ?) or (c.userid1 = ? and c.userid2 = ?) limit 1";
	$query = $db->prepare($sql);
	$query->execute([$your_userid, $their_userid, $their_userid, $your_userid]);
	
	if(!$query->fetch())
	{
		// Since it doesn't exist yet, create it!
		$sql = "insert into chats (userid1, userid2) values (?, ?)";
		$query = $db->prepare($sql);
		$query->execute([$your_userid, $their_userid]);
	}
	
	// Show profile pic or default
	echo "<body>";
	echo '<div class="backgroundBox">';
	echo '<img src="';
	if($their_profilepicturevisibility != 'Private')
	{
		echo $their_profilepicture;
	}
	else 
	{
		echo '/images/default.png';
	}
	echo '" width="100" height="100" class="iconCircle">';
	echo '<a class="button" href="/profile.php?profileid='.$their_userid.'">'.$their_displayname.'</a>';
	echo '</div>';

	// Display the table
	echo '<div class="backgroundBox">';
	echo '<table id="messagetable"></table>';

}
else
{
	header("Location: /matches.php");
}

?>

<script src="openpgp.js"></script>

<script type="text/javascript">

window.onload = async function () 
{
	// Get the keys!
    let their_ArmoredPublicKey = sessionStorage.getItem('their_ArmoredPublicKey');
    let your_ArmoredPrivateKeyDecrypted = sessionStorage.getItem('your_ArmoredPrivateKeyDecrypted');
    let your_publicKeyArmored = sessionStorage.getItem('your_ArmoredPublicKey');

    // Read the armored keys in and convert to a Key object
    let your_privatekey = await openpgp.readKey({ armoredKey: your_ArmoredPrivateKeyDecrypted });
    let your_publicKey = await openpgp.readKey({ armoredKey: your_publicKeyArmored });
    let their_publicKey = await openpgp.readKey({ armoredKey: their_ArmoredPublicKey });

    // Setup both public keys in an array
    let both_PublicKeys = [your_publicKey, their_publicKey]; 

	// Get their profileid from the GET param
	let url = new URL(window.location);
	let params = new URLSearchParams(url.search);
	let their_userid = params.get('profileid');

	// Setup an empty message array to hold all the messages
	let messages_array = [];

	// Get the messages and store them in the message array
	async function getMessages() {
        await fetch('getmessages.php?their_userid='+their_userid)
		  .then(response => response.json())
		  .then(data => messages_array = data);

		// Decrypt all the messages!
		await messages_array.forEach(async function(message){

		    const parsedmessage = await openpgp.readMessage({
		        armoredMessage: message['message'] // parse armored message
		    });
		    const { data: decrypted, signatures } = await openpgp.decrypt({
		        message: parsedmessage,
		        verificationKeys: both_PublicKeys, // for verification (optional)
		        decryptionKeys: your_privatekey // for decryption
		    });
		    // console.log('decrypted')
		    // console.log(decrypted); // 'Hello, World!'

		    message['message'] = decrypted;

    	})

		// just chill a bit
    	await sleep(100);
    }

    // Send a new message then update the list
    document.getElementById('sendmessage').onclick = async function sendMessage(){

    	let plaintext = document.getElementById('messagebox').value;

    	// Encrypt the message with both public keys
	    const encrypted = await openpgp.encrypt({
	        message: await openpgp.createMessage({ text: plaintext }),
	        encryptionKeys: both_PublicKeys,
	        signingKeys: your_privatekey
	    });

    	await fetch('sendmessage.php?their_userid='+their_userid, {
    		method: 'POST',
  			headers: {'Content-Type': 'application/json',},
  			//body: JSON.stringify(encrypted),
  			body: encrypted,
		});

		await getMessages();
		await displayMessages();
    }

    // Display the messages on the screen!
    async function displayMessages() {

    	// console.log("starting displayMessages")

    	document.getElementById('messagetable').innerHTML = "";

    	let table = document.getElementById('messagetable');

    	// console.log('messages_array')
    	// console.log(messages_array)

    	await messages_array.forEach(function(message){

    		let row = table.insertRow(0);

	    	let their_cell = row.insertCell(0);
	    	let your_cell = row.insertCell(1);
	    	// console.log('message')
	    	// console.log(message)
	    	if( message['senderid'] == their_userid)
	    	{
	    		their_cell.innerHTML = message['message'];
	    		// console.log('message[message]')
	    		// console.log(message['message'])
	    	}
	    	else
	    	{
	    		your_cell.innerHTML = message['message'];
	    	}
	    	// console.log('row')
	    	// console.log(row)
    	})    

    	// console.log("ending displayMessages")	
    }

    // A nap is always a good idea
    function sleep(ms) 
    {
		return new Promise(resolve => setTimeout(resolve, ms));
	}

    await getMessages();
	await displayMessages();

	setInterval(async function() {
		await getMessages();
		await displayMessages();
	}, 5000);
}

</script>

<br>
<input class="textInput" type="text" id="messagebox" placeholder="Your Message Here!">
<button class="saveButton" id="sendmessage">Send!</button>
</div>
</body>
<?php footer(); ?>
</html>