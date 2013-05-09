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
<title>album</title>
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
    
<?php
	
	$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
	
		$check = true;
		if ($mysqli->errno) {
			print($mysqli->error);
			exit();
		}
		$result = $mysqli->query("SELECT aid, title FROM albums WHERE aid=".$_REQUEST['aid']);
        if (!$result) {
                	print($mysqli->error);
                	exit();
                }
                while ($row = $result->fetch_assoc()){
                	foreach ($row as $type => $item) {
                		if($type=="title"){
                			print("<h1>$item</h1>");
                		}
               		}
                }
			$query = "SELECT caption, url, DATE_FORMAT(date_taken, '%e %b %Y'), pid FROM photos NATURAL JOIN sequences WHERE aid=".$_REQUEST['aid'];
			 $result = $mysqli->query($query);
                if (!$result) {
                    print($mysqli->error);
                    exit();
                }
				 if($result->num_rows==0) {
                print("<p>This album has no content.<br />");
				print("<a href=\"albums.php\">Back to all albums</a></p>");
            }
            else {
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
						if($type!='pid'){
			
							if ($type == "url"){
								print("<td class=\"image\"><a href=\"photo.php?pid=".$row['pid']."\"><img  src=\"images/$item\" alt=\"$item\" width=\"48\" height=\"48\" /></a></td>");
							}
							else {
								print("<td>$item</td>\n\n");
							}
						}
					}
					print("</tr>\n");
				}
				print("</table>");
				print("<p><a href=\"albums.php\">Back to all albums</a></p>");
			}
				

?>
</div>
</div>
</div>
</body>
</html>