<html>
<head>
	<title>Actor Info</title>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
	<script type="text/javascript">
		angular.module('actor_browsing', ['ngMaterial'])
			.controller('AppCtrl', function($scope) {
			});
	</script>
</head>

<body ng-app="actor_browsing" ng-cloak>

		<?php

			// Connect to database
			$db_connection = mysql_connect("localhost", "cs143", "");
			if(!$db_connection) {
			    $errmsg = mysql_error($db_connection);
			    print "Connection failed: $errmsg <br />";
			    exit(1);
			}

			// Get input
			$aid = mysql_real_escape_string($_GET["aid"]);
			if (empty($aid)) $aid=-1;

			// Form query
			$actor_query = "SELECT first, last, sex, dob, dod FROM Actor WHERE $aid = id";
			$movie_query = "SELECT m.id, ma.role, m.title FROM Movie m, MovieActor ma WHERE ma.aid=$aid AND ma.mid=m.id";

			// Implement query
			mysql_select_db("CS143", $db_connection);
			$actor_rs = mysql_query($actor_query, $db_connection) or die(mysql_error($db_connection));
			$movie_rs = mysql_query($movie_query, $db_connection) or die(mysql_error($db_connection));
			$row = mysql_fetch_row($actor_rs);
			if ($row[4] == "") $row[4] = "Still alive";

		?>

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

			<md-content class="md-padding" layout="column">
				<md-card>
					<md-card-title>
						<md-card-title-text>
							<span class="md-headline"><?php echo $row[0], ' ', $row[1]; ?></span>
							<span class="md-subhead">Sex: <?php echo $row[2];?></span>
							<span class="md-subhead">Date of birth: <?php echo $row[3];?></span>
							<span class="md-subhead">Date of birth: <?php echo $row[4];?></span>
						</md-card-title-text>
					</md-card-title>
				</md-card>
			</md-content>
		</div>

		<md-list>
			<md-subheader class="md-no-sticky">
				Movies
			</md-subheader>
			<?php
				while($row = mysql_fetch_row($movie_rs)) {
					echo '<md-list-item class="md-2-line">';
					echo '<div class="md-list-item-text">';
					echo "<h3><a href='B2.php?mid={$row[0]}'>", $row[2], "</a></h3>";
					echo "<p>Role: ", $row[1], "</p>";
					echo '</div>';
					echo '</md-list-item>';
				}
				// Close database connection
				mysql_close($db_connection);
			?>
		</md-list>

</body>
</html>