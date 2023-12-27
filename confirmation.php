<?php 
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TheOliveBranch - :: - Registration Confirmation</title>
<link href="css/stylesheet_red.css" rel="stylesheet" title="Red" type="text/css" />
<link href="css/stylesheet_blue.css" rel="alternate stylesheet" title="Blue" type="text/css" />
<link href="css/stylesheet_green.css" rel="alternate stylesheet" title="Green" type="text/css" />
<link href="css/stylesheet_black.css" rel="alternate stylesheet" title="Black" type="text/css" />
<script type="text/javascript" src="js/styleswitcher.js"></script>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/fader.js"></script>
<script type="text/javascript" src="js/adminmenutoggle.js"></script>
<script type="text/javascript" src="js/cookie.js"></script>
<link href="css/mainstylesheet.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
<div id="maincontainer">
<div id="headercontainer"><h1>TheOliveBranch<span class="spandot">dot</span>Com</h1>
</div>
<div id="contentcontainer">
<div class="clear"></div>
<div id="leftcontent">
<?php
	if(isset($_COOKIE['ID_my_site'])) {
?>
<a href="index.php"><div class="button">FrontPage</div></a>
<div class="button admintoggle">Admin</div>
<ul class="admin_menu">
<li><a href="logout.php">LogOut</a></li>
<li><a href="addpost.php">Add Post</a></li>
<li><a href="#">Change Password</a></li>
<li><a href="user.php?username=<?php echo $_COOKIE['ID_my_site'];?>">My Details</a></li>
<li><a href="pimage.php">Profile Image</a></li>
<li><a href="deleteallposts.php">Delete All Posts</a></li>
</ul>
<?php
	}
	else {
?>
<a href="index.php"><div class="button">FrontPage</div></a>
<a href="login.php"><div class="button">Login</div></a>
<a href="register.php"><div class="button">Register</div></a>
<?php
	}
?>
<div id="colorchanger">
ColorChanger:
<br />
<a href="#" onclick="setActiveStyleSheet('Red'); return false;"><div id="colorchangerred"></div></a>
<a href="#" onclick="setActiveStyleSheet('Blue'); return false;"><div id="colorchangerblue"></div></a>
<a href="#" onclick="setActiveStyleSheet('Green'); return false;"><div id="colorchangergreen"></div></a>
<a href="#" onclick="setActiveStyleSheet('Black'); return false;"><div id="colorchangerblack"></div></a>
<div class="clear"></div>
</div>
</div>
<div id="rightcontent">
<?
	$passkey = $_GET['passkey'];
	$sql1 = "SELECT * FROM temp_members WHERE confirmationcode = '$passkey'";
	$result1 = mysql_query($sql1);
	if ($result1) {
		$count = mysql_num_rows($result1);
		if ($count==1) {
			$rows = mysql_fetch_array($result1);
			$ID = md5(uniqid(rand()));
			$username = $rows['username'];
			$password = $rows['password'];
			$email = $rows['email'];
			$fullname = $rows['fullname'];
			$pimage = "./images/dpi.gif";
			$sql2 = "INSERT INTO members (ID, username, password, email, fullname, pimage) VALUES ('$ID', '$username', '$password', '$email', '$fullname', '$pimage')";
			$result2=mysql_query($sql2);
		}
		else {
?>
<p>Wrong Confirmation code.</p>
<?php
		}
		if ($result2) {
?>
<p>Your account has been activated.</p>
<?php
			$sql3 = "DELETE FROM temp_members WHERE confirmationcode = '$passkey'";
			$result3 = mysql_query($sql3);
		}
	}
?>
</div>
<div class="clear"></div>
</div>
</div>
<div id="footercontainer">
<h2>Copyright &copy; 2009 - 2010 Limited4. All Rights Reserved.<br /><span class="footercompliance">XHTML Transitional 1.0 | CSS Level 2.1</span></h2>
</div>
</body>
</html>
<?php
	mysql_close($connect);
?>