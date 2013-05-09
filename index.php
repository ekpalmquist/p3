<?php
    session_start();
    require_once("db.php");
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  <html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="index.js"></script>
<script type="text/javascript" src="checking.js"></script>
<title>Home</title>
</head>

<body>
<div id="top">&nbsp;</div>
<div id="wrapper">
<div id="navbar">
<p>
<a href="index.php">Home</a><br />
<a href="albums.php">View All Albums</a><br />

<a href="search.php">Search</a><br />
</p>
</div>
<div id="content">
<div id="transparent">
</div>
<div id="page">
<?php
	if(isset($_SESSION['logged_user'])){
		print("<div id=\"nav2\"><p>User: Lizzy<br />");
		print("<a href=\"logout.php\">Log out</a>\n<br />\n");
		print("<a href=\"add.php\">Add</a>\n<br />\n");
		print("<a href=\"update.php\">Update</a>\n<br />\n");
		print("<a href=\"delete.php\">Delete</a>\n<br />\n</p></div>");
	}
	else if (!isset($_POST['username']) && !isset($_POST['password'])) {
?>
</div>
<div id="login">
<h2>Log in</h2>
<form action="index.php" method="post">
  <p>Username:
  <input type="text" name="username" />
  <br />
  Password:
  <input type="password" name="password" />
  <br />
  <input type="submit" value="Log in" />
  </p>
</form>
</div>
<?php

} else{
	$username=strip_tags($_POST['username']);
	$password=hash("sha256",strip_tags($_POST['password']));
	
	$query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
	$result = $mysqli->query($query);
	if ($result->num_rows==1) {
		$array = $result->fetch_assoc();
		$_SESSION['logged_user'] = $array['username'];
		$login=true;
		print("<div id=\"nav2\"><p>User: Lizzy<br />");
		print("<a href=\"logout.php\">Log out</a>\n<br />\n");
		print("<a href=\"add.php\">Add</a>\n<br />\n");
		print("<a href=\"update.php\">Update</a>\n<br />\n");
		print("<a href=\"delete.php\">Delete</a>\n<br />\n</p></div>");
	}
	else {
		print("<div id=\"error\">You did not login successfully.\n");
		print("Please <a href=\"index.php\">Login</a> again.\n<br />\n</div>");
		unset($_POST['username']);
		unset($_POST['password']);
	}
}
?>

</div>
</div>
</body>
</html>
