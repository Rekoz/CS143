<html>
	<head>
		<title>Movie Database, Input page 5: Add Movie-Director relations</title>
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.min.js"></script>
		<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
		<script type="text/javascript">
			angular.module('Search', ['ngMaterial', 'ngMessages'])
				.controller('AppCtrl', function($scope) {
				});
		</script>
	</head>
	
<body ng-app="Search" ng-cloak>

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
			<md-button type="submit" value="Linking Director to Movie" class="md-raised md-primary">
				Submit
			</md-button>
		</form>
	<md-divider></md-divider>

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
	</md-content>
</div>

		
	</body>
</html>