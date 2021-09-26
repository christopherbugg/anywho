<html>
<head>
<?php
include 'common.php';
style();
?>
</head>
<header>
	<nav>
		<h1 class="logo">Any<u>Who</u></h1>
		<a class="button" href="/">Login!</a>
	</nav>
</header>
<body>
<div class="backgroundBox">
<h1>About</h1>
<h2>AnyWho is a privacy-focused dating site for adults<h2>
<h3>Current Features:</h3>
<ul>
	<li>Browse for users near you, filtering by age-group and gender/orientation</li>
	<li>Customizable user profiles including a photo</li>
	<li>Fine-grained visibility controls for your information that are Private-By-Default</li>
	<li>Only mutual Matches can chat</li>
	<li>Can Block other users completely</li>
	<li>End-To-End Encrypted IM-Style chat messaging</li>
	<li>Source-Available (Not FOSS yet): <a href="https://github.com/christopherbugg/anywho">here</a></li>
	<li>FREE! (till payments are added)</li>
	<li>Minimal JavaScript</li>
	<li>Minimal dependencies</li>
</ul>
<h3>Planned Features (unordered):</h3>
<ul>
	<li>Automated Account Deletion (both for users on-demand and for expired trial account)</li>
	<li>Reporting, Moderation, and Administration in-app</li>
	<li>Temporary, Limited Free Trial</li>
	<li>BitCoin Payments (Monthly subscription style)</li>
	<li>CC Payments</li>
	<li>Multiple photos per user</li>
	<li>Eliminate 3-rd party map lookup, ie: self-host map tiles</li>
	<li>Allow easily verifying other users during chats</li>
</ul>
<h3>Pre-Beta Release Roadmap:</h3>
<ul>
	<li>Create and implement password policy</li>
	<li>Release code on github under full copyright</li>
	<li>Setup email hosting for abuse, support, etc.</li>
	<li>Fix chat so enter sends and clear textbox</li>
	<li>Refactor all queries</li>
	<li>Refactor all pages, attempt to funcitionalize whenever possible</li>
	<li>Implement reporting, moderation, and administration in-app</li>
	<li>Implement self-serve account deletion</li>
	<li>Implement time-locked fields. IE: Location can only be changed once-per-month</li>
	<li>Change license to one that models Elastic Search-ish</li>	
	<li>Fill-out FAQ</li>
	<li>Javascript check and explanation page</li>
	<li>robots.txt</li>
	<li>setup and publish scripts (ansible?) for creating, updating, etc.</li>
</ul>
<h3>Pre-1.0 Release Roadmap:</h3>
<ul>
	<li>Setup config file for secrets and stuff</li>
	<li>Perform client-side password hashing prior to sending to server</li>
	<li>security.txt</li>
	<li>Add Captcha to Signup</li>
	<li>Implement versioning and releases</li>
	<li>Strip exif data from uploaded photos</li>
	<li>Implement user verification (PGP) for chats in-app</li>
	<li>Implement BitCoin payments</li>
	<li>Implement free-trial accounts and paid accounts</li>
</ul>
<h3>Pre-2.0 Release Roadmap:</h3>
<ul>
	<li>Migrate to Cassandra db for easy real replication</li>
	<li>Integrate CC Payments</li>
	<li>Multiple photos per user</li>
</ul>
<h1>FAQ</h1>
<ul>
	<li><bold>Is AnyWho Free?</bold> - For now, yes. In the future we plan on adding a payments feature, and then we plan to offer a Free Trial (so anyone can see if there are enough folks that interest them) and a Paid Subscription to actually fund both maintenance and upkeep of the site and development of the code.</li>
</ul>
<a name="terms"></a>
<h1>Terms</h1>
<p>By using this site you agree to the below terms.</p>
<h2>3-rd Partys</h2>
<p>
	Sadly we can't do this all on our own, so we do have some 3-rd party dependencies. Mainly that involves:
	<ul>
		<li><a href="https://openpgpjs.org/">OpenPGP.js</a> (<a href="https://github.com/openpgpjs/openpgpjs/blob/master/LICENSE">Terms</a>) - We use this for the E2EE Messaging. This is a JavaScript library that handles all the crypto. We self-host a local-copy of this so there is (as far as we know) no tracking that happens via this dependency.</li>
		<li><a href="https://leafletjs.com/">Leaflet</a> (<a href="https://github.com/Leaflet/Leaflet/blob/master/LICENSE">Terms</a>) - We use this for the map you see when you edit your profile. This is a JavaScript library (and a few assets) that acts as a wrapper around the OpenStreetMap API. We self-host a local-copy of this so there is (as far as we know) no tracking that happens via this dependency.</li>
		<li><a href="https://www.openstreetmap.org/">OpenStreetMap</a> (<a href="https://www.openstreetmap.org/copyright">Terms</a>) - We use this for the map you see when you edit your profile. This is the external service that we query for the map imagery when you load and use the map. It is fully possible that this service tracks your requests and can associate your IP with the map tiles (images) that your IP requests. It is always advised to pick an approximate location when you use the map.</li>
		<li><a href="https://www.ovh.com/world/">OVH</a> (<a href="https://us.ovhcloud.com/legal/terms-of-service">Terms</a>) - We use OVH for hosting our servers and other general hosting needs. It is assumed that OVH may monitor all traffic to and from our servers, though as we use TLS encryption to/from our CDN, that traffic should all be encrypted to OVH. Because of their role and the services we utilize, they could, at any time, procure any and all information that resides in our database and/or modify or change any files on our servers. This would generally be in violation of our agreement with them but is none-the-less possible.</li>
		<li><a href="https://www.cloudflare.com/">Cloudflare</a> (<a href="https://www.cloudflare.com/terms/">Terms</a>) - Cloudflare is used as our Content-Distribution Network (CDN). This means that users connect to Cloudflare's servers directly, then Cloudflare requests the data on behalf of those users from our servers. Because of this privileged position they act as a purposeful Man-In-The-Middle and should be treated as such. The way we've setup our TLS encryption means all traffic to and from Cloudflare is encrypted, however data at Cloudflare is decrypted. Cloudflare has the ability to see, store, and process all traffic, unencrypted, between users and our server, though again, this would generally be in violation of our agreement with them.</li>
	</ul>
	This means that you must agree to their terms of use as well, and agree not to utilize us to abuse them. 
</p>
<h2>Cookies</h2>
<p>
	This site uses cookies. These are files that are placed on your computer, and information that is stored in your browser. The cookies we use are soley for site functionality. They are: 
	<ul>
		<li>PHPSESSID - This is a cookie that is stored on your computer for the duration of your session. We use it to track if you're authenticated or not, and which user you are, assuming the former.</li>
		<li>their_ArmoredPublicKey - This is a Session Storage value that is stored in your browser for the duration of your session (like a cookie). We use it for the E2EE Messaging to keep track of the other users public key.</li>
		<li>your_ArmoredPublicKey - This is a Session Storage value that is stored in your browser for the duration of your session (like a cookie). We use it for the E2EE Messaging to keep track of your public key.</li>
		<li>your_ArmoredPrivateKeyDecrypted - This is a Session Storage value that is stored in your browser for the duration of your session (like a cookie). We use it for the E2EE Messaging to keep track of your private key. It's only ever decrypted and saved by your browser.</li>
	</ul>
	Without these cookies the site would not function properly and in some cases would not function at all. 
</p>
<h2>Privacy</h2>
<p>
	Your privacy is more important than you likely realize, and this site does all it can to offer the functionality of a dating site in the most private manner possible. Unfortunately nothing is perfect and so we must collect, store, process, and even allow some of your information to be transmitted to 3rd parties (see above). We try whenever we can simply not to collect or store your information, and to actually delete what we have stored as quickly as possible. Here is our best prospect for a semi-exhaustive list of the information we collect, store, process, and allow transmission of to 3rd parties:
	<ul>
		<li>IP Address - When you connect to any website, you provide your IP Address to a number of different parties along the way. To keep things simple, our upstream CNDs and hosting providers collect, process, and store your IP Address. We collect, process and store your IP Address by virtue of the logs maintained by our webserver of who connects to it. These logs are regularly deleted and there is no association of an IP Address to a user account. Additionally when you edit your profile a map is loaded so you can let us know your approximate location. This map uses images that are fetched from OpenStreetMap (see above). Because your browser is doing the fetching, OpenStreetMap collects, processes, and likely stores your IP Address.</li>
		<li>Display Name - When you signup to our site, you can customize your Display Name. This can include identifying information. This is always public and may be seen by any user and us.</li>
		<li>PGP Keys - Your PGP keys are generated by your browser when you signup using your username and password. The Private Key is then encrypted, then both are sent from your browser to us. We store these keys in a database. Your Public Key is given by our server to other users whom you've Matched with and who wish to chat with you. Your Private Key is only ever given by our server to you when you login so you may decrypt it and have it handy for chatting.</li>
		<li>Date Of Birth - When you signup to our site, you can customize your Date Of Birth. This can include identifying information. This is private by default but its visibility can be customized to be shared with only users whom you've matched with, or anyone. In order to serve this information to other users this information is always visible to us.</li>
		<li>Gender - When you signup to our site, you can customize your Gender. This can include identifying information. This is private by default but its visibility can be customized to be shared with only users whom you've matched with, or anyone. In order to serve this information to other users this information is always visible to us.</li>
		<li>Profile Picture - When you signup to our site, you can customize your Profile Picture. This can include identifying information. This is private by default but its visibility can be customized to be shared with only users whom you've matched with, or anyone. In order to serve this information to other users this information is always visible to us.</li>
		<li>Display Location - When you signup to our site, you can customize your Display Location. This can include identifying information. This is private by default but its visibility can be customized to be shared with only users whom you've matched with, or anyone. In order to serve this information to other users this information is always visible to us.</li>
		<li>Location - When you signup to our site, you can customize your Location. This can include identifying information. This is always public and may be seen by any user and us. Although we do not directly share the Location information that you give us with other users, they may be able to determine the exact location you provided us through other means. Additionally when you edit your profile OpenStreetMap (see above) is sent requests for the map images that surround the market location you've selected. This may enable them to determine the Location you provide to us. You should always use an approximate location and never your exact true location.</li>
		<li>Password - When you signup to our site, you must provide a password. This password is sent to our server where it is hashed with a Password Storage Algorithm (currently bcrypt). Your actual password is never stored by us, but theoretically could be intercepted by a 3rd party along the way. Assuming a reasonably strong (20+ character), uncompromised password (not compromised by you or reused), and that our server-side code as not been compromised, it should be considered very secure and nearly unobtainable by us or anyone else.</li>
		<li>Matches - When you use our site you may 'Like' other users. This may be seen by any other user whom 'Like's you back. In order to serve this information to other users this information is always visible to us.</li>
		<li>Blocks - When you use our site you may 'Block' other users. This may be seen by any other user whom has previously known of your existence on the site, though we do not provide this information directly to those users whom are blocked. In order to serve this information to other users and you, this information is always visible to us.</li>
		<li>Chats - When you use our site you may Chat with other users. This may be seen by any user whom you chat with. In order to serve this information to other users and you, this information is always visible to us.</li>
		<li>Messages - When you use our site you may send Messages in a Chat to other users. This may be seen by any user whom you send a message to. In order to serve this information to others and you, some information is always visible to us. Specifically we store and process: Sender, Chat (which chat this message is part of), and the encrypted version of the message content. </li>
		<li>Message Content - All message content is End-to-End Encrypted and unreadable to anyone other than the Chat parties (you can also read messages you've sent). This encryption takes place in your browser (and your Chatting partners browser) and means that we, or anyone else, would be unable to read the contents of your messages without them being otherwise shared with us. This is a strong level of encryption although it is important to remember there are much better secure communications platforms that can provide a much better level of assurance for privacy, security, and/or anonymity (<a href="https://github.com/openpgpjs/openpgpjs#security-recommendations">Security recommendations from OpenPGP.js</a>). You should use and rely on this encryption for initial contact only and not for long-term communications.</li>
	</ul>
	This is an enormous list and there will likely be errors or omissions in it. On the plus side, for the data that is under our control (not in the hands of a 3rd party) we do not sell or otherwise give away this data beyond serving the relevant peices of data to other users of the site. IE: We may show your Display Name to other users whom have indicated their location is near to your indicated location.
</p>
<h2>Your Behavior</h2>
<p>
	This site is intended to be used solely as a privacy-focused dating site for adults. Children and the data of children are not allowed on this site. Conduct which is illegal in the United States, in violation of the terms of our 3rd party partners and hosting providers, or is generally detrimental to the sole intended purpose of the site is forbidden. Conduct which violates this will result in the offending account and all related information being deleted.
</p>
</form>
</div>
</body>
<?php footer(); ?>
</html>