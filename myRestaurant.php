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
			$databaseUserName="ora_u5n8";
			$databasePassword="a40227118";
			
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
			<li><a href="#tab-TPworks">TPworks</a></li>
			<li><a href="#tab-Employee">Employee</a></li>
			<li><a href="#tab-Supply">Supply</a></li>
			<li><a href="#tab-Supplier">Supplier</a></li>
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
				$toDisplay = $toDisplay."<tr><td>Dish ID</td><td>Dish Name</td><td>Style</td><td>Price</td></tr>";
			
			
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
	
		<!--TPworks-->
	<div id="tab-TPworks">
			<form method="POST"> <!-- TPworks form-->
		
			<input type="text" name="employeeID" size="6" placeholder="empID">
			<input type="text" name="startDate" size="6" placeholder="sDate">
			<input type="text" name="endDate" size="6" placeholder="eDate">
			<input type="submit" value="Add TPworks" name="addTPworks">
		</form>
		<?php
			function generateTPworksDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from TPworks");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Employee ID</td><td>Start Date</td><td>End Date</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["EMPLOYEEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["STARTDATE"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["ENDDATE"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="TPworksDisplay"></div> <!-- TPworks display area-->
	</div>
	
			<!--Employee-->
	<div id="tab-Employee">
			<form method="POST"> <!-- Employee form-->
	
			<input type="text" name="employeeID" size="6" placeholder="empID">
			<input type="text" name="empName" size="6" placeholder="eName">
			<input type="text" name="empSalary" size="6" placeholder="eSalary">
			<input type="submit" value="Add Employee" name="addEmployee">
		</form>
		<?php
			function generateEmployeeDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from Employee");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Employee ID</td><td>Employee Name</td><td>Employee Salary</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["EMPLOYEEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["EMPNAME"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["EMPSALARY"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="EmployeeDisplay"></div> <!-- Employee display area-->
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
			function generateSaleDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from sale");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>sale ID</td><td>payment method</td><td>discount rate</td></tr>";
			
			
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
	<!-- Supply -->
	<div id="tab-Supply">
			<form method="POST"> <!-- Supply form-->
	
			<input type="text" name="supplyID" size="6" placeholder="Supply ID">
			<input type="text" name="supplyName" size="6" placeholder="Supply Name">
			<input type="submit" value="Add Supply" name="addSupply">
		</form>
		<?php
			function generateSupplyDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from supply");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<thead><tr><th>Supply ID</th><th>Supply Name</th></tr></thead><tbody>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLYID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLYNAME"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</tbody></table>";
			
				return $toDisplay;
			}
		?>
		<div id="SupplyDisplay"></div> <!-- Supply display area-->
	</div>
	<!-- end Supply -->

	<!-- Supplier -->
	<div id="tab-Supplier">
			<form method="POST"> <!-- Supplier form-->
	
			<input type="text" name="supplierID" size="12" placeholder="Supplier ID">
			<input type="text" name="supplierName" size="50" placeholder="Supplier Name">
			<input type="submit" value="Add Supplier" name="addSupplier">
		</form>
		<?php
			function generateSupplierDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from supplier");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<thead><tr><th>Supplier ID</th><th>Supplier Name</th></tr></thead><tbody>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLIERID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLIERNAME"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</tbody></table>";
			
				return $toDisplay;
			}
		?>
		<div id="SupplierDisplay"></div> <!-- Supplier display area-->
	</div>
	<!-- end Supplier -->
	
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
			/* Sometimes a same statement will be executed for several times, only
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
				executePlainSQL("Drop table dish cascade constraints");
				executePlainSQL("Drop table TPworks cascade constraints");
				executePlainSQL("Drop table employee cascade constraints");
				executePlainSQL("Drop table employs cascade constraints");
				executePlainSQL("Drop table sale cascade constraints");
				executePlainSQL("Drop table supply cascade constraints");
				executePlainSQL("Drop table supplier cascade constraints");
				
				
				// Create new table...
				executePlainSQL("create table member (memberID number, memberName varchar2(30), memberPhone number, memberAddress char(50), memberDiscount number, primary key (memberID))");
				executePlainSQL("create table restaurant (restaurantPhone number, restaurantName varchar2(30), restaurantLocation char(50), primary key (restaurantPhone))");
				executePlainSQL("create table dish (dishID number, dishName varchar2(50), dishStyle varchar2(20), dishPrice number, primary key(dishID))");
				executePlainSQL("create table employee (employeeID number, empName varchar2(30), empSalary number,  primary key(employeeID))");
				executePlainSQL("create table TPworks (employeeID number, startDate varchar2(10), endDate varchar2(10),  primary key(employeeID),foreign key (employeeID) references employee)");				
				executePlainSQL("create table employs (restaurantPhone number, employeeID number, startDate varchar2(10), primary key(restaurantPhone,employeeID),foreign key (restaurantPhone) references restaurant, foreign key(employeeID) references TPworks)");
 				executePlainSQL("create table likes (memberID number, dishID number, primary key (memberID, dishID), foreign key(memberID) references member, foreign key (dishID) references dish)");
				executePlainSQL("create table registered (memberID number, restaurantPhone number, primary key (memberID), foreign key (memberID) references member, foreign key (restaurantPhone) references restaurant)");
				executePlainSQL("create table sale (saleID number, paymentMethod varchar2(10), discount number)");
				executePlainSQL("create table supply (supplyID number, supplyName varchar2(10), primary key (supplyID))");
				executePlainSQL("create table supplier (supplierID number, supplierName varchar2(50), primary key (supplierID))");
			

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
			} elseif (array_key_exists('addTPworks', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['employeeID'],
					":bind2" => $_POST['startDate'],
					":bind3" => $_POST['endDate']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into TPworks values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addEmployee', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['employeeID'],
					":bind2" => $_POST['empName'],
					":bind3" => $_POST['empSalary']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into Employee values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addSale', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['saleID'],
					":bind2" => $_POST['paymentMethod'],
					":bind3" => $_POST['discount']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into Sale values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addSupply', $_POST)) { //If addSupply button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['supplyID'],
					":bind2" => $_POST['supplyName']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into supply values (:bind1, :bind2)", $alltuples);
				OCICommit($db_conn);
      			} elseif (array_key_exists('addSupplier', $_POST)) { //If addSupply button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['supplierID'],
					":bind2" => $_POST['supplierName']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into supplier values (:bind1, :bind2)", $alltuples);
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
		$("#TPworksDisplay").html("<?php echo generateTPworksDisplay(); ?>");
		$("#EmployeeDisplay").html("<?php echo generateEmployeeDisplay(); ?>");
		$("#SaleDisplay").html("<?php echo generateSaleDisplay(); ?>");
		$("#SupplyDisplay").html("<?php echo generateSupplyDisplay(); ?>");
		$("#SupplierDisplay").html("<?php echo generateSupplierDisplay(); ?>");
		
	</script>
</body>
</html>
