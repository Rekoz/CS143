<html>
	<head>
		<title>Movie Database, Input page 5: Add Movie-Director relations</title>
		<center><h1>Movie Database, Input page 5: Add Movie-Director relations</h1></center>
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
			<th>
				<a href="I4.php">Add Movie Actor</a>
			</th>
			<th BGCOLOR="red">
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
	<h4>Fill in the following details for a new Movie-Actor relations:</h4>
		<form action="./I5.php" method="GET">	

<?php
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);
		$movieQuery=mysql_query("SELECT id, title, year FROM Movie ORDER BY title ASC", $db_connection) or die(mysql_error());
		$mList="";
		while ($row=mysql_fetch_array($movieQuery))
		{
			$id=$row["id"];
			$title=$row["title"];
			$year=$row["year"];
			$mList.="<option value=\"$id\">".$title." [".$year."]</option>";
		}
		$dirQuery=mysql_query("SELECT id, first, last, dob FROM Director ORDER BY first ASC", $db_connection) or die(mysql_error());
		$dList="";
		while ($row=mysql_fetch_array($dirQuery))
		{
			$id=$row["id"];
			$first=$row["first"];
			$last=$row["last"];
			$dob=$row["dob"];
			$dList.="<option value=\"$id\">".$first." ".$last." [".$dob."]</option>";
		}
		mysql_free_result($dirQuery);
		
?>		
			Movie:	<select name="mid">
						<?=$mList?>
					</select><br/>
			Director:	<select name="did">
						<?=$dList?>
					</select><br/>
			<br/>
			<input type="submit" value="Linking Director to Movie"/>
		</form>
		<hr/>

	<?php
		$mov=$_GET["mid"];
		$dir=$_GET["did"];
		
		if($mov=="" && $dir=="")
		{
		}
		else if($mov=="")
		{
			echo "Select a movie from the list!";
		}
		else if($dir=="")
		{
			echo "Select a director from the list!";
		}
		else
		{
            $dir = mysql_escape_string($dir);		
			$mov = mysql_escape_string($mov);
			
			
			$query = "INSERT INTO MovieDirector (mid, did) VALUES('$mov', '$dir')";
						
			$q = mysql_query($query, $db_connection) or die(mysql_error());

			echo "You linked the Movie and Director!";
		}

		mysql_close($db_connection);
	?>


		
	</body>
</html>