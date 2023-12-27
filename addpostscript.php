<?php
	include ("connect.php");
	$postheader = $_POST['postheader'];
	$postcontent = $_POST['postcontent'];
	$posttimestamp = date("F j, Y, g:i a");
	$username = $_COOKIE['ID_my_site'];
	mysql_select_db($mysql_database, $connect);
	$sql = "INSERT INTO posts (postheader, postcontent, posttimestamp, postuser) VALUES ('$postheader', '$postcontent', '$posttimestamp', '$username')";
	mysql_query($sql,$connect);
	mysql_close($connect);
	header('Location: index.php');
?>