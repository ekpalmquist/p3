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
<title>Add</title>
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
    <div id="transparent"> </div>
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
      <h2>Add</h2>
      <form action="add.php" enctype="multipart/form-data" method="post" id="addphoto" onsubmit="return validAll();">
        <p>
          <label class="photos">Add New Photo: </label>
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
          url:
          <input id="url" type="text" name="url" onchange="validUrl(this.value);"/>
          <span id="urlmsg">*</span>
          <label for="file">Filename:</label>
          <input type="file" name="image" id="file" />
          Caption:
          <input id="caption" type="text" name="caption" onchange="validCaption(this.value);"/>
          <span id="captionmsg">*</span> Date Taken: 
          Year:
          <input id="year" type="text" name="year" onchange="validYear(this.value);"/>
          <span id="yearmsg">*</span> Month:
          <select id="month" name="month" onchange="validMonth(this.value);"/>
          
          <option id="selectmonth">select month:</option>
          <option>01</option>
          <option>02</option>
          <option>03</option>
          <option>04</option>
          <option>05</option>
          <option>06</option>
          <option>07</option>
          <option>08</option>
          <option>09</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          </select>
          <span id="monthmsg">*</span> Day:
          <select id="day" name="day" onchange="validDay(this.value);"/>
          
          <option id="selectday">select day:</option>
          <option>01</option>
          <option>02</option>
          <option>03</option>
          <option>04</option>
          <option>05</option>
          <option>06</option>
          <option>07</option>
          <option>08</option>
          <option>09</option>
          <option>10</option>
          <option>11</option>
          <option>12</option>
          <option>13</option>
          <option>14</option>
          <option>15</option>
          <option>16</option>
          <option>17</option>
          <option>18</option>
          <option>19</option>
          <option>20</option>
          <option>21</option>
          <option>22</option>
          <option>23</option>
          <option>24</option>
          <option>25</option>
          <option>26</option>
          <option>27</option>
          <option>28</option>
          <option>29</option>
          <option>30</option>
          <option>31</option>
          </select>
          <span id="daymsg">*</span> <span id="submitmsg">&nbsp;</span>
          <input type="submit" name="newpicture" value="Add photo" />
        </p>
      </form>
      <?php
	$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
 		function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 $errors=0;
 
  define ("MAX_SIZE","5000"); 
 
 
	if (isset($_POST['newpicture'])) {
		$check = true;
		$check &= ($_POST["url"]!="" && $_POST["caption"] != "" && $_POST["year"] != "" && $_POST["month"] != "" && $_POST["day"] != "");
		
 	$image=$_FILES['image']['name'];
 	//if it is not empty
 	if ($image) 
 	{
 	//get the original name of the file from the clients machine
 		$filename = stripslashes($_FILES['image']['name']);
 	//get the extension of the file in a lower case format
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
 	//if it is not a known extension, we will suppose it is an error and 
        // will not  upload the file,  
	//otherwise we will do more tests
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension !=
 "png") && ($extension != "gif")) 
 		{
		//print error message
 			echo '<p>Unknown extension</p>';
 			$errors=1;
 		}
 		else
 		{
 //$_FILES['image']['tmp_name'] is the temporary filename of the file
 //in which the uploaded file was stored on the server
 $size=filesize($_FILES['image']['tmp_name']);

//compare the size with the maxim size we defined and print error if bigger
if ($size > MAX_SIZE*1024)
{
	echo '<p>You have exceeded the size limit</p>';
	$errors=1;
}

//we will give an unique name, for example the time in unix time format
$image_name=$_POST['url'].'.'.$extension;
//the new name will be containing the full path where will be stored (images 
//folder)
$newname="images/".$image_name;
//we verify if the image has been uploaded, and print error instead
$copied = copy($_FILES['image']['tmp_name'], $newname);
if (!$copied) 
{
	echo '<p>Copy unsuccessfull!</p>';
	$errors=1;
}}}

//If no errors registred, print the success message
 if(isset($_POST['newpicture']) && !$errors) 
 {
 	echo "<p>Files upload successful</p>";
 }

 
		$result=$mysqli->query("SELECT MAX(pid) FROM photos");
		if (!$result) {
			print($mysqli->error);
			exit();
		}
		$pid="";
		
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $type => $item) {
				$pid=$item;
			}
		}
		$pid=$pid+1;
		$sequence="SELECT MAX(sid) FROM sequences WHERE aid=".$_POST['title'];
        $result= $mysqli->query($sequence);
        if (!$result) {
                print($mysqli->error);
                exit();
                }
        $sid="";
        while ($row = $result->fetch_assoc()){
                foreach ($row as $type => $item) {
                $sid=$item;
            }
        }
		$sid=$sid+1;
		if ($check) {
			$url=trim(strip_tags($_POST['url']));
			$caption=trim(strip_tags($_POST['caption']));
			$date=trim(strip_tags($_POST['year']))."-".trim(strip_tags($_POST['month']))."-".trim(strip_tags($_POST['day']));
			$query = "INSERT INTO photos VALUES('$caption', '$url', '$date', '$pid')";
			$mysqli->query($query);
			$query2= "INSERT INTO sequences VALUES('$sid', '$pid', '".$_POST['title']."')"; 
            $mysqli->query($query2);
			$check=false;
		}
	}
?>
      <form action="add.php" method="post" id="reusephoto" onsubmit="return validReuse();">
        <p>
          <label class="photos">Reuse Photo: </label>
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
          url:
          <select name="url" onchange="validUrl(this.value);">
            <?php
                $result = $mysqli->query("SELECT date_taken, url FROM photos");
            if (!$result) {
                print($mysqli->error);
                exit();
                }
                while ($row = $result->fetch_assoc()){
                $aid="";
                foreach ($row as $type => $item) {
                if($type=="date_taken"){
					$date=$item;
				}
                if($type=="url"){
                print("<option value=\"$item\">$item ($date)</option>");
                }
                }
                }
            ?>
          </select>
          <span id="urlmsg">*</span> Caption:
          <input id="caption2" type="text" name="caption" onchange="validCaption(this.value);"/>
          <span id="captionmsg">*</span>
          <input type="submit" name="newpicture2" value="Add photo" />
        </p>
      </form>
      <?php
	$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
	if (isset($_POST['newpicture2'])) {
		$check = true;
		$check &= ($_POST["url"]!="" && $_POST["caption"] != "");
		$dates=$mysqli->query("SELECT date_taken FROM photos WHERE url='".$_POST['url']."'");
		if (!$dates) {
			print($mysqli->error);
			exit();
		}
		
		while ($row = $dates->fetch_assoc()) {
			foreach ($row as $type => $item) {
				$date=$item;
				
			}
		}
		$result=$mysqli->query("SELECT MAX(pid) FROM photos");
		if (!$result) {
			print($mysqli->error);
			exit();
		}
		$pid="";
		
		while ($row = $result->fetch_assoc()) {
			foreach ($row as $type => $item) {
				$pid=$item;
			}
		}
		$pid=$pid+1;
		$sequence="SELECT MAX(sid) FROM sequences WHERE aid=".$_POST['title'];
        $result= $mysqli->query($sequence);
        if (!$result) {
                print($mysqli->error);
                exit();
                }
        $sid="";
        while ($row = $result->fetch_assoc()){
                foreach ($row as $type => $item) {
                $sid=$item;
            }
        }
		$sid=$sid+1;
		if ($check) {
			$url=trim(strip_tags($_POST['url']));
			$caption=trim(strip_tags($_POST['caption']));
			$query = "INSERT INTO photos VALUES('$caption', '$url', '$date', '$pid')";
			$mysqli->query($query);
			$query2= "INSERT INTO sequences VALUES('$sid', '$pid', '".$_POST['title']."')"; 
            $mysqli->query($query2);
			$check=false;
		}
	}
	?>
      <form action="add.php" method="post" id="addalbum" onsubmit="return validAddalbum();">
        <p>
          <label class="albums">Add Album: </label>
          <br/>
          Title:
          <input id="title" type="text" name="title" onchange="validTitle(this.value);"/>
          <span id="titlemsg">*</span> <span id="submit2msg">&nbsp;</span>
          <input type="submit" name="newalbum" value="Add album" />
        </p>
      </form>
      <?php
	$header = array("aid" => "aid", "title" => "Title", "date_created" => "Date Created", "date_modified" => "Date Modified");
		
	if (isset($_POST['newalbum'])) {
		$check = true;
		$check &= ($_POST["title"]!="");
		
		$result=$mysqli->query("SELECT MAX(aid) FROM albums");
		if (!$result) {
			print($mysqli->error);
			exit();
		}
		$aid="";
		
		while($row = $result->fetch_assoc()) {
			foreach ($row as $type => $item) {
				$aid=$item;	
			}
		}
		$aid=$aid+1;
		if ($check) {
			$title=trim(strip_tags($_POST["title"]));
			$query = "INSERT INTO albums VALUES('$aid', '$title',".time().",".time().")";
			$mysqli->query($query);
			$check=false;
		}	
	}
	
	}
	else{
		print("<div id=\"error\"><p>Please login to add content<br />Go to our <a href=\"index.php\">Log in</a></p></div>");
	}
?>
    </div>
  </div>
</div>
</body>
</html>