<html>
	<head>
		<title>Movie Database, Input page 4: Add Movie-Actor relations </title>
		<center><h1>Movie Database, Input page 4: Add Movie-Actor relations </h1></center>
	</head>	
	
		<center>
	<table border="2">
		<tr>
			<th>
				<a href="I1.php">Add Actor or Director</a>
			</th>
			<th>
				<a href="I2.php">Add Movie Info</a>
			</th>
			<th>
				<a href="I3.php">Add Movie Comment</a>
			</th>
			<th BGCOLOR="red">
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
	<h4>Fill in the following details for Movie-Actor relations:</h4>
		<form action="./I4.php" method="GET">	

<?php
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);
		$movieQuery=mysql_query("SELECT id, title, year FROM Movie ORDER BY title ASC", $db_connection) or die(mysql_error());
		$mList="";
		while ($row=mysql_fetch_array($movieQuery))
		{
		    $title=$row["title"];
			$year=$row["year"];
			$id=$row["id"];
			$mList.="<option value=\"$id\">".$title." [".$year."]</option>";
		}
		$actorQuery=mysql_query("SELECT id, first, last, dob FROM Actor ORDER BY first ASC", $db_connection) or die(mysql_error());
		$aList="";
		while ($row=mysql_fetch_array($actorQuery))
		{
			$id=$row["id"];
			$first=$row["first"];
			$last=$row["last"];
			$dob=$row["dob"];
			$aList.="<option value=\"$id\">".$first." ".$last." [".$dob."]</option>";
		}
		
		mysql_free_result($actorRS);
?>		
			Movie:	<select name="mid">
						<?=$mList?>
					</select><br/>
			Actor:	<select name="aid">
						<?=$aList?>
					</select><br/>
			Role:	<input type="text" name="role" value="" maxlength="50"><br/>
			<br/>
			<input type="submit" value="Linking Actor to Movie"/>
		</form>
		<hr/>

	<?php
	    $mov=$_GET["mid"];
		$act=$_GET["aid"];
		$role=trim($_GET["role"]);

		if($mov=="" && $act=="" && $role==""){}
		else if($mov=="")
		{
			echo "Select a movie from the list!";
		}
		else if($act=="")
		{
			echo "Select an Actor from the list!";
		}
		else 
		{
			$act = mysql_escape_string($act);
			$role = mysql_escape_string($role);
			$mov = mysql_escape_string($mov);

			$query = "INSERT INTO MovieActor (mid, aid, role) VALUES('$mov', '$act', '$role')";
			$q = mysql_query($query, $db_connection) or die(mysql_error());
			echo "You linked the Movie and Actor!";
		}
		mysql_close($db_connection);
	?>
	</body>
</html>