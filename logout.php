<?php
	session_start();
    require_once("db.php");
	
	if (isset($_SESSION['logged_user'])) {
		$old = $_SESSION['logged_user'];
		unset($_SESSION['logged_user']);
		session_destroy();
	} else {
		$old = false;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="index.js"></script>
<script type="text/javascript" src="checking.js"></script>
<title>Log out</title>
</head>

<body>
<div id="top">&nbsp;</div>
<div id="wrapper">
<div id="navbar"> <p><a href="index.php">Home</a><br />
  <a href="albums.php">View All Albums</a><br />
  <a href="search.php">Search</a><br /></p>
</div>
<div id="content">
<div id="transparent">
</div>
<div id="page">
<?php
	if ($old) {
		print("<div id=\"nav2\"><p><a href=\"index.php\">Log in</a></p></div>\n");
	} else {
		print("<div id=\"error\"><p>You haven't logged in.<br />");
		print("Go to our <a href=\"index.php\">Log in</a>\n</p></div>");
	}	
?>
</div>
</div>
</div>
</body>
</html>