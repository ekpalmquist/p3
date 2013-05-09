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
<title>Albums</title>
</head>

<body>
<div id="top">&nbsp;</div>
<div id="wrapper">
<div id="navbar">
  <p> <a href="index.php">Home</a><br />
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
  <h1>Albums</h1>
  <?php
	
	$header = array("aid" => "aid", "title" => "Title", "date_created" => "Date Created", "date_modified" => "Date Modified");
		
	
	if ($mysqli->errno) {
		print($mysqli->error);
		exit();
	}
	
	print("<table>\n<thead><tr>\n");
	foreach ($header as $headitm) {
		if($headitm!="aid"){
		print("<th>$headitm</th>\n");
		}
	}
	print("</tr></thead>\n");
	
	$result = $mysqli->query("SELECT aid, title, date_created, date_modified FROM albums ORDER BY aid");
	if (!$result) {
		print($mysqli->error);
		exit();
	}
	
	while ($row = $result->fetch_assoc()) {
		print("<tr>\n");
		$aid=$row['aid'];
		$_SESSION['aid']=$aid;
		foreach ($row as $type => $item) {
			if($type!="aid"){
				
			if ($type =="date_modified") {
				$date = date('d M Y', $item);
				print("<td>$date</td>");
			} 
			else if ($type == "title"){
				print("<td><a href=\"album.php?aid=".$_SESSION['aid']."\">$item </a></td>");
			}
			else if ($type == "date_created"){
				$date = date('d M Y', $item);
				print("<td>$date</td>\n");
			}
			else {
				print("<td>$item</td>\n");
			}
			}
		}
		print("</tr>\n");
		
	}
	print("</table>");

?>
</div>
</div>
</div>

</body>
</html>