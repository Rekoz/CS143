<html>
	<head>
		<title>Movie Database, Input page 1: Add Actor/Director</title>
		<center><h1>Movie Database, Input page 1: Add Actor/Director</h1></center>
	</head>
	
		<center>
	<table border="2">
		<tr>
			<th BGCOLOR="red">
				<a href="I1.php">Add Actor or Director</a>
			</th>
			<th>
				<a href="I2.php">Add Movie Info</a>
			</th>
			<th>
				<a href="I3.php">Add Movie Comment</a>
			</th>
			<th>
				<a href="I4.php">Add Movie Actor</a>
			</th>
			<th>
				<a href="I5.php">Add Movie Director</a>
			</th>
			<th>
				<a href="B1.php">Browse Actor Info</a>
			</th>
			<th>
				<a href="B2.php">Browse Movie Info</a>
			</th>
			<th>
				<a href="S.php">Search</a>
			</th>
		</tr>
	</table>
	</center>
	
	<body BGCOLOR="#33fff3">
	<h4><u>Fill in the following information to add a new Actor or Director to the Database!:</u></h4>
		<form action="./I1.php" method="GET">
			So are you adding an Actor or Director?:</b><br>
				<input type="radio" name="per" value="Actor" checked> Actor
			    <input type="radio" name="per" value="Director"> Director <br>
			<b>First/Given Name?:</b><br>
				<input type="text" name="first" maxlength="20" value=""><br>
			<b>Last/Family Name?:</b><br>	
				<input type="text" name="last" maxlength="20" value=""><br>
			<b>Sex?:</b><br>	
				<input type="radio" name="sex" value="Male" checked> Male
				<input type="radio" name="sex" value="Female"> Female<br>		
			<b>Date of Birth?:</b><br>	
				<input type="text" name="dob" maxlength="10" value="<?php echo htmlspecialchars($_GET['dob']);?>"> (YYYY-MM-DD)<br>
			<b>Date of Death?:</b><br>	
				<input type="text" name="dod" maxlength="10" value="<?php echo htmlspecialchars($_GET['dod']);?>"> (YYYY-MM-DD), if applicable)<br>
			<br/>
			<input type="submit" value="Add Actor/Director"/>
		</form>
		<hr/>

	<?php
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);
		
		//USER INPUTS
		
		$person=trim($_GET["per"]);
		$first=trim($_GET["first"]);
		$last=trim($_GET["last"]);
		$sex=trim($_GET["sex"]);
		$DOB=trim($_GET["dob"]);
		$DOD=trim($_GET["dod"]);
		
		$dateDOB = date_parse($DOB);
		$dateDOD = date_parse($DOD);
		
		$currentMaxID = mysql_query("SELECT id FROM MaxPersonID", $db_connection) or die(mysql_error());
		$maxIDarr = mysql_fetch_array($currentMaxID);
		$realMaxID = $maxIDarr[0];
		$newMaxID = $realMaxID + 1;
		
		if($DOD=="" && $DOD=="" && $first=="" && $last==""){}
	    else if($first=="" || $last=="")
		{
			echo "You must enter a valid first and last name.";
		}
		else if($DOB=="" || !checkdate($dateDOB["month"], $dateDOB["day"], $dateDOB["year"]))
		{
			echo "Invalid DOB, try again";
		}
		else if($DOD!="" && !checkdate($dateDOD["month"], $dateDOD["day"], $dateDOD["year"]))
		{
			echo "The DOD specified is Invalid";
		}
		else if(preg_match('/[^A-Za-z\s\'-]/', $first) || preg_match('/[^A-Za-z\s\'-]/', $last))
		{
			echo "You entered an invalid character for names, only letters, - and ' allowed";
		}
		else
		{
			$last = mysql_escape_string($last);
			$first = mysql_escape_string($first);
		
			if($person=="Actor")
			{
				if($DOD!="")
				{
					$query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$newMaxID', '$last', '$first', '$sex', '$DOB', '$DOD')";
				}
				else
				{
					$query = "INSERT INTO Actor (id, last, first, sex, dob, dod) VALUES('$newMaxID', '$last', '$first', '$sex', '$DOB', NULL)";
				}
			}
			else if($person=="Director")
			{
				if($DOD!="")
					$query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$newMaxID', '$last', '$first', '$DOB', '$DOD')";
				else
					$query = "INSERT INTO Director (id, last, first, dob, dod) VALUES('$newMaxID', '$last', '$first', '$DOB', NULL)";
			}

			$q = mysql_query($query, $db_connection) or die(mysql_error());
			mysql_query("UPDATE MaxPersonID SET id=$newMaxID WHERE id=$realMaxID", $db_connection) or die(mysql_error());
			echo "New $person added (with id=$newMaxID).";
		}
		mysql_close($db_connection);
	?>
	
	</body>
</html>


