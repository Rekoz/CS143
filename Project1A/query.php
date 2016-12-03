<html>
<head><title>CS143 Project 1A</title></head>
<body>
		<p>Type an SQL query in the following box: </p>
		Example: <tt>SELECT * FROM Actor WHERE id=10;</tt><br />
		<p>
			<form action="" method="GET">
				<textarea name="query" cols="60" rows="8"></textarea><br />
				<input type="submit" value="Submit" />
			</form>
		</p>
		<p>
			<small>Note: tables and fields are case sensitive. All tables in Project 1A are availale.</small>
		</p>
</body>
</html>

<?php
	$db_connection = mysql_connect("localhost", "cs143", "");
	$query = mysql_real_escape_string($_GET["query"]);
	if(!$db_connection) {
	    $errmsg = mysql_error($db_connection);
	    print "Connection failed: $errmsg <br />";
	    exit(1);
	}
	mysql_select_db("CS143", $db_connection);
	$rs = mysql_query($query, $db_connection) or die(mysql_error($db_connection));
	echo '<table border="1">';
	while($row = mysql_fetch_row($rs)) {
		$l = sizeof($row);
		$i = 0;
		echo '<tr>';
	    for (; $i < $l; $i++) {
	    	echo "<td>{$row[$i]}</td>";
	    }
	    echo '</tr>';
	}
	echo '</table>';
	mysql_close($db_connection);
?>
