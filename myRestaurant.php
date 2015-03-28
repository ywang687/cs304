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
			$databaseUserName="ora_z6j7";
			$databasePassword="a72495096";
			
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
			<li><a href="#tab-Likes">Likes</a></li>
			<li><a href="#tab-Registered">Registered</a></li>
			<li><a href="#tab-Dish">Dish</a></li>
			<li><a href="#tab-Sale">Sale</a></li>
			<li><a href="#tab-Includes">Includes</a></li>
			<li><a href="#tab-Serves">Serves</a></li>
			<li><a href="#tab-Makes">Makes</a></li>
			<li><a href="#tab-Restaurant">Restaurant</a></li>
			<li><a href="#tab-TPworks">TPworks</a></li>
			<li><a href="#tab-Employee">Employee</a></li>
			<li><a href="#tab-Supply">Supply</a></li>
			<li><a href="#tab-Supplier">Supplier</a></li>
			<li><a href="#tab-Stocks">Stocks</a></li>
			<li><a href="#tab-Purchase">Purchase</a></li>
			<li><a href="#tab-Supplies">Supplies</a></li>
			
		</ul>
	
	<!--Member-->
	<div id="tab-Member">
		<form method="POST"> <!-- Member form-->
			<b>Add Member</b><br />
			<input type="text" name="memberID" size="6" placeholder="ID">
			<input type="text" name="memberName" size="6" placeholder="Name">
			<input type="text" name="memberPhone" size="6" placeholder="Phone #">
			<input type="text" name="memberAddress" size="6" placeholder="Address">
			<input type="text" name="memberDiscount" size="6" placeholder="Discount rate">
			<input type="submit" value="Add Member" name="addMember">
			<br /><br />
			<b>Remove Member</b><br />
			<input type="text" name="memberID_remove" size="6" placeholder="ID">
			<input type="submit" value="Remove Member" name="rm_Member_id">
			<br /><br />
			<b>Member Data</b>
			<div id="memberDisplay"></div> <!-- Member display area-->
			<br />
			<b>Member Search By Discount Rate</b><br />
			<input type="text" name="memberDiscount_search" size="15" placeholder="Discount Rate">
			<input type="radio" name="memberSearchOption"
				<?php if (isset($memberSearchOption) && $memberSearchOption=="smaller") echo "checked";?>
				value="smaller" checked>smaller
			<input type="radio" name="memberSearchOption"
				<?php if (isset($memberSearchOption) && $memberSearchOption=="equals") echo "checked";?>
				value="equals">equals
			<input type="radio" name="memberSearchOption"
				<?php if (isset($memberSearchOption) && $memberSearchOption=="greater") echo "checked";?>
				value="greater">greater
			<br />
			<input type="checkbox" name="MemberSearch_DiscountRate_showID">showID
			<input type="checkbox" name="MemberSearch_DiscountRate_showName">showName
			<input type="checkbox" name="MemberSearch_DiscountRate_showPhone">showPhone
			<input type="checkbox" name="MemberSearch_DiscountRate_showAddress">showAddress
			<input type="checkbox" name="MemberSearch_DiscountRate_showDiscountRate">showDiscountRate
			<br />
			<input type="submit" value="Search Member" name="search_Member_discount">
			<div id="memberSearchDisplay"></div> <!-- Member Search display area-->
		</form>
		<?php
			function generateMemberDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from member");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>ID</td><td>Name</td><td>Phone</td><td>Address</td><td>Discount Rate</td></tr></thead>";
			
			
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
		<?php
			$memberSearchResult = "(No search requested)";
			function generateMemberSearchDisplay($discountRateToSearch) {
				// discountRateToSearch should be [0 100]
				// searchOption: smaller, greater, equals. $searchOption
				$toDisplay = "Search for member with discount rate of ".$discountRateToSearch.", ".$_POST['memberSearchOption'];
				
				//(isset($_POST['MemberSearch_DiscountRate_showID']))
				$categoryToShow=array();
				if(isset($_POST['MemberSearch_DiscountRate_showID'])){array_push($categoryToShow,"memberID");}
				if(isset($_POST['MemberSearch_DiscountRate_showName'])){array_push($categoryToShow,"memberName");}
				if(isset($_POST['MemberSearch_DiscountRate_showPhone'])){array_push($categoryToShow,"memberPhone");}
				if(isset($_POST['MemberSearch_DiscountRate_showAddress'])){array_push($categoryToShow,"memberAddress");}
				if(isset($_POST['MemberSearch_DiscountRate_showDiscountRate'])){array_push($categoryToShow,"memberDiscount");}
				
				$temp = "";
				for ($i = 0; $i < count($categoryToShow); $i++) {
					if($i > 0){$temp=$temp.", ";}
					$temp=$temp.$categoryToShow[$i]." ";
				}
				if($temp==""){
					$toDisplay=$toDisplay.". Showing no category";
					$temp=" * ";
				} else {
					$toDisplay=$toDisplay.". Showing ".$temp;
				}
				if($temp!=""){
					if($_POST['memberSearchOption'] == 'smaller'){
						$theStatement="select ".$temp." from member where memberDiscount<".$discountRateToSearch;
						$result = executePlainSQL("select ".$temp." from member where memberDiscount<".$discountRateToSearch);
					}elseif($_POST['memberSearchOption'] == 'greater'){
						$result = executePlainSQL("select ".$temp." from member where memberDiscount>".$discountRateToSearch);
					} else {
						$result = executePlainSQL("select ".$temp." from member where memberDiscount=".$discountRateToSearch);
					}
					
					$toDisplay = $toDisplay."<table border='1' width='100%'>";
				
					$toDisplay = $toDisplay."<tr>";
					for ($i = 0; $i < count($categoryToShow); $i++) {
						$toDisplay = $toDisplay."<td><b>".$categoryToShow[$i]."</b></td>";
					}
					$toDisplay = $toDisplay."</tr>";
			
			
					while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
						$toDisplay = $toDisplay."<tr>";
						for ($i = 0; $i < count($categoryToShow); $i++) {
							$toDisplay = $toDisplay."<td>".$row[$i]."</td>";
						}
						$toDisplay = $toDisplay."</tr>";
					}
					$toDisplay = $toDisplay."</table>";
				}
				return $toDisplay;
			}
		?>
		
	</div>
	
	<!--likes-->
	<div id="tab-Likes">
		<b>Likes</b>
		<form method="POST"> <!-- Likes form-->
			<input type="text" name="memberID" size="6" placeholder="Member ID">
			<input type="text" name="dishID" size="6" placeholder="Dish ID">
			<input type="submit" value="Add Likes" name="addLikes">
		</form>
		<div id="likesDisplay"></div> <!-- Likes display area-->
		<br />
		<b>Likes (Joined with Member and Dish)</b>
		<div id="likesJoinedDisplay"></div> <!-- Likes display area-->
		<br />
		
		<?php
			function generateLikesDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from likes");
				
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Member ID</td><td>Dish ID</td></tr>";
				
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["MEMBERID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHID"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		
		<?php
			function generateJoinedLikesDisplay(){
				$toDisplay = "";
				$result = executePlainSQL("SELECT * FROM(SELECT * FROM MEMBER NATURAL JOIN LIKES) NATURAL JOIN DISH");
				
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Member ID</td><td>Member Name</td><td>Dish ID</td><td>Dish Name</td></tr>";
				
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["MEMBERID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["MEMBERNAME"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHNAME"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		
	</div>
	
	<!--registered-->
	<div id="tab-Registered">
		<form method="POST"> <!-- Member form-->
		
			<input type="text" name="memberID" size="10" placeholder="Member ID">
			<input type="text" name="restaurantPhone" size="10" placeholder="Restaurant Phone">
			<input type="submit" value="Add Registered" name="addRegistered">
		</form>
		<?php
			function generateRegisteredDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from registered");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Member ID</td><td>Restaurant Phone</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["MEMBERID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="registeredDisplay"></div> <!-- Member display area-->
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
		<b>Add Restaurant</b>
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="restaurantPhone" size="6" placeholder="Phone #">
			<input type="text" name="restaurantName" size="6" placeholder="Restaurant Name">
			<input type="text" name="restaurantLocation" size="6" placeholder="Address">
			<input type="submit" value="Add Restaurant" name="addRestaurant">
		</form>
		
		<br />
		<b>Edit Restaurant Name</b>
		<form method="POST"> <!-- Restaurant Name Edit form-->
		
			<input type="text" name="restaurantName_old" size="6" placeholder="Original Name">
			<input type="text" name="restaurantName_new" size="6" placeholder="New Name">
			<input type="submit" value="Update Name" name="changeRestaurantName">
		</form>
		<div id="restaurantNameChangeDisplay"></div> <!-- Restaurant display area-->
		
		<br />
		<div id="restaurantDisplay"></div> <!-- Restaurant display area-->
		
		
		
		<?php
			function generateRestaurantDisplay() { ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
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
		<?php
			$restaurantNameUpdateResult = "";
			function generateRestaurantNameUpdateDisplay($oldName, $newName) {
				$toDisplay = "";
				executePlainSQL("UPDATE restaurant SET restaurantName='".$newName."' WHERE restaurantName='".$oldName."'");
				
				//$restaurantNameUpdateResult = "Name Change Done";
				
				return $restaurantNameUpdateResult;
			}
		?>
		
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
			<input type="text" name="empPosition" size="6" placeholder="ePosition">
			<input type="text" name="empSalary" size="6" placeholder="eSalary">
			<input type="submit" value="Add Employee" name="addEmployee">
		</form>
		<?php
			function generateEmployeeDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from Employee");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>Employee ID</td><td>Employee Name</td><td>Employee Position</td><td>Employee Salary</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["EMPLOYEEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["EMPNAME"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["EMPPOSITION"]."</td>";
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
		<form method="POST"> <!-- Sale form-->
		
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
				$toDisplay = $toDisplay."<tr><td>sale ID</td><td>payment method</td><td>subtotal</td><td>discount rate</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["SALEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["PAYMENTMETHOD"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUBTOTAL"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISCOUNT"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="SaleDisplay"></div> <!-- sale display area-->
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
	
	<!--Includes-->
	<div id="tab-Includes">
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="saleID" size="6" placeholder="sale ID">
			<input type="text" name="dishID" size="6" placeholder="dish ID">
			<input type="text" name="quantity" size="6" placeholder="quantity">
			<input type="submit" value="Add Includes" name="addIncludes">
		</form>
		<?php
			function generateIncludesDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from Includes");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>sale ID</td><td>dish ID</td><td>quantity</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["SALEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["DISHID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["QUANTITY"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="IncludesDisplay"></div> <!-- includes display area-->
	</div>

	<!--Serves-->
	<div id="tab-Serves">
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="dishID" size="6" placeholder="dish ID">
			<input type="text" name="restaurantPhone" size="6" placeholder="restaurant Phone Number">
			<input type="submit" value="Add Serves" name="addServes">
		</form>
		<?php
			function generateServesDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from Serves");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>dish ID</td><td>restaurant Phone Number</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["DISHID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="ServesDisplay"></div> <!-- serves display area-->
	</div>

	<!--Makes-->
	<div id="tab-Makes">
		<form method="POST"> <!-- Restaurant form-->
		
			<input type="text" name="restaurantPhone" size="6" placeholder="restaurant Phone Number">
			<input type="text" name="saleID" size="6" placeholder="sale ID">
			<input type="submit" value="Add Makes" name="addMakes">
		</form>
		<?php
			function generateMakesDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from Makes");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<tr><td>restaurant Phone Number</td><td>Sale ID</td></tr>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SALEID"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</table>";
			
				return $toDisplay;
			}
		?>
		<div id="MakesDisplay"></div> <!-- makes display area-->
	</div>

	<!-- Stocks -->
	<div id="tab-Stocks">
		<form method="POST"> <!-- Stocks form-->
	
			<input type="text" name="restaurantPhone" size="15" placeholder="Restaurant Phone">
			<input type="text" name="supplyID" size="8" placeholder="Supply ID">
			<input type="text" name="quantity" size="10" placeholder="Quantity">
			<input type="text" name="units" size="10" placeholder="Units">
			<input type="submit" value="Add Stocks" name="addStocks">
		</form>
		<?php
			function generateStocksDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from stocks");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<thead><tr><th>Restaurant Phone ID</th><th>Supply ID</th><th>Quantity</th><th>Units</th></tr></thead><tbody>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLYID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["QUANTITY"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["UNITS"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</tbody></table>";
			
				return $toDisplay;
			}
		?>
		<div id="StocksDisplay"></div> <!-- Stocks display area-->
	</div>
	<!-- end Stocks -->

	<!-- Supplies -->
	<div id="tab-Supplies">
		<form method="POST"> <!-- Supplies form-->
	
			<input type="text" name="purchaseID" size="8" placeholder="Purchase ID">
			<input type="text" name="supplierID" size="10" placeholder="Supplier ID">
			<input type="text" name="supplyID" size="10" placeholder="Supply ID">
			<input type="submit" value="Add Supplies" name="addSupplies">
		</form>
		<?php
			function generateSuppliesDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from supplies");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<thead><tr><th>Purchase ID</th><th>Supplier ID</th><th>Supply ID</th></tr></thead><tbody>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["PURCHASEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLIERID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["SUPPLYID"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</tbody></table>";
			
				return $toDisplay;
			}
		?>
		<div id="SuppliesDisplay"></div> <!-- Supplies display area-->
	</div>
	<!-- end Supplies -->
	<!-- Purchase -->
	<div id="tab-Purchase">
		<form method="POST"> <!-- Purchase form-->
	
			<input type="text" name="purchaseID" size="8" placeholder="Purchase ID">
			<input type="text" name="restaurantPhone" size="15" placeholder="Restaurant Phone">
			<input type="submit" value="Add Purchase" name="addPurchase">
		</form>
		<?php
			function generatePurchaseDisplay() {
				$toDisplay = "";
				$result = executePlainSQL("select * from purchase");
			
				$toDisplay = $toDisplay."<table border='1' width='100%'>";
				$toDisplay = $toDisplay."<thead><tr><th>Purchase ID</th><th>Restaurant Phone</th></tr></thead><tbody>";
			
			
				while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
					$toDisplay = $toDisplay."<tr>";
					$toDisplay = $toDisplay."<td>".$row["PURCHASEID"]."</td>";
					$toDisplay = $toDisplay."<td>".$row["RESTAURANTPHONE"]."</td>";
					$toDisplay = $toDisplay."</tr>";
				}
				$toDisplay = $toDisplay."</tbody></table>";
			
				return $toDisplay;
			}
		?>
		<div id="PurchaseDisplay"></div> <!-- Purchase display area-->
	</div>
	<!-- end Purchase -->

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
				executePlainSQL("Drop table includes cascade constraints");
				executePlainSQL("Drop table serves cascade constraints");
				executePlainSQL("Drop table makes cascade constraints");
				executePlainSQL("Drop table stocks cascade constraints");
				executePlainSQL("Drop table supplies cascade constraints");
				executePlainSQL("Drop table purchase cascade constraints");


				
				
				// Create new table...
				executePlainSQL("create table member (memberID number, memberName varchar2(30), memberPhone number, memberAddress char(60), memberDiscount number, primary key (memberID))");
				executePlainSQL("create table restaurant (restaurantPhone number, restaurantName varchar2(30), restaurantLocation char(60), primary key (restaurantPhone), unique (restaurantName))");
				executePlainSQL("create table dish (dishID number, dishName varchar2(50), dishStyle varchar2(20), dishPrice number, primary key(dishID))");
				executePlainSQL("create table employee (employeeID number, empName varchar2(30), empPosition varchar2(20), empSalary number,  primary key(employeeID))");
				executePlainSQL("create table TPworks (employeeID number, startDate varchar2(10), endDate varchar2(10),  primary key(employeeID),foreign key (employeeID) references employee)");				
				executePlainSQL("create table employs (restaurantPhone number, employeeID number, startDate varchar2(10), primary key(restaurantPhone,employeeID),foreign key (restaurantPhone) references restaurant, foreign key(employeeID) references TPworks)");
 				executePlainSQL("create table likes (memberID number, dishID number, primary key (memberID, dishID), foreign key(memberID) references member on delete cascade, foreign key (dishID) references dish)");
				executePlainSQL("create table registered (memberID number, restaurantPhone number, primary key (memberID, restaurantPhone), foreign key (memberID) references member on delete cascade, foreign key (restaurantPhone) references restaurant)");
				executePlainSQL("create table sale (saleID number, paymentMethod varchar2(10), discount number, subtotal number ,primary key(saleID))");
				executePlainSQL("create table supply (supplyID number, supplyName varchar2(20), primary key (supplyID))");
				executePlainSQL("create table supplier (supplierID number, supplierName varchar2(50), primary key (supplierID))");
				executePlainSQL("create table includes (saleID number, dishID number, quantity number, primary key (saleID,dishID), foreign key (saleID) references sale, foreign key (dishID) references dish)");
				executePlainSQL("create table serves (dishID number, restaurantPhone number, primary key (dishID,restaurantPhone), foreign key (dishID) references dish, foreign key (restaurantPhone) references restaurant)");
				executePlainSQL("create table makes (restaurantPhone number, saleID number, primary key (saleID,restaurantPhone), foreign key (saleID) references sale, foreign key (restaurantPhone) references restaurant)");
				executePlainSQL("create table stocks (restaurantPhone number, supplyID number, quantity number, units varchar(10), primary key (restaurantPhone, supplyID), foreign key(supplyID) references supply, foreign key(restaurantPhone) references restaurant)");
				executePlainSQL("create table supplies (purchaseID number, supplierID number, supplyID number, primary key (purchaseID), foreign key(supplierID) references supplier, foreign key(supplyID) references supply)");
				executePlainSQL("create table purchase (purchaseID number, restaurantPhone number, primary key (purchaseID), foreign key(purchaseID) references supplies, foreign key(restaurantPhone) references restaurant)");

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
			} elseif (array_key_exists('rm_Member_id', $_POST)) { //If addMember button clicked
				executePlainSQL("DELETE FROM member where memberID=".$_POST['memberID_remove']);
				OCICommit($db_conn);
			} elseif (array_key_exists('search_Member_discount', $_POST)) { //If addMember button clicked
				$memberSearchResult = generateMemberSearchDisplay($_POST['memberDiscount_search']);
				
			} elseif (array_key_exists('addLikes', $_POST)) { //If addMember button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['memberID'],
					":bind2" => $_POST['dishID']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into likes values (:bind1, :bind2)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addRegistered', $_POST)) { //If addMember button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['memberID'],
					":bind2" => $_POST['restaurantPhone']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into registered values (:bind1, :bind2)", $alltuples);
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
			} elseif (array_key_exists('changeRestaurantName', $_POST)){ //////////////////////////////////////////////////////////////////////////////////////////////////////////////////
				$restaurantNameUpdateResult = generateRestaurantNameUpdateDisplay($_POST['restaurantName_old'],$_POST['restaurantName_new']);
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
					":bind3" => $_POST['empPosition'],
					":bind4" => $_POST['empSalary']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into Employee values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
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
      			} elseif (array_key_exists('addIncludes', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['saleID'],
					":bind2" => $_POST['dishID'],
					":bind3" => $_POST['quantity']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into includes values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addServes', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['dishID'],
					":bind2" => $_POST['restaurantPhone'],
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into serves values (:bind1, :bind2)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addMakes', $_POST)){
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['restaurantPhone'],
					":bind2" => $_POST['saleID'],
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into makes values (:bind1, :bind2)", $alltuples);
				OCICommit($db_conn);
			} elseif (array_key_exists('addStocks', $_POST)) { //If addStocks button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['restaurantPhone'],
					":bind2" => $_POST['supplyID'],
					":bind3" => $_POST['quantity'],
					":bind4" => $_POST['units']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into stocks values (:bind1, :bind2, :bind3, :bind4)", $alltuples);
				OCICommit($db_conn);
      			} elseif (array_key_exists('addSupplies', $_POST)) { //If addSupplies button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['purchaseID'],
					":bind2" => $_POST['supplierID'],
					":bind3" => $_POST['suppliesID']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into supplies values (:bind1, :bind2, :bind3)", $alltuples);
				OCICommit($db_conn);
      			} elseif (array_key_exists('addPurchase', $_POST)) { //If addPurchase button clicked
				$tuple = array ( //generate a new tuple
					":bind1" => $_POST['purchaseID'],
					":bind2" => $_POST['restaurantPhone']
				);
				$alltuples = array ( //wrap the tuple into an array
					$tuple
				);
				executeBoundSQL("insert into purchase values (:bind1, :bind2)", $alltuples);
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
		$("#saleDisplay").html("<?php echo generateSaleDisplay(); ?>");
		$("#SupplyDisplay").html("<?php echo generateSupplyDisplay(); ?>");
		$("#SupplierDisplay").html("<?php echo generateSupplierDisplay(); ?>");
		$("#likesDisplay").html("<?php echo generateLikesDisplay(); ?>");
		$("#registeredDisplay").html("<?php echo generateRegisteredDisplay(); ?>");
		$("#memberSearchDisplay").html("<?php echo $memberSearchResult; ?>");
		$("#restaurantNameChangeDisplay").html("<?php echo $restaurantNameUpdateResult; ?>");
		$("#likesJoinedDisplay").html("<?php echo generateJoinedLikesDisplay(); ?>");
		$("#IncludesDisplay").html("<?php echo generateIncludesDisplay(); ?>");
		$("#ServesDisplay").html("<?php echo generateServesDisplay(); ?>");
		$("#MakesDisplay").html("<?php echo generateMakesDisplay(); ?>");
		$("#StocksDisplay").html("<?php echo generateStocksDisplay(); ?>");
		$("#SuppliesDisplay").html("<?php echo generateSuppliesDisplay(); ?>");
		$("#PurchaseDisplay").html("<?php echo generatePurchaseDisplay(); ?>");
		
	</script>
</body>
</html>
