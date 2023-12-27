<?php
	include ("connect.php");
	$postID = $_POST['postID'];
	mysql_select_db($mysql_database, $connect);
	mysql_query("DELETE FROM posts WHERE postID='$postID'");
	mysql_close($connect);
	header('Location: index.php');
?>