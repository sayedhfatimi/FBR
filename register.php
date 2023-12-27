<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
?>
<?php
	if(isset($_COOKIE['ID_my_site'])) {
		mysql_close($connect);
		header("Location: index.php");
	}
	else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TheOliveBranch - :: - Register</title>
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
<li><a href="user.php?ID=<?php echo $_COOKIE['ID_my_site'];?>">My Details</a></li>
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
<?php
	if (isset($_POST['submit'])) { 
		if (!$_POST['username'] | !$_POST['pass'] | !$_POST['pass2'] ) {
			die('You did not complete all of the required fields');
		}
		if (!get_magic_quotes_gpc()) {
			$_POST['username'] = addslashes($_POST['username']);
		}
		$usercheck = $_POST['username'];
		$check = mysql_query("SELECT username FROM members WHERE username = '$usercheck'") 
		or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 != 0) {
			die('Sorry, the username '.$_POST['username'].' is already in use.');
		}
		if ($_POST['pass'] != $_POST['pass2']) {
			die('Your passwords did not match. ');
		}
		$_POST['pass'] = md5($_POST['pass']);
		if (!get_magic_quotes_gpc()) {
			$_POST['pass'] = addslashes($_POST['pass']);
			$_POST['username'] = addslashes($_POST['username']);
		}
		$confirmationcode = md5(uniqid(rand()));
		$insert = "INSERT INTO temp_members (confirmationcode, username, password, email, fullname)
		VALUES ('".$confirmationcode."', '".$_POST['username']."', '".$_POST['pass']."', '".$_POST['email']."', '".$_POST['fullname']."')";
		$add_member = mysql_query($insert);
		if ($add_member) {
			$to = $_POST['email'];
			$subject = "Your confirmation link here";
			$header = "from: admin <admin@limited4.webuda.com>";
			$message = "Your Comfirmation link \r\n";
			$message .= "Click on this link to activate your account \r\n";
			$message .= "http://limited4.webuda.com/confirmation.php?passkey=$confirmationcode";
			$sentmail = mail($to,$subject,$message,$header);
		}
		if ($sentmail) {
?>
<h3>Registered</h3>
<p>Thank you, you have registered - You must verify your email before you can login.</p>
<?php	
		}
		else {
?>
<p>Cannot send Confirmation link to your e-mail address.</p>
<?php	
		}
	}
	else {	
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<table border="0" width="100%">
<tr><td colspan=2><h3>Register</h3></td></tr>
<tr>
<td>Username:</td>
<td align="right"><input type="text" name="username" maxlength="60" class="textbox"></td>
</tr>
<tr>
<td>Password:</td>
<td align="right"><input type="password" name="pass" maxlength="12" class="textbox"></td>
</tr>
<tr>
<td>Confirm Password:</td>
<td align="right"><input type="password" name="pass2" maxlength="12" class="textbox"></td>
</tr>
<tr>
<td>Full Name:</td>
<td align="right"><input type="text" name="fullname" maxlength="65" class="textbox"></td>
</tr>
<tr>
<td>Email Address:</td>
<td align="right"><input type="text" name="email" maxlength="65" class="textbox"></td>
</tr>
<tr>
<th colspan=2 align="right"><input class="uibutton confirm" type="submit" name="submit" value="Register"></th>
</tr>
</table>
</form>
<?php
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
	}
?>
<?php
	mysql_close($connect);
?>