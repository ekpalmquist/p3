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
<title>Update</title>
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
<h2>Update</h2>
<div id="updateAlbum">
  <form method="post" id="updates" action="update.php" onsubmit="return validAlbum();">
    <p>
      <label> Update Album </label>
      <br/>
      Album Title:
      <select name="oldtitle">
        <?php
			$header = array("aid" => "aid", "title" => "Title", "date_created" => "Date Created", "date_modified" => "Date Modified");
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
      New Title:
      <input id="title" type="text" name="newtitle" onchange="validTitle(this.value);"/>
      <span id="titlemsg">*</span> <span id="submitmsg">&nbsp;</span>
      <input id="submit" type="submit" name="updateAlbum"  value="UpdateAlbum"/>
    </p>
  </form>
  <br/>
</div>
<?php
		
    if (isset($_POST['updateAlbum'])) {
        $check = true;
        
        if ($check) {
            if($_POST['newtitle']!=""){
            $query = "UPDATE albums SET title='".trim(strip_tags($_POST['newtitle']))."' WHERE aid=".$_POST['oldtitle']; 
            $mysqli->query($query);
            }
            $query2= "UPDATE albums SET date_modified='".time()."' WHERE aid=".trim(strip_tags($_POST['oldtitle']));
            $mysqli->query($query2);
            $check=false;
        }
	}
        

    ?>
<div id="updatePhoto">
  <form method="post" id="updatephotos" action="update.php" onsubmit="return validPhoto();">
    <p>
      <label> Update Photo </label>
      <br/>
      Photo Url:
      <select name="oldurl">
        <?php
			$header = array("caption" => "Caption", "url" => "url", "date_taken" => "Date Taken", "pid" => "pid");
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
				if($type=="pid"){
                    $pid=$item;
                    }
                if($type=="url"){
                print("<option value=\"$pid\">$item from $title</option>");
                }
                }
                }
            ?>
      </select>
      New Url:
      <input id="photoUrl" type="text" name="newurl" onchange="validUrl(this.value);"/>
      <span id="urlmsg">&nbsp;</span> New Caption:
      <input id="newcaptionPhoto" type="text" name="newcaption" onchange="validCaption(this.value);"/>
      <span id="captionmsg">&nbsp;</span> New Date Taken:
      Year:
      <input id="newyear" type="text" name="newyear" onchange="validYear(this.value);"/>
      <span id="yearmsg">&nbsp;</span> Month:
      <select id="newmonth" name="newmonth" onchange="validMonth(this.value);">
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
      <span id="monthmsg">&nbsp;</span> Day:
      <select id="newday" name="newday" onchange="validDay(this.value);">
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
      <span id="daymsg">&nbsp;</span> <span id="submit2msg">&nbsp;</span>
      <input id="submit2" type="submit" name="updatePhoto"  value="UpdatePhoto"/>
    </p>
  </form>
  <br/>
</div>
<?php
    if (isset($_POST['updatePhoto'])) {
        $check = true;
        
        if ($check) {
            if($_POST['newurl']!=""){
            $query = "UPDATE photos SET url='".trim(strip_tags($_POST['newurl']))."' WHERE pid=".trim(strip_tags($_POST['oldurl'])); 
            $mysqli->query($query);
            }
            if($_POST['newcaption'] != ""){
            $query1= "UPDATE photos SET caption='".trim(strip_tags($_POST['newcaption']))."' WHERE pid=".trim(strip_tags($_POST['oldurl']));  
            $mysqli->query($query1);
            }
            if($_POST['newyear'] != "" && $_POST['newmonth'] != "" && $_POST['newday'] != ""){
            $newdate=trim(strip_tags($_POST['newyear']))."-".trim(strip_tags($_POST['newmonth']))."-".trim(strip_tags($_POST['newday']));
            $query2= "UPDATE photos SET date_taken='$newdate' WHERE pid=".trim(strip_tags($_POST['oldurl']));
            $mysqli->query($query2);
            }
            $check=false;
        } 
	}
	}
	else{
		print("<div id=\"error\"><p>Please login to update content<br />Go to our <a href=\"index.php\">Log in</a></p></div>");
	}
    ?>
    </div>
    </div>
    </div>
</body>
</html>