<?php
include 'auth.php';
session_start();
session_unset();
session_destroy();
//TODO: need to unset browser session variables still
redirect_to_login();
?>