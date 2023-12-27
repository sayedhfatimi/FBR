<?php
	session_start();
	$past = time() - 100;
	setcookie(ID_my_site, gone, $past);
	setcookie(Key_my_site, gone, $past);
	session_unset();
	session_destroy();
	header("Location: index.php");
?>