<html>
<head>
	<title>Movie Database, Input page 1: Add Actor/Director</title>
	<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-animate.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-aria.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-messages.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.3/angular-route.min.js"></script>
	<script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0-rc2/angular-material.min.js"></script>
	<script type="text/javascript">
		angular.module('I1', ['ngMaterial', 'ngMessages'])
			.controller('AppCtrl', function($scope) {
			});
	</script>
</head>
	
	
<body ng-app="I1" ng-cloak>

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
	<form name="projectionFrom" action="./I1.php" method="GET">
		<h4><u>Fill in the following information to add a new Actor or Director to the Database!:</u></h4>
		<p>So are you adding an Actor or Director?:</p>
		<input type="radio" name="per" value="Actor" checked> Actor
		<input type="radio" name="per" value="Director"> Director
		<md-input-container class="md-block">
			<label>First/Given Name?:</label>
			<input required type="text" name="first" maxlength="20" ng-model="project.first">
			<div ng-messages="projectForm.first.$error">
       			<div ng-message="required">This is required.</div>
        	</div>
        </md-input-container>
		<md-input-container class="md-block">
			<label>Last/Family Name?:</label>
			<input required type="text" name="last" maxlength="20" ng-model="project.last">
			<div ng-messages="projectForm.last.$error">
       			<div ng-message="required">This is required.</div>
        	</div>
        </md-input-container>
		<p>Sex?:</p>
		<input type="radio" name="sex" value="Male" checked> Male
		<input type="radio" name="sex" value="Female"> Female
		<md-input-container class="md-block">
			<label>Date of Birth?: (YYYY-MM-DD)</label>
			<input required type="text" name="dob" maxlength="10" value="<?php echo htmlspecialchars($_GET['dob']);?>">
			<div ng-messages="projectForm.dob.$error">
       			<div ng-message="required">This is required.</div>
        	</div>
        </md-input-container>
		<md-input-container class="md-block">
			<label>Date of Death?: (YYYY-MM-DD)</label>
			<input type="text" name="dod" maxlength="10" value="<?php echo htmlspecialchars($_GET['dod']);?>">
        </md-input-container>
        <md-button type="submit" value="Add Actor/Director" class="md-raised md-primary">
			Submit
		</md-button>
	</form>
	<md-divider></md-divider>
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
</md-content>
</div>
	
	</body>
</html>


