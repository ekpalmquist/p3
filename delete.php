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
<title>Delete</title>
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
?>
</div>
<div id="input">
<h2>Delete</h2>
<form id="deletephoto" action="delete.php" method="post" onsubmit="return validDeletephoto();">
  <p>
    <label class="photos">Delete Photo: </label>
    <br/>
    Photo ID:
    <select name="photoid">
      <?php
                $result = $mysqli->query("SELECT pid, title, url FROM photos NATURAL JOIN sequences NATURAL JOIN albums");
            	if (!$result) {
                	print($mysqli->error);
               		exit();
                }
                while ($row = $result->fetch_assoc()){
                	$pid="";
               		foreach ($row as $type => $item) {
                		if($type=="title"){
							$title=$item;
						}
						else if($type=="pid"){
                    		$pid=$item;
                    	}
                		else if($type=="url"){
               				print("<option value=\"$pid\">$pid ($item from $title)</option>");
                		}
                	}
                }
            ?>
    </select>
    <span id="idmsg">*</span> <span id="submitmsg">&nbsp;</span>
    <input type="submit" name="deletepicture" value="Delete photo" />
  </p>
</form>
<?php
	$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
	
	if (isset($_POST['deletepicture'])) {
		$check = true;
		if ($check) {
			
			$query = "DELETE FROM photos WHERE pid=".$_POST['photoid'];
			$mysqli->query($query);
			$query2= "DELETE FROM sequences WHERE pid=".$_POST['photoid']; 
            $mysqli->query($query2); 
			$check=false;
		}
	}
?>
<form action="delete.php" method="post">
  <p>
    <label class="albums">Delete Album: </label>
    <br/>
    <br/>
    Album Title:
    <select name="title">
      <?php
                $result = $mysqli->query("SELECT aid, title FROM albums");
            if (!$result) {
                print($mysqli->error);
                exit();
                }
                while ($row = $result->fetch_assoc()){
                $aid="";
                foreach ($row as $type => $item) {
                if($type=="aid"){
                    $aid=$item;
                    }
                if($type=="title"){
                print("<option value=\"$aid\">$item</option>");
                }
                }
                }
       ?>
    </select>
    <span class="titlemsg">*</span> <span id="submit2msg">&nbsp;</span>
    <input type="submit" name="deletealbum" value="Delete album" />
  </p>
</form>
<?php
	$header = array("aid" => "aid", "title" => "Title", "date_created" => "Date Created", "date_modified" => "Date Modified");
	
	if (isset($_POST['deletealbum'])) {
		$check = true;
		if ($check) {
			
			$query = "DELETE FROM albums WHERE aid=".$_POST['title'];
			$mysqli->query($query);
			$query2= "DELETE FROM sequences WHERE aid=".$_POST['title']; 
            $mysqli->query($query2); 
			$check=false;
		}
	}
	}
else{
		print("<div id=\"error\"><p>Please login to delete content<br />Go to our <a href=\"index.php\">Log in</a></p></div>");
	}
?>
</div>
</div>
</div>
</body>
</html>
