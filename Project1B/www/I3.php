<html>
	<head>
		<title>Movie Database, Input page 3: Add Comments about Movies</title>
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
		<script type="text/javascript">
			angular.module('I3', ['ngMaterial', 'ngMessages'])
				.controller('AppCtrl', function($scope) {
				});
		</script>
	</head>
	
<body ng-app="I3" ng-cloak>
<div ng-controller="AppCtrl" ng-cloak>
	<md-content>
		<md-toolbar>
			<div class="md-toolbar-tools">
				<md-button href="I1.php">
					Add Actor or Director
				</md-button>
				<md-button href="I2.php">
					Add Movie Info
				</md-button>
				<md-button href="I3.php">
					Add Movie Comment
				</md-button>
				<md-button href="I4.php">
					Add Movie Actor
				</md-button>
				<md-button href="I5.php">
					Add Movie Director
				</md-button>
				<md-button href="B1.php">
					Browse Actor Info
				</md-button>
				<md-button href="B2.php">
					Browse Movie Info
				</md-button>
				<md-button href="S.php">
					Search
				</md-button>
			</div>
		</md-toolbar>
	</md-content>

	<md-content layout-padding>
		<h4>Fill the information to add a comment to a Movie!:</h4>
		<form name="projectionForm" action="./I3.php" method="GET">	

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
			<md-input-container class="md-block">
				<label>Your Name:</label>
				<input required type="text" name="name" maxlength="20">
				<div ng-messages="projectForm.name.$error">
	       			<div ng-message="required">This is required.</div>
	        	</div>
        	</md-input-container>
			Rating:<br>
				<input type="radio" name="rating" value="5"> 5/5
				<input type="radio" name="rating" value="4"> 4/5
				<input type="radio" name="rating" value="3"> 3/5
				<input type="radio" name="rating" value="2"> 2/5
				<input type="radio" name="rating" value="1"> 1/5 
			<br>
			Comments: <br><textarea name="comment" cols="80" rows="10" value=><?php echo htmlspecialchars($_GET['comment']);?></textarea><br>
			<br/>
			<md-button type="submit" value="Submit Review" class="md-raised md-primary">
				Submit
			</md-button>
		</form>
	</md-content>

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
			echo "<a href=\"B2.php?mid=".$MRmid."\">Back to Movie</a>";
			
		}
		mysql_close($db_connection);
?>
</div>


		
	</body>
</html>