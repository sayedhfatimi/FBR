<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TheOliveBranch - :: - HomePage</title>
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
	$adjacents = 3;
	$query = "SELECT COUNT(*) as num FROM posts";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages[num];
	$targetpage = "index.php";
	$limit = 5;
	$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit;
	else
		$start = 0;
	$result = mysql_query("SELECT * FROM posts,members WHERE posts.postuser=members.username ORDER BY postID DESC LIMIT $start, $limit");
	if ($page == 0) $page = 1;
	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage?page=$prev\">« previous</a>";
		else
			$pagination.= "<span class=\"disabled\">« previous</span>";	
		if ($lastpage < 7 + ($adjacents * 2))
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage?page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage?page=$lastpage\">$lastpage</a>";		
			}
			else
			{
				$pagination.= "<a href=\"$targetpage?page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage?page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage?page=$counter\">$counter</a>";					
				}
			}
		}
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage?page=$next\">next »</a>";
		else
			$pagination.= "<span class=\"disabled\">next »</span>";
		$pagination.= "</div>\n";		
	}
?>
<?php
	if(isset($_COOKIE['ID_my_site'])) {
		while($row = mysql_fetch_array($result)) {
			if($_COOKIE['ID_my_site']==$row['postuser']) {
				$postIDget = $row['postID'];
?>
<div class="post">
<a href="user.php?ID=<?=$row['ID'];?>"><img src="<?=$row['pimage'];?>" /></a>
<div class="paic">
<div class="postheader"><?=$row['postheader'];?><div class="deletepost"><form action="deletepost.php" method="post"><input name="postID" type="hidden" value="<?=$postIDget;?>" /><input name="deletepost" type="submit" class="uibutton confirm" value="Delete" /></form></div></div>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="postbottom">Posted By&nbsp;<a href="user.php?ID=<?=$row['ID'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;on&nbsp;<?=$row['posttimestamp'];?></div>
</div>
</div>
<?php
			}
			else {
?>
<div class="post">
<a href="user.php?ID=<?=$row['ID'];?>"><img src="<?=$row['pimage'];?>" /></a>
<div class="paic">
<div class="postheader"><?=$row['postheader'];?></div>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="postbottom">Posted By&nbsp;<a href="user.php?ID=<?=$row['ID'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;on&nbsp;<?=$row['posttimestamp'];?></div>
</div>
</div>
<?php
			}
		}
	}
	else {
		while($row = mysql_fetch_array($result)) {
?>
<div class="post">
<a href="user.php?ID=<?=$row['ID'];?>"><img src="<?=$row['pimage'];?>" /></a>
<div class="paic">
<div class="postheader"><?=$row['postheader'];?></div>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="postbottom">Posted By&nbsp;<a href="user.php?ID=<?=$row['ID'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;on&nbsp;<?=$row['posttimestamp'];?></div>
</div>
</div>
<?php
		}
	}
?>
<?=$pagination?>
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