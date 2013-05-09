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
<title>photo</title>
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
<h1>Photos</h1>
   
<?php
	$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
	$check = true;
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
	$result = $mysqli->query("SELECT caption, url FROM photos NATURAL JOIN sequences WHERE pid='".$_REQUEST['pid']."'");
	if (!$result) {
		print($mysqli->error);
		exit();
	}
	$p="";
	if($result->num_rows==0) {
                print("<p>This album has no content.<br />");
				print("<a href=\"albums.php\">Back to all albums</a></p>");
            }
            else {
				print("<table>\n<thead><tr><th>\n");
				
				print("</th></tr></thead>\n");
	while ($row = $result->fetch_assoc()) {
		print("<tr>\n");
		
		foreach ($row as $type => $item) {
			$p=$p+1;
			
			if($type=="caption"){
				$caption=$item;
			}
			if ($type == "url"){
				
				$pic="images/$item";
				print("<td class=\"image\"><img id=\"$item$p\" src=\"images/$item\" alt=\"$item\"  width=\"450\"  /><br />$caption<br /></td>");
			}
		}
		print("</tr>\n");
	}
	print("</table>"); 
			}
		
	?>
    </div>
    </div>
    </div>
        </body>
</html>
