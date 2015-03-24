<!DOCTYPE html>
<html>
	<head>
		<title>My Restaurant</title>
			
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		
		<?php 
			// Database log-in information
			$databaseUserName="<Username>";
			$databasePassword="<Password>";
			
			$success = True; //keep track of errors so it redirects the page only if there are no errors
			$db_conn = OCILogon($databaseUserName, $databasePassword, "ug");
			if ($db_conn){ //if connection successful
				// good
			} else { // connection not successful
				echo "Database connection <b>unsuccessful</b>. Please check your log-in information";
				die();
			}
		?>
		
	</head>
	
	<body>
	<!--The Reset Button-->
	<form method="POST" action="myRestaurant.php">
		<input type="submit" value="Reset Database" name="reset"></p>
	</form>
	
	<!--Member-->
	<h2>Member</h2>
	<form method="POST" action="myRestaurant.php"> <!-- Member form-->
		<p>
		<input type="text" name="memberID" size="6" placeholder="ID">
		<input type="text" name="memberName" size="6" placeholder="Name">
		<input type="text" name="memberPhone" size="6" placeholder="Phone #">
		<input type="text" name="memberAddress" size="6" placeholder="Address">
		<input type="text" name="memberDiscount" size="6" placeholder="Discount rate">
		<input type="submit" value="Add Member" name="addMember"></p>
	</form>
	<?php
		function generateMemberDisplay() {
			$toDisplay = "";
			$result = executePlainSQL("select * from member");
			
			$toDisplay = $toDisplay."<table border='1' width='100%'>";
			$toDisplay = $toDisplay."<tr><td>ID</td><td>Name</td><td>Phone</td><td>Address</td><td>Discount Rate</td></tr>";
			
			
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				$toDisplay = $toDisplay."<tr>";
				$toDisplay = $toDisplay."<td>".$row["MEMBERID"]."</td>";
				$toDisplay = $toDisplay."<td>".$row["MEMBERNAME"]."</td>";
				$toDisplay = $toDisplay."<td>".$row["MEMBERPHONE"]."</td>";
				$toDisplay = $toDisplay."<td>".$row["MEMBERADDRESS"]."</td>";
				$toDisplay = $toDisplay."<td>".$row["MEMBERDISCOUNT"]."</td>";
				$toDisplay = $toDisplay."</tr>";
			}
			$toDisplay = $toDisplay."</table>";
			
			return $toDisplay;
		}
	?>
	<div id="memberDisplay"></div> <!-- Member display area-->
		
	<!--Dish-->
	<h2>Dish</h2>
	
	
	<!--Sale-->
	<h2>Sale</h2>
	
	
	<!--Restaurant-->
	<h2>Restaurant</h2>
	
	<!-- (Other tables...) -->

	
	
	<?php
		
	
		// !!!!!!!!!!!!!!!!!!!!!!! Everyone: don't worry about the implementation of executePlainSQL and executeBoundSQL, just use it! !!!!!!!!!!!!!!!!!!!!!!!!
		function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
			//echo "<br>running ".$cmdstr."<br>";
			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

			if (!$statement) {
				echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($db_conn); // For OCIParse errors pass the       
				// connection handle
				echo htmlentities($e['message']);
				$success = False;
			}

			$r = OCIExecute($statement, OCI_DEFAULT);
			if (!$r) {
				echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
				$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
				echo htmlentities($e['message']);
				$success = False;
			} else {
			}
			return $statement;
		}

		function executeBoundSQL($cmdstr, $list) {
			/* Sometimes a same statement will be excuted for severl times, only
			the value of variables need to be changed.
			In this case you don't need to create the statement several times; 
			using bind variables can make the statement be shared and just 
			parsed once. This is also very useful in protecting against SQL injection. See example code below for       how this functions is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

			if (!$statement) {
				echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
				$e = OCI_Error($db_conn);
				echo htmlentities($e['message']);
				$success = False;
			}

			foreach ($list as $tuple) {
				foreach ($tuple as $bind => $val) {
					//echo $val;
					//echo "<br>".$bind."<br>";
					OCIBindByName($statement, $bind, $val);
					unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}
				$r = OCIExecute($statement, OCI_DEFAULT);
				if (!$r) {
					echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
					$e = OCI_Error($statement); // For OCIExecute errors pass the statementhandle
					echo htmlentities($e['message']);
					echo "<br>";
					$success = False;
				}
			}

		}
	
		// Connect Oracle...
		if ($db_conn) { //if connection successful
			if (array_key_exists('reset', $_POST)) { //If reset button clicked
				// Drop old table...
				executePlainSQL("Drop table member");
			

				// Create new table...
				executePlainSQL("create table member (memberID number, memberName varchar2(30), memberPhone number, memberAddress char(50), memberDiscount number, primary key (memberID))");
			
				// save database
				OCICommit($db_conn);
			
			} elseif (array_key_exists('addMember', $_POST)) { //If addMember button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['memberID'],
					":bind2" => $_POST['memberName'],
					":bind3" => $_POST['memberPhone'],
					":bind4" => $_POST['memberAddress'],
					":bind5" => $_POST['memberDiscount']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into member values (:bind1, :bind2, :bind3, :bind4, :bind5)", $alltuples);
				OCICommit($db_conn);
			
			} else { //If the page is just loaded
				//Nothing for now
			}
		}
	?>
	
	<script>
		//this part of the code is to fill in the display areas.
		
		$("#memberDisplay").html("<?php echo generateMemberDisplay(); ?>");
	</script>
</body>
</html>