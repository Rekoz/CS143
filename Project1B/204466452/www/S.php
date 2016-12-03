<html>
<head>
	<title>Search</title>
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
			<form name="projectForm" action="" method="GET">
				<md-input-container class="md-block">
					<label>Search for actors or movies</label>
					<input required type="text" name="searchfield" ng-model="project.searchfield">
					<div ng-messages="projectForm.searchfield.$error">
		       			<div ng-message="required">This is required.</div>
		        	</div>
		        </md-input-container>
		        <md-button type="submit" class="md-raised md-primary">
					Submit
				</md-button>
			</form>
		</md-content>
	</div>

	<md-list>

		<?php
			// Connect to database
			$db_connection = mysql_connect("localhost", "cs143", "");
			if(!$db_connection) {
			    $errmsg = mysql_error($db_connection);
			    print "Connection failed: $errmsg <br />";
			    exit(1);
			}

			// Get input
			$keyword = mysql_real_escape_string($_GET["searchfield"]);
			if (empty($keyword)) die();
			$words = preg_split('/\s+/', trim($keyword));
			$length = count($words);

			// Form query
			if ($length == 1)
				$actor_query = "SELECT id, first, last, dob FROM Actor WHERE first LIKE '%$keyword%' OR last LIKE '%$keyword%' ORDER BY first";
			if ($length == 2)
				$actor_query = "SELECT id, first, last, dob FROM Actor WHERE (first LIKE '%$words[0]%' AND last LIKE '%$words[1]%') OR (first LIKE '%$words[1]%' AND last LIKE '%$words[0]%') ORDER BY first";
			$where = "title LIKE '%$words[0]%'";
			for ($i = 1; $i < $length; $i++)
				$where .= "AND title LIKE '%$words[$i]%'";
			$movie_query = "SELECT id, title, year FROM Movie WHERE $where ORDER BY title";

			// Implement query
			mysql_select_db("CS143", $db_connection);
			$actor_rs = mysql_query($actor_query, $db_connection) or die(mysql_error($db_connection));
			$movie_rs = mysql_query($movie_query, $db_connection) or die(mysql_error($db_connection));
		?>

			
		<md-subheader class="md-no-sticky">Actors</md-subheader>
		<?php
			// Print result
			while($row = mysql_fetch_row($actor_rs)) {
				echo '<md-list-item class="md-2-line">';
				echo '<div class="md-list-item-text">';
				echo "<h3><a href='B1.php?aid={$row[0]}'>", $row[1], " ", $row[2], "</a></h3>";
				echo "<p>", $row[3], "</p>";
				echo '</div>';
				echo '</md-list-item>';
			}
		?>

		<md-subheader class="md-no-sticky">Movies</md-subheader>
		<?php
			while($row = mysql_fetch_row($movie_rs)) {
				echo '<md-list-item class="md-2-line">';
				echo '<div class="md-list-item-text">';
				echo "<h3><a href='B2.php?mid={$row[0]}'>", $row[1], "</a></h3>";
				echo "<p>", $row[2], "</p>";
				echo '</div>';
				echo '</md-list-item>';
			}
			// Close database connection
			mysql_close($db_connection);
		?>
	</md-list>

</body>
</html>