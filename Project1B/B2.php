<html>
<head>
	<title>Movie Info</title>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
	<script type="text/javascript">
		angular.module('movie_browsing', ['ngMaterial'])
			.controller('AppCtrl', function($scope) {
			});
	</script>
</head>

<body ng-app="movie_browsing" ng-cloak>

		<?php
		
			// Connect to database
			$db_connection = mysql_connect("localhost", "cs143", "");
			if(!$db_connection) {
			    $errmsg = mysql_error($db_connection);
			    print "Connection failed: $errmsg <br />";
			    exit(1);
			}

			// Get input
			$mid = mysql_real_escape_string($_GET["mid"]);
			if (empty($mid)) $mid=-1;

			// Form query
			$actor_query = "SELECT a.id, a.first, a.last FROM MovieActor ma, Actor a WHERE ma.mid=$mid AND ma.aid=a.id";
			$movie_query = "SELECT m.title, m.year, m.rating, m.company FROM Movie m WHERE m.id = $mid";
			$director_query = "SELECT d.first, d.last FROM Director d, MovieDirector md WHERE md.mid=$mid AND md.did=d.id";
			$genre_query = "SELECT genre FROM MovieGenre WHERE mid=$mid";
			$rating_query = "SELECT imdb, rot FROM MovieRating WHERE mid=$mid";
			$review_query = "SELECT name, time, rating, comment FROM Review WHERE mid=$mid";
			$avg_query = "SELECT avg(rating) FROM Review GROUP BY mid HAVING mid=$mid";
			echo $avg_query;

			// Implement query
			mysql_select_db("CS143", $db_connection);
			$actor_rs = mysql_query($actor_query, $db_connection) or die(mysql_error($db_connection));
			$movie_rs = mysql_query($movie_query, $db_connection) or die(mysql_error($db_connection));
			$director_rs = mysql_query($director_query, $db_connection) or die(mysql_error($db_connection));
			$genre_rs = mysql_query($genre_query, $db_connection) or die(mysql_error($db_connection));
			$rating_rs = mysql_query($rating_query, $db_connection) or die(mysql_error($db_connection));
			$review_rs = mysql_query($review_query, $db_connection) or die(mysql_error($db_connection));
			$avg_rs = mysql_query($avg_query, $db_connection) or die(mysql_error($db_connection));
			$row = mysql_fetch_row($movie_rs);
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
							<span class="md-headline"><?php echo $row[0];?></span>
							<span class="md-subhead">Year: <?php echo $row[1];?></span>
							<span class="md-subhead">MPAA Rating: <?php echo $row[2];?></span>
							<span class="md-subhead">Company: <?php echo $row[3];?></span>
							<?php $row = mysql_fetch_row($director_rs); ?>
							<span class="md-subhead">Director: <?php echo $row[0], " ", $row[1];?></span>
							<?php $row = mysql_fetch_row($genre_rs); ?>
							<span class="md-subhead">Genre: <?php echo $row[0];?></span>
							<?php $row = mysql_fetch_row($avg_rs); ?>
							<span class="md-subhead">Average Rating: <?php echo number_format((float)$row[0], 1, '.', '');?></span>
							<?php $row = mysql_fetch_row($rating_rs); ?>
							<span class="md-subhead">IMDb: <?php echo $row[0]/10;?>/10</span>
							<span class="md-subhead">Rotten Tomatoes: <?php echo $row[1];?>%</span>
						</md-card-title-text>
					</md-card-title>
				</md-card>
				<md-button class="md-raised" href="I3.php">Add Comment</md-button>
			</md-content>

			<md-list>
				<md-subheader class="md-no-sticky">
					Actors
				</md-subheader>
				<?php
					while($row = mysql_fetch_row($actor_rs)) {
						echo '<md-list-item class="md-2-line">';
						echo '<div class="md-list-item-text">';
						echo "<h3><a href='B1.php?aid={$row[0]}'>", $row[1], " ", $row[2], "</a></h3>";
						echo '</div>';
						echo '</md-list-item>';
					}
					// Close database connection
					mysql_close($db_connection);
				?>
				<md-subheader class="md-no-sticky">
					Reviews
				</md-subheader>
				<?php
					while($row = mysql_fetch_row($review_rs)) {
						echo '<md-list-item class="md-2-line">';
						echo '<div class="md-list-item-text">';
						echo "<h3>Name: ", $row[0], "</h3>";
						echo '<p>Time: ', $row[1], '</p>';
						echo '<p>Rating: ', $row[2], '</p>';
						echo '<p>Comment: ', $row[3], '</p>';
						echo '</div>';
						echo '</md-list-item>';
					}
					// Close database connection
					mysql_close($db_connection);
				?>
			</md-list>

		</div>



</body>
</html>