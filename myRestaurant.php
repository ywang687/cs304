<!DOCTYPE html>
<html>
	<head>
		<title>My Restaurant</title>
		
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<link rel="stylesheet" href="/resources/demos/style.css">
		<script>
			$(function() {
				$( "#tabs" ).tabs();
			});
		</script>
		<?php 
			// Database log-in information
			$databaseUserName="a1a1";
			$databasePassword="a1234567";
			
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
	<form method="POST">
		<input type="submit" value="Reset Database" name="reset"></p>
	</form>
	
	<!--Tabbed interface-->
	<div id="tabs">
		<ul>
			<li><a href="#tab-Member">Member</a></li>
			<li><a href="#tab-Dish">Dish</a></li>
			<li><a href="#tab-Sale">Sale</a></li>
			<li><a href="#tab-Restaurant">Restaurant</a></li>
		</ul>
	
	<!--Member-->
	<div id="tab-Member">
		<form method="POST"> <!-- Member form-->
		
			<input type="text" name="memberID" size="6" placeholder="ID">
			<input type="text" name="memberName" size="6" placeholder="Name">
			<input type="text" name="memberPhone" size="6" placeholder="Phone #">
			<input type="text" name="memberAddress" size="6" placeholder="Address">
			<input type="text" name="memberDiscount" size="6" placeholder="Discount rate">
			<input type="submit" value="Add Member" name="addMember">
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
	</div>
	
	<!--Dish-->
	<div id="tab-Dish">
		<form method="POST"> <!-- Dish form-->
		
			<input type="text" name="dishID" size="6" placeholder="dID">
			<input type="text" name="dishName" size="6" placeholder="dName">
			<input type="text" name="dishStyle" size="6" placeholder="dStyle">
			<input type="text" name="dishPrice" size="6" placeholder="dPrice">
			<input type="submit" value="Add Dish" name="addDish">
		</form>
		<?php
			function generateDishDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from dish");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>dID</td><td>dName</td><td>Style</td><td>Price</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["DISHID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHNAME"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHSTYLE"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHPRICE"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="dishDisplay"></div> <!-- Dish display area-->
	</div>
	
	
	<!--Restaurant-->
	<div id="tab-Restaurant">
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="restaurantPhone" size="6" placeholder="Phone #">
			<input type="text" name="restaurantName" size="6" placeholder="Restaurant Name">
			<input type="text" name="restaurantLocation" size="6" placeholder="Address">
			<input type="submit" value="Add Restaurant" name="addRestaurant">
		</form>
		<?php
			function generateRestaurantDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from restaurant");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Phone</td><td>Name</td><td>Address</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTNAME"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTLOCATION"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="restaurantDisplay"></div> <!-- Restaurant display area-->
	</div>
	
	<!-- (Other tables...) -->

	<!--Sale-->
	<div id="tab-Sale">
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="saleID" size="6" placeholder="sale ID">
			<input type="text" name="paymentMethod" size="6" placeholder="payment method">
			<input type="text" name="discount" size="6" placeholder="discount rate">
			<input type="submit" value="Add Sale" name="addSale">
		</form>
		<?php
			function generateRestaurantDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from sale");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Phone</td><td>Name</td><td>Address</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["SALEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["PAYMENTMETHOD"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISCOUNT"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="saleDisplay"></div> <!-- sale display area-->
	</div>
	

	
	</div>
	
	
	
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
				executePlainSQL("Drop table member cascade constraints");
				executePlainSQL("Drop table restaurant cascade constraints");
				executePlainSQL("Drop table likes cascade constraints");
				executePlainSQL("Drop table registered cascade constraints");
				executePlainSQL("Drop table dish");
				
				// Create new table...
				executePlainSQL("create table member (memberID number, memberName varchar2(30), memberPhone number, memberAddress char(50), memberDiscount number, primary key (memberID))");
				executePlainSQL("create table restaurant (restaurantPhone number, restaurantName varchar2(30), restaurantLocation char(50), primary key (restaurantPhone))");
				executePlainSQL("create table dish (dishID number, dishName varchar2(50), dishStyle varchar2(20), dishPrice number, primary key(dishID))");
 				executePlainSQL("create table likes (memberID number, dishID number, primary key (memberID, dishID), foreign key(memberID) references member, foreign key (dishID) references dish)");
				executePlainSQL("create table registered (memberID number, restaurantPhone number, primary key (memberID), foreign key (memberID) references member, foreign key (restaurantPhone) references restaurant)");
				
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
			} elseif (array_key_exists('addDish', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['dishID'],
					":bind2" => $_POST['dishName'],
					":bind3" => $_POST['dishStyle'],
					":bind4" => $_POST['dishPrice']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into dish values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addRestaurant', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['restaurantPhone'],
					":bind2" => $_POST['restaurantName'],
					":bind3" => $_POST['restaurantLocation']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into restaurant values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
			} else { //If the page is just loaded
				//Nothing for now
			}
		}
	?>	
	<script>
		//this part of the code is to fill in the display areas.
		
		$("#memberDisplay").html("<?php echo generateMemberDisplay(); ?>");
		$("#restaurantDisplay").html("<?php echo generateRestaurantDisplay(); ?>");
		$("#dishDisplay").html("<?php echo generateDishDisplay(); ?>");
		
	</script>
</body>
</html>