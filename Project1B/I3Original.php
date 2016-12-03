<html>
	<head>
		<title>Movie Database, Input page 3: Add Comments about Movies</title>
		<center><h1>Movie Database, Input page 3: Add Comments about Movies</h1></center>
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
			<th BGCOLOR="red">
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
	<h4>Fill the information to add a comment to a Movie!:</h4>
		<form action="./I3.php" method="GET">	

<?php
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);
		$movieQuery=mysql_query("SELECT id, title, year FROM Movie ORDER BY title ASC", $db_connection) or die(mysql_error());
		$mList="";
		
		$MID=$_GET['id'];
		
		while ($row=mysql_fetch_array($movieQuery))
		{
			$id=$row["id"];
			$title=$row["title"];
			$year=$row["year"];
			if($id==$MID)
				$mList.="<option value=\"$id\" selected>".$title." [".$year."]</option>";
			else
				$mList.="<option value=\"$id\">".$title." [".$year."]</option>";	
		}
	
?>

			Movie:  <select name="id">
						<?=$mList?>
					</select><br/>
			Your Name:<br>
			<input type="text" name="name" value="" maxlength="20"><br/>
			Rating:<br>
				<input type="radio" name="rating" value="5"> 5/5
				<input type="radio" name="rating" value="4"> 4/5
				<input type="radio" name="rating" value="3"> 3/5
				<input type="radio" name="rating" value="2"> 2/5
				<input type="radio" name="rating" value="1"> 1/5 
			Comments: <br/><textarea name="comment" cols="80" rows="10" value=><?php echo htmlspecialchars($_GET['comment']);?></textarea><br/>
			<br/>
			<input type="submit" value="Submit Review"/>
		</form>
		<hr/>


<?php

        //USER INPUTS
        $MRname=trim($_GET["name"]);
		$MRmid=$_GET["id"];
		$rat=$_GET["rating"];
		$comm=trim($_GET["comment"]);
		if($MRname=="" && $rat=="" && $comm==""){}
		else if($MRmid=="")
		{
			echo "You must select a movie from the list.";
		}
		else if ($rat=="")
		{
			echo "You must select a valid rating.";
		}
		else
		{
		    if($MRname == ""){$MRname = "Undisclosed";}
			$MRmid = mysql_escape_string($MRmid);
			$comm = mysql_escape_string($comm);
			$MRname = mysql_escape_string($MRname);

			
			$query = "INSERT INTO Review (name, time, mid, rating, comment) VALUES('$MRname', now(), '$MRmid', '$rat', '$comm')";
            $q = mysql_query($query, $db_connection) or die(mysql_error());
			echo "Movie Review has been successfully added!<br/>";
			echo "<a href=\"B2.php?id=".$MRmid."\">Back to Movie</a>";
			
		}
		mysql_close($db_connection);
?>


		
	</body>
</html>