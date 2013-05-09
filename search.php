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
<title>Search</title>
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
	else{
		print("<div id=\"error\"><a href=\"index.php\">Login</a>\n<br />\n</div>");
	}
?>
</div>
<div id="input">
<h2>Search</h2>
<form action="search.php" method="post">
  <p> Caption:
    <input id="caption" type="text" name="caption" onchange="validCaption(this.value);"/>
    <span id="captionmsg">*</span>
    <input id="search" type="submit" name="searchphoto" value="Search Photos" />
  </p>
</form>
<?php
$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
		

  $check = false;
	
	foreach ($header as $type => $item) {
		if (isset($_POST['caption']) && $_POST['caption']!="") {
			$check = true;
			$caption="caption REGEXP '".trim(strip_tags($_POST['caption']))."'";
		}
	}
	
	if ($check) {
	  if ($mysqli->errno) {
		  print($mysqli->error);
		  exit();
	  }
		 
		 
		 
	
	$result = $mysqli->query("SELECT * FROM photos WHERE $caption");
	
	if (!$result) {
		print($mysqli->error);
		exit();
	}
	if ($result->num_rows==0){
				print("<p>empty search</p>");
			}
			else{
	print("<table>\n<thead><tr>\n");
	foreach ($header as $headitm) {
		if($headitm!="pid"){
		print("<th>$headitm</th>\n");
		}
	}
	print("</tr></thead>\n");
	while ($row = $result->fetch_assoc()) {
		print("<tr>\n");
		foreach ($row as $type => $item) {
			if($type!="pid"){
			if ($type == "url"){
				$url="images/".$item;
				print("<td><a href=\"$url\"><img src=\"images/$item\" alt=\"$url\" height=\"48\" width=\"48\" /></a></td>");
			}
			else {
				print("<td>$item</td>\n");
			}}
		}
		print("</tr>\n");
	}
	print("</table>");
			}
	} 
?>
</div>
</div>
</div>
</body>
</html>