<html>
	<head>
		<title>Movie Database, Input page 2: Add Movie Information</title>
		<center><h1>Movie Database, Input page 2: Add Movie Information</h1></center>
	</head>
	
		<center>
	<table border="2">
		<tr>
			<th>
				<a href="I1.php">Add Actor or Director</a>
			</th>
			<th BGCOLOR="red">
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
	<h4>Fill in the following information to add a Movie to the Database!:</h4>
		<form action="./I2.php" method="GET">			
			<b>Title :</b><br> 
				<input type="text" name="title" maxlength="100" value=""><br/>
			<b>Company:</b><br> 
				<input type="text" name="comp" maxlength="50" value=""><br/>
			<b>Year :</b><br> 
				<input type="text" name="yr" maxlength="4" value=""><br/>	<!-- Todo: validation-->	
			<b>MPAA Rating :</b><br>
				<input type="radio" name="mpaa" value="G" checked> G 
				<input type="radio" name="mpaa" value="NC-17"> NC-17
				<input type="radio" name="mpaa" value="PG"> PG
				<input type="radio" name="mpaa" value="PG-13"> PG-13
				<input type="radio" name="mpaa" value="R"> R
			</select><br/>
			<b>Genre</b> :
			<table border="1" style="width:400px">
				<tr>
					<td><input type="checkbox" name="genre[]" value="Action">Action</input></td>
					<td><input type="checkbox" name="genre[]" value="Adult">Adult</input></td>
					<td><input type="checkbox" name="genre[]" value="Adventure">Adventure</input></td>
					<td><input type="checkbox" name="genre[]" value="Animation">Animation</input></td>
					<td><input type="checkbox" name="genre[]" value="Comedy">Comedy</input></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="genre[]" value="Crime">Crime</input></td>
					<td><input type="checkbox" name="genre[]" value="Documentary">Documentary</input</td>
					<td><input type="checkbox" name="genre[]" value="Drama">Drama</input></td>
					<td><input type="checkbox" name="genre[]" value="Family">Family</input></td>
					<td><input type="checkbox" name="genre[]" value="Fantasy">Fantasy</input></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="genre[]" value="Horror">Horror</input></td>
					<td><input type="checkbox" name="genre[]" value="Musical">Musical</input></td>
					<td><input type="checkbox" name="genre[]" value="Mystery">Mystery</input></td>
					<td><input type="checkbox" name="genre[]" value="Romance">Romance</input></td>
					<td><input type="checkbox" name="genre[]" value="Sci-Fi">Sci-Fi</input></td>
				</tr>
				<tr>
					<td><input type="checkbox" name="genre[]" value="Short">Short</input></td>
					<td><input type="checkbox" name="genre[]" value="Thriller">Thriller</input></td>
					<td><input type="checkbox" name="genre[]" value="War">War</input></td>
					<td><input type="checkbox" name="genre[]" value="Western">Western</input></td>
				</tr>
			</table> 

			<br/>
			<input type="submit" value="Add Movie"/>
		</form>
		<hr/>

	<?php
		$db_connection = mysql_connect("localhost", "cs143", "");
		mysql_select_db("CS143", $db_connection);
		
		
		//USER INPUTS
		
		$title=trim($_GET["title"]);
		$company=trim($_GET["comp"]);
		$year=$_GET["yr"];
		$mpaa=$_GET["mpaa"];
		$gen=$_GET["genre"];
		
		$currentMaxID = mysql_query("SELECT id FROM MaxMovieID", $db_connection) or die(mysql_error());
		$maxIDarr = mysql_fetch_array($currentMaxID);
		$realMaxID = $maxIDarr[0];
		$newMaxID = $realMaxID + 1;
		
		if($title=="" && $company=="" && $year=="")
		{
		
		}
		
		else if ($title=="")
		{
			echo "Invalid Movie Title. Try Again";
		}
		
		else if($year=="" || $year<=1800 || $year>=2100)
		{
			echo "Invalid Production year. Try Again";
		}
		
		else
		{
			$title = mysql_escape_string($title);
			
			$company = mysql_escape_string($company);
			
			$query = "INSERT INTO Movie (id, title, year, rating, company) VALUES('$newMaxID', '$title', '$year', '$mpaa', '$company')";
			
			$q = mysql_query($query, $db_connection) or die(mysql_error());
			
			mysql_query("UPDATE MaxMovieID SET id=$newMaxID WHERE id=$maxID", $db_connection) or die(mysql_error());
			
			for($i=0; $i < count($gen); $i++)
			{
				$gq = "INSERT INTO MovieGenre (mid, genre) VALUES ('$newMaxID', '$gen[$i]')";
				$g = mysql_query($gq, $db_connection) or die(mysql_error());
			}
			
			echo "We successfully added the new movie! The Movie id is $newMaxID).";
		}
		
		//close the database connection
		mysql_close($db_connection);
	?>


		
	</body>
</html>