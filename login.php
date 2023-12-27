<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TheOliveBranch - :: - Login</title>
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
<?php 
	if(isset($_COOKIE['ID_my_site'])) { 
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
		$check = mysql_query("SELECT * FROM members WHERE username = '$username'");
		while($info = mysql_fetch_array( $check )) {
			if ($pass != $info['password']) {
			}
			else {
				mysql_close($connect);
				header("Location: index.php");
			}
		}
	}
	if (isset($_POST['submit'])) {
			if(!$_POST['username'] | !$_POST['pass']){
				die('You did not fill in a required field.');
			}
		if (!get_magic_quotes_gpc()) {
			$_POST['email'] = addslashes($_POST['email']);
		}
		$check = mysql_query("SELECT * FROM members WHERE username = '".$_POST['username']."'");
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) {
?>
<h3>That user does not exist in our database. <a href="register.php">Click Here to Register</a></h3>
<?php
		}
		while($info = mysql_fetch_array( $check )) {
			$_POST['pass'] = stripslashes($_POST['pass']);
			$info['password'] = stripslashes($info['password']);
			$_POST['pass'] = md5($_POST['pass']);
			if ($_POST['pass'] != $info['password']) {
?>
<h3>Incorrect password, please try again.</h3>
<?php
			}
			else { 
				$_POST['username'] = stripslashes($_POST['username']); 
				$hour = time() + 3600; 
				setcookie(ID_my_site, $_POST['username'], $hour); 
				setcookie(Key_my_site, $_POST['pass'], $hour);
				session_start();
				$_SESSION['LoggedIn'] = true;
				$_SESSION['Username'] = $_COOKIE['ID_my_site'];
				mysql_close($connect);
				header("Location: index.php"); 
			} 
		} 
	} 
	else {
?> 
<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post"> 
<table border="0" width="100%"> 
<tr><td colspan=2><h3>Login</h3></td></tr>
<tr>
<td>Username:</td>
<td align="right"><input type="text" name="username" maxlength="12" class="textbox"></td>
</tr> 
<tr>
<td>Password:</td>
<td align="right"><input type="password" name="pass" maxlength="12" class="textbox"></td>
</tr> 
<tr>
<td colspan="2" align="right"><input type="submit" name="submit" value="Login" class="uibutton confirm"></td>
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
	mysql_close($connect);
?>