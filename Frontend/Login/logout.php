<?php

if (session_status() != PHP_SESSION_ACTIVE) {
	session_start();
}

$_SESSION["logged_in"] = false;
unset($_SESSION["id"]);
unset($_SESSION["username"]);


header("location: ./index.php");