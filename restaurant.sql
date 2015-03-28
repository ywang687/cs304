-- 	Database Table Creation
--
--	This file will create the tables for the restaurant database
--  It is run automatically by the installation script.
--
--  First drop any existing tables. Any errors are ignored.
				
drop table member cascade constraints;
drop table restaurant cascade constraints;
drop table likes cascade constraints;
drop table registered cascade constraints;
drop table dish cascade constraints;
drop table TPworks cascade constraints;
drop table employee cascade constraints;
drop table employs cascade constraints;
drop table sale cascade constraints;
drop table supply cascade constraints;
drop table supplier cascade constraints;
drop table includes cascade constraints;
drop table serves cascade constraints;
drop table makes cascade constraints;
drop table stocks cascade constraints;
drop table supplies cascade constraints;
drop table purchase cascade constraints;

-- Now, add each table.

create table member(
	memberID number(6,0) primary key,
	memberName varchar2(30),
	memberPhone number(10,0),
	memberAddress char(70),
	memberDiscount number(3,2)
	);
	
create table restaurant(
	restaurantPhone number(10,0) primary key,
	restaurantName varchar2(30),
	restaurantLocation char(70),
	unique (restaurantName)
	);
	
create table dish( dishID number(4,0) primary key, 	
	dishName varchar2(50), 	
	dishStyle varchar2(20), 
	dishPrice number(5,2)
	);

create table employee(
	employeeID number(4,0) primary key,
	empName varchar2(30),
	empPosition varchar2(20),
	empSalary number(7,2)
	);
	
create table TPworks(
	employeeID number(5,0) primary key,
	startDate varchar2(10),
	endDate varchar2(10),
	foreign key (employeeID) references employee on delete cascade
	);
	
create table employs(
	restaurantPhone number(10,0),
	employeeID number(5,0),
	startDate varchar2(10),
	primary key (restaurantPhone,employeeID),
	foreign key (restaurantPhone) references restaurant on delete cascade, 
	foreign key(employeeID) references TPworks on delete cascade
	);
	
create table likes(
	memberID number(6,0),
	dishID number(4,0),
	primary key (memberID, dishID),
	foreign key (memberID) references member on delete cascade, 
	foreign key (dishID) references dish on delete cascade
	);
	
create table registered(
	memberID number(6,0) primary key,
	restaurantPhone number(10,0),
	foreign key (memberID) references member on delete cascade,
	foreign key (restaurantPhone) references restaurant on delete cascade
	);
	
create table sale(
	saleID number(8,0) primary key,
	paymentMethod varchar2(20),
	discount number(3,2),
	subtotal number(5,2)
	);
	
create table supply(
	supplyID number(6,0) primary key,
	supplyName varchar2(20)
	);
	
create table supplier(
	supplierID number(5,0) primary key,
	supplierName varchar2(50)
	);
	
create table includes(	
	saleID number(8,0),	
	dishID number(4,0),	
	quantity number (4,0),	
	primary key (saleID,dishID),	
	foreign key (saleID) references sale on delete cascade,
	foreign key (dishID) references dish on delete cascade
	);

create table serves (	
	dishID number (4,0),	
	restaurantPhone number(10,0),	
	primary key (dishID,restaurantPhone),	
	foreign key (dishID) references dish on delete cascade,	
	foreign key (restaurantPhone) references restaurant on delete cascade
	);

create table makes (
	restaurantPhone number (10,0),
	saleID number(8,0),
	primary key (restaurantPhone,saleID),
	foreign key (restaurantPhone) references restaurant on delete cascade,
	foreign key (saleID) references sale on delete cascade
	);

create table supplies (
	purchaseID number (6,0) primary key,
	supplierID number(5,0),
	supplyID number(6,0),
	foreign key (supplierID) references supplier on delete cascade,
	foreign key (supplyID) references supply on delete cascade
	);

create table purchase (
	purchaseID number (6,0) primary key,
	restaurantPhone number (10,0),
	foreign key (restaurantPhone) references restaurant on delete cascade,
	foreign key (purchaseID) references supplies on delete cascade
	);

create table stocks (
	restaurantPhone number (10,0),
	supplyID number(6,0),
	quantity number (4,0),
	units char (15),
	primary key (restaurantPhone,supplyID),
	foreign key (restaurantPhone) references restaurant on delete cascade,
	foreign key (supplyID) references supply on delete cascade
	);
	
	
-- done adding all of the tables, now add in some tuples
--  first, add in the restaurant members 'meberID-mName-mphone#-mAddress-mdiscount'
insert into member values(134567,'Arnold Brown',7786789000,'100 7240 Johnston Drive, Vancouver, BC, Canada, V3A8S8',0.06);
insert into member values(134568,'Alexander Queen',6046722176,'334 3489 Eighth Street, New Westminster, BC, Canada, V8D6F8',0.05);
insert into member values(134569,'Alexander Gordon',6046789886,'634 808 Fir Street, Vancouver, BC, Canada, V7C1H5',0.05);
insert into member values(134570,'Adam Linch',6046789890,'902 356 Steveston Drive, White Rock, BC, Canada, V9J8W9',0.05);
insert into member values(134571,'Artur Walsh',7786789876,'9872 Fifth Avenue, New Westminster, BC, Canada, V7B9Y4',0.03);
insert into member values(134572,'Austin Green',6046345332,'7453 Sixth Street, Burnaby, BC, Canada, V9A6D8',0.06);
insert into member values(134573,'David Leigh',7786789871,'342 7436 Hemlock Avenue, Vancouver, BC, Canada, V3C1R2',0.03);
insert into member values(134574,'Daniel Hsieh',7786789876,'09871 Seventh Avenue, North Vancouver, BC, Canada, V5G2F7',0.03);
insert into member values(134575,'Gabriel Stock',6046789453,'8723 Freeport Way, Vancouver, BC, Canada, V2H4G5',0.03);
insert into member values(134576,'Gerald Harmson',7780099876,'726 1303 Fourth Street, New Westminster, BC, Canada, V1G6W7',0.03);
insert into member values(134577,'Anitra Schtoln',7786091890,'9701 Shorncliff Road, Richmond, BC, Canada, V1E3D4',0.03);
insert into member values(134578,'Giselle Kroitzsch',7786356750,'523 2741 Riverside Road, North Vancouver, BC, Canada, V5J3R5',0.03);
insert into member values(134579,'Karen Lidvino',6046734686,'01635 Tenth Street, Surrey, BC, Canada, V3J9U0',0.06);
insert into member values(134580,'Leonarda Carol',7786489578,'562 7012 Eighth Street, New Westminster, BC, Canada',0.05);
insert into member values(134581,'Rebekka Nils',6046084730,'07164 Gwendolyn Avenue, Surrey, BC, Canada, V3L7Y8',0.05);
insert into member values(134582,'Theodor Steward',7786243366,'130 2144 Eighth Street, White Rock, BC, Canada, V2L7W9',0.06);
insert into member values(134583,'Waldo Smith',6046265357,'8601 Ethel Avenue, Vancouver, BC, Canada, V1M6D8',0.06);
insert into member values(134584,'Adele Lemieux',7783854980,'971 4917 Arthur Street, White Rock, BC, Canada, V3R5H6',0.05);
insert into member values(134585,'Angelika Mohammad',7787354987,'3816 Mill Street, Surrey, BC, Canada, V3K8L0',0.05);
insert into member values(134586,'Irma Odette',6042487853,'8839 Bridgeport BLVD, New Westminster, BC, Canada, V4K5H6',0.05);
insert into member values(134587,'Yuwei Wan',7789573526,'17640 Derwent Way, Burnaby, BC, Canada, V4X8U5',0.06);
insert into member values(134588,'Yuxin Hon',7785738726,'89 9876 Lacasse BLVD, Langley, BC, Canada, V2A4S6',0.08);
insert into member values(134589,'Daphne White',7786098735,'672 424 Walker Drive, Richmond, BC, Canada, V3V6T8',0.08);
insert into member values(134590,'Khloe Lee',6049727634,'580 3424 Edilcan Street, Vancouver, BC, Canada, V6W3T4',0.10);
insert into member values(134591,'Ewa Patrick',7783107574,'8764 East Creek Road, Langley, BC, Canada, V1A7S8',0.10);


--now add in the restaurant 'phone#-resName-resAddress'
insert into restaurant values (7785688999,'City of Fish','8076 Tenth Street, Vancouver, BC, Canada, V5H8F7');
insert into restaurant values (6049566944,'Fish Eye','36838 Linden Street, Richmond, BC, Canada, V7K7DK');
insert into restaurant values (6042677899,'Fishland','4589 Fir Street, Burnaby, BC, Canada, V4G9S8');
insert into restaurant values (6049700900,'Fish, Fat and the Otter','9478 Seventh Avenue, White Rock, BC, Canada, V3J7D9');


--now add in the dishes 'dishID-dishName-dishStyle-dishPrice'
--main dishes
insert into dish values(1001,'Capers and Halibut','Canadian',16.99);
insert into dish values(1002,'Spanish Moroccan Fish','Moroccan',18.99);
insert into dish values(1003,'Quick Fish Tacos','Mexican',9.99);
insert into dish values(1004,'Barlow Blackened Catfish','European',15.99);
insert into dish values(1005,'Blackened Tuna','Canadian',18.99);
insert into dish values(1035,'Broiled Tilapia Parmesan','French',14.99);
insert into dish values(1006,'Baked Dijon Salmon','Canadian',17.99);
insert into dish values(1007,'Grilled Tilapia with Mango Salsa','Mexican',14.99);
insert into dish values(1008,'Marinated Tuna Steak','Canadian',18.99);
insert into dish values(1009,'Cioppino','Canadian',11.99);
insert into dish values(1015,'Potato Salmon Patties','Canadian',8.99);
insert into dish values(1016,'Fish Fillets Italiano','Italian',13.99);
insert into dish values(1017,'Barbeque Halibut Steaks','Canadian',18.99);
insert into dish values(1018,'Tasty Salmon Burger','Canadian',11.99);
insert into dish values(1019,'Asian Tuna Patties','Chinese',17.99);
--appetizers
insert into dish values(1010,'Caesar Salad Supreme','Canadian',7.99);
insert into dish values(1011,'Clam Chowder','Canadian',6.99);
insert into dish values(1012,'Eggplant Pancakes','Chinese',5.99);
insert into dish values(1013,'Escargots with Shallot Mousse and Parsley','French',10.99);
insert into dish values(1014,'Fried Mozzarella Balls','Canadian',5.99);
insert into dish values(1020,'Bacon Stuffed Mushrooms With Sweetcorn','Canadian',7.99);
insert into dish values(1021,'White Bean Panna Cotta and Smoked Trout Roe','Canadian',9.99);
insert into dish values(1022,'Cream of Potato and Leek caramelized','French',6.99);
insert into dish values(1023,'Mussels in White Wine','Canadian',6.99);
insert into dish values(1024,'Thai Coconut Soup with Chicken and Coriander','Thai',5.99);
--desserts
insert into dish values(1025,'Kirsch Souffle','German',5.99);
insert into dish values(1026,'Apple Trifle with Mascarpone Cream','French',5.99);
insert into dish values(1027,'Orange Dessert with Vanilla Cream','French',4.99);
insert into dish values(1028,'Hot Chocolate Galettes','Polish',3.99);
insert into dish values(1029,'Cappuccino Cake With Toasted Nuts','Canadian',4.99);
--drinks
insert into dish values(1030,'Kirsch','German',6.99);
insert into dish values(1031,'Irish Cream Coffee','American',4.99);
insert into dish values(1032,'Rum Cider Punch','Mexican',6.99);
insert into dish values(1033,'Swedish Glogg','Swedish',5.99);
insert into dish values(1034,'Japanese Jasmine Tea','Japanese',3.99);

		
--now add in the employees 'empID-empName-empPosition-empSalary'
insert into employee values (2000,'Folker Schmidt','President/CEO',20000.00);
insert into employee values (2001,'Adalrich Gourmet','General Manager',5000.00);
insert into employee values (2002,'Christian Shaden','General Manager',5000.00);
insert into employee values (2003,'Edwin Temple','General Manager',5000.00);
insert into employee values (2004,'Frank Zeltch','General Manager',5000.00);
insert into employee values (2009,'Ellery Mowe','Executive chef',4000.00);
insert into employee values (2010,'Aveza Mould','Executive chef',4000.00);
insert into employee values (2011,'Penelopa Helbert','Executive chef',4000.00);
insert into employee values (2012,'Avila Brown','Executive chef',4000.00);
insert into employee values (2017,'George McAllen','Sous chef',3500.00);
insert into employee values (2018,'Gerda Bruno','Sous chef',3500.00);
insert into employee values (2031,'Eloi Pickles','Sous chef',3500.00);
insert into employee values (2032,'Jon Snow','Sous chef',3500.00);
insert into employee values (2005,'Gretel Trumpet','Soup and sauce cook',2500.00);
insert into employee values (2006,'Wilhelm Welz','Soup and sauce cook',2500.00);
insert into employee values (2007,'Idette Great','Soup and sauce cook',2500.00);
insert into employee values (2008,'Lydia Rose','Soup and sauce cook',2500.00);
insert into employee values (2033,'Syntia Rose','Soup and sauce cook',2500.00);
insert into employee values (2019,'Randolf Doodle','Counter server',2200.00);
insert into employee values (2020,'Tobias Pepper','Counter server',2200.00);
insert into employee values (2036,'Robert Fur','Counter server',2200.00);
insert into employee values (2021,'Adonis Greek','Counter server',2200.00);
insert into employee values (2022,'Orion Alexander','Counter server',2000.00);
insert into employee values (2023,'Philip Stocco','Server',2000.00);
insert into employee values (2024,'Torsten Schubert','Server',2000.00);
insert into employee values (2025,'Waldo Mozart','Server',2000.00);
insert into employee values (2026,'Acacia Salieri','Server',2000.00);
insert into employee values (2027,'Cleo Stradivari','Server',2000.00);
insert into employee values (2028,'Api Gucci','Server',2000.00);
insert into employee values (2029,'Wallace Nylon','Server',1800.00);
insert into employee values (2035,'Nikole Savannan','Server',1800.00);
insert into employee values (2030,'Alexis Sue','Server',1800.00);
insert into employee values (2013,'Egon Flax','Bus person',1600.00);
insert into employee values (2014,'Peter Pan','Bus person',1600.00);
insert into employee values (2015,'Ralph Loren','Bus person',1600.00);
insert into employee values (2034,'Scott Kent','Bus person',1600.00);
insert into employee values (2016,'Emil Moose','Bus person',1600.00);

--now add in TimePeriodWorks 'empID-startDate-endDate'
insert into TPworks values (2000,'02.02.2012','null');
insert into TPworks values (2001,'02.02.2012','null');
insert into TPworks values (2002,'02.02.2012','null');
insert into TPworks values (2009,'02.02.2012','null');
insert into TPworks values (2010,'02.02.2012','null');
insert into TPworks values (2017,'02.02.2012','null');
insert into TPworks values (2018,'02.02.2012','null');
insert into TPworks values (2005,'02.02.2012','null');
insert into TPworks values (2006,'02.02.2012','null');
insert into TPworks values (2023,'02.02.2012','null');
insert into TPworks values (2024,'02.02.2012','null');
insert into TPworks values (2013,'02.02.2012','null');
insert into TPworks values (2025,'02.02.2012','null');
insert into TPworks values (2007,'06.12.2012','null');
insert into TPworks values (2016,'01.02.2012','null');
insert into TPworks values (2027,'05.01.2012','null');
insert into TPworks values (2030,'08.02.2012','null');
insert into TPworks values (2034,'03.02.2012','null');
insert into TPworks values (2003,'08.02.2013','null');
insert into TPworks values (2012,'06.20.2013','null');
insert into TPworks values (2011,'03.27.2013','null');
insert into TPworks values (2035,'04.02.2013','null');
insert into TPworks values (2021,'02.04.2013','null');
insert into TPworks values (2022,'04.02.2013','null');
insert into TPworks values (2026,'04.25.2013','null');
insert into TPworks values (2028,'03.02.2013','null');
insert into TPworks values (2031,'07.02.2013','null');
insert into TPworks values (2032,'09.02.2013','null');
insert into TPworks values (2033,'02.26.2013','null');
insert into TPworks values (2036,'05.12.2014','null');
insert into TPworks values (2004,'05.20.2014','null');
insert into TPworks values (2014,'05.27.2014','null');
insert into TPworks values (2019,'06.02.2014','null');
insert into TPworks values (2008,'04.05.2013','04.05.2014');
insert into TPworks values (2015,'02.02.2012','09.28.2014');
insert into TPworks values (2020,'02.02.2012','01.07.2015');
insert into TPworks values (2029,'05.02.2013','12.29.2014');


--now add in employs 'resPhone-empID-start date'
insert into employs values (6049566944,2000,'02.02.2012');
insert into employs values (6049566944,2001,'02.02.2012');
insert into employs values (6049566944,2009,'02.02.2012');
insert into employs values (6049566944,2017,'02.02.2012');
insert into employs values (6049566944,2005,'02.02.2012');
insert into employs values (6049566944,2023,'02.02.2012');
insert into employs values (6049566944,2013,'02.02.2012');
insert into employs values (6049566944,2007,'06.12.2012');
insert into employs values (6049566944,2016,'03.02.2012');
insert into employs values (6042677899,2002,'02.02.2012');
insert into employs values (6042677899,2020,'02.02.2012');
insert into employs values (6042677899,2018,'02.02.2012');
insert into employs values (6042677899,2006,'02.02.2012');
insert into employs values (6042677899,2010,'02.02.2012');
insert into employs values (6042677899,2024,'02.02.2012');
insert into employs values (6042677899,2025,'02.02.2012');
insert into employs values (6042677899,2027,'05.01.2012');
insert into employs values (6042677899,2030,'08.02.2012');
insert into employs values (6042677899,2034,'03.02.2012');
insert into employs values (6042677899,2015,'02.02.2012');
insert into employs values (6049700900,2003,'08.02.2013');
insert into employs values (6049700900,2012,'06.20.2013');
insert into employs values (6049700900,2011,'03.27.2013');
insert into employs values (6049700900,2035,'04.02.2013');
insert into employs values (6049700900,2021,'02.04.2013');
insert into employs values (6049700900,2014,'05.27.2014');
insert into employs values (6049700900,2019,'06.02.2014');
insert into employs values (6049700900,2008,'04.05.2013');
insert into employs values (7785688999,2036,'05.12.2014');
insert into employs values (7785688999,2004,'05.20.2014');
insert into employs values (7785688999,2022,'04.02.2013');
insert into employs values (7785688999,2026,'04.25.2013');
insert into employs values (7785688999,2028,'03.02.2013');
insert into employs values (7785688999,2031,'07.02.2013');
insert into employs values (7785688999,2032,'09.02.2013');
insert into employs values (7785688999,2033,'02.26.2013');
insert into employs values (7785688999,2029,'05.02.2013');

	
--now add in likes 'member ID-dish ID'
insert into likes values(134567,1004);
insert into likes values(134568,1002);
insert into likes values(134569,1035);
insert into likes values(134570,1004);
insert into likes values(134571,1005);
insert into likes values(134572,1008);
insert into likes values(134573,1013);
insert into likes values(134574,1019);
insert into likes values(134575,1008);
insert into likes values(134576,1030);
insert into likes values(134577,1026);
insert into likes values(134578,1028);
insert into likes values(134579,1025);
insert into likes values(134580,1021);
insert into likes values(134581,1031);
insert into likes values(134582,1008);
insert into likes values(134583,1033);
insert into likes values(134584,1016);
insert into likes values(134585,1025);
insert into likes values(134586,1018);
insert into likes values(134587,1024);
insert into likes values(134588,1024);
insert into likes values(134589,1025);
insert into likes values(134590,1015);
insert into likes values(134591,1027);


--now add in registered 'member ID-restaurant phone'
insert into registered values(134567,7785688999);
insert into registered values(134568,7785688999);
insert into registered values(134569,7785688999);
insert into registered values(134570,6049566944);
insert into registered values(134571,6049566944);
insert into registered values(134572,6049566944);
insert into registered values(134573,6042677899);
insert into registered values(134574,6042677899);
insert into registered values(134575,6042677899);
insert into registered values(134576,6049700900);
insert into registered values(134577,6049700900);
insert into registered values(134578,6049700900);
insert into registered values(134579,6049700900);
insert into registered values(134580,6049700900);
insert into registered values(134581,6049700900);
insert into registered values(134582,6049566944);
insert into registered values(134583,6049566944);
insert into registered values(134584,7785688999);
insert into registered values(134585,7785688999);
insert into registered values(134586,7785688999);
insert into registered values(134587,6049566944);
insert into registered values(134588,6049566944);
insert into registered values(134589,6042677899);
insert into registered values(134590,6042677899);
insert into registered values(134591,6042677899);

	
--now add in sale 'sale ID-paymentMethod-discount-subtotal'
insert into sale values(10000000,'Cash',0.05,28.47); 
insert into sale values(10000001,'Visa',0.00,59.94);
insert into sale values(10000002,'MasterCard',0.03,25.18);
insert into sale values(10000003,'Visa',0.00,29.97);
insert into sale values(10000004,'Visa',0.00,42.95);
insert into sale values(10000005,'American Express',0.08,18.38);
insert into sale values(10000006,'Visa',0.10,37.76);
insert into sale values(10000007,'Cash',0.00,23.98);
insert into sale values(10000008,'MasterCard',0.05,20.87);
insert into sale values(10000009,'Cash',0.03,44.57);

insert into sale values(10000010,'MasterCard',0.05,22.78);
insert into sale values(10000011,'Cash',0.06,22.54);
insert into sale values(10000012,'Visa',0.10,60.23);
insert into sale values(10000013,'Cash',0.05,30.37);
insert into sale values(10000014,'American Express',0.05,30.37);
insert into sale values(10000015,'Cash',0.03,18.41);
insert into sale values(10000016,'Cash',0.00,66.93);
insert into sale values(10000017,'American Express',0.06,28.17);
insert into sale values(10000018,'Visa',0.06,15.02);
insert into sale values(10000019,'MasterCard',0.05,47.45);

	
--now add in supply 'supply ID-supplyName'
insert into supply values(100001,'Irish Coffee');
insert into supply values(100002,'Fresh Leeks');
insert into supply values(100003,'Fresh Tomatoes');
insert into supply values(100004,'Mascarpone Cheese');
insert into supply values(100005,'German Kirsch');
insert into supply values(100006,'Escargots');
insert into supply values(100007,'Sea Clams');
insert into supply values(100008,'Fresh Lettuce');
insert into supply values(100009,'Sea Halibut');
insert into supply values(100010,'Wild Salmon');

insert into supply values(100011,'Tilapia');
insert into supply values(100012,'Catfish');
insert into supply values(100013,'Pacific Tuna');
insert into supply values(100014,'Chocolate');
insert into supply values(100015,'Cuba Rum');
insert into supply values(100016,'Black Beans');
insert into supply values(100017,'California Apples');
insert into supply values(100018,'Egglants');
insert into supply values(100019,'Capers');
insert into supply values(100020,'Mussels');

	
--now add in supplier 'supplier ID-supplyName'
insert into supplier values(10001,'BC Liqueur Store');
insert into supplier values(10002,'Fresh Veggies');
insert into supplier values(10003,'Mark Arngoltz');
insert into supplier values(10004,'Steven Stony');
insert into supplier values(10005,'Kristofer La Manche');

insert into supplier values(10006,'BC Farms');
insert into supplier values(10007,'Safeway');
insert into supplier values(10008,'BC Produce');
insert into supplier values(10009,'Farmer Market');
insert into supplier values(10010,'Save on Foods');


--now add in includes 'sale ID-dish ID-Quantity'
insert into includes values(10000000,1001,1);
insert into includes values(10000000,1010,1);
insert into includes values(10000000,1031,1);
insert into includes values(10000001,1002,2);
insert into includes values(10000001,1020,1);
insert into includes values(10000001,1025,1);
insert into includes values(10000001,1034,2);

insert into includes values(10000002,1012,1);
insert into includes values(10000002,1011,1);
insert into includes values(10000002,1026,1);
insert into includes values(10000002,1032,1);
insert into includes values(10000003,1008,1);
insert into includes values(10000003,1022,1);
insert into includes values(10000003,1028,1);

insert into includes values(10000004,1018,2);
insert into includes values(10000004,1023,1);
insert into includes values(10000004,1026,1);
insert into includes values(10000004,1033,1);
insert into includes values(10000005,1016,1);
insert into includes values(10000005,1024,1);

insert into includes values(10000006,1005,1);
insert into includes values(10000006,1021,1);
insert into includes values(10000006,1030,1);
insert into includes values(10000006,1025,1);
insert into includes values(10000007,1029,1);
insert into includes values(10000007,1008,1);


--now add in serves 'dish ID-restaurantPhone'
--restaurant 1
insert into serves values(1001,7785688999);
insert into serves values(1002,7785688999);
insert into serves values(1003,7785688999);
insert into serves values(1004,7785688999);
insert into serves values(1005,7785688999);
insert into serves values(1035,7785688999);
insert into serves values(1006,7785688999);
insert into serves values(1007,7785688999);
insert into serves values(1008,7785688999);
insert into serves values(1009,7785688999);
insert into serves values(1015,7785688999);
insert into serves values(1016,7785688999);
insert into serves values(1017,7785688999);
insert into serves values(1018,7785688999);
insert into serves values(1019,7785688999);
insert into serves values(1010,7785688999);
insert into serves values(1011,7785688999);
insert into serves values(1012,7785688999);
insert into serves values(1013,7785688999);
insert into serves values(1014,7785688999);
insert into serves values(1020,7785688999);
insert into serves values(1021,7785688999);
insert into serves values(1022,7785688999);
insert into serves values(1023,7785688999);
insert into serves values(1024,7785688999);
insert into serves values(1025,7785688999);
insert into serves values(1026,7785688999);
insert into serves values(1027,7785688999);
insert into serves values(1028,7785688999);
insert into serves values(1029,7785688999);
insert into serves values(1030,7785688999);
insert into serves values(1031,7785688999);
insert into serves values(1032,7785688999);
insert into serves values(1033,7785688999);
insert into serves values(1034,7785688999);
--restaurant 2
insert into serves values(1001,6049566944);
insert into serves values(1002,6049566944);
insert into serves values(1003,6049566944);
insert into serves values(1004,6049566944);
insert into serves values(1005,6049566944);
insert into serves values(1035,6049566944);
insert into serves values(1006,6049566944);
insert into serves values(1007,6049566944);
insert into serves values(1008,6049566944);
insert into serves values(1009,6049566944);
insert into serves values(1015,6049566944);
insert into serves values(1016,6049566944);
insert into serves values(1017,6049566944);
insert into serves values(1018,6049566944);
insert into serves values(1019,6049566944);
insert into serves values(1010,6049566944);
insert into serves values(1011,6049566944);
insert into serves values(1012,6049566944);
insert into serves values(1013,6049566944);
insert into serves values(1014,6049566944);
insert into serves values(1020,6049566944);
insert into serves values(1021,6049566944);
insert into serves values(1022,6049566944);
insert into serves values(1023,6049566944);
insert into serves values(1024,6049566944);
insert into serves values(1025,6049566944);
insert into serves values(1026,6049566944);
insert into serves values(1027,6049566944);
insert into serves values(1028,6049566944);
insert into serves values(1029,6049566944);
insert into serves values(1030,6049566944);
insert into serves values(1031,6049566944);
insert into serves values(1032,6049566944);
insert into serves values(1033,6049566944);
insert into serves values(1034,6049566944);
--restaurant 3
insert into serves values(1001,6042677899);
insert into serves values(1002,6042677899);
insert into serves values(1003,6042677899);
insert into serves values(1004,6042677899);
insert into serves values(1005,6042677899);
insert into serves values(1035,6042677899);
insert into serves values(1006,6042677899);
insert into serves values(1007,6042677899);
insert into serves values(1008,6042677899);
insert into serves values(1009,6042677899);
insert into serves values(1015,6042677899);
insert into serves values(1016,6042677899);
insert into serves values(1017,6042677899);
insert into serves values(1018,6042677899);
insert into serves values(1019,6042677899);
insert into serves values(1010,6042677899);
insert into serves values(1011,6042677899);
insert into serves values(1012,6042677899);
insert into serves values(1013,6042677899);
insert into serves values(1014,6042677899);
insert into serves values(1020,6042677899);
insert into serves values(1021,6042677899);
insert into serves values(1022,6042677899);
insert into serves values(1023,6042677899);
insert into serves values(1024,6042677899);
insert into serves values(1025,6042677899);
insert into serves values(1026,6042677899);
insert into serves values(1027,6042677899);
insert into serves values(1028,6042677899);
insert into serves values(1029,6042677899);
insert into serves values(1030,6042677899);
insert into serves values(1031,6042677899);
insert into serves values(1032,6042677899);
insert into serves values(1033,6042677899);
insert into serves values(1034,6042677899);
--restaurant 4
insert into serves values(1001,6049700900);
insert into serves values(1002,6049700900);
insert into serves values(1003,6049700900);
insert into serves values(1004,6049700900);
insert into serves values(1005,6049700900);
insert into serves values(1035,6049700900);
insert into serves values(1006,6049700900);
insert into serves values(1007,6049700900);
insert into serves values(1008,6049700900);
insert into serves values(1009,6049700900);
insert into serves values(1015,6049700900);
insert into serves values(1016,6049700900);
insert into serves values(1017,6049700900);
insert into serves values(1018,6049700900);
insert into serves values(1019,6049700900);
insert into serves values(1010,6049700900);
insert into serves values(1011,6049700900);
insert into serves values(1012,6049700900);
insert into serves values(1013,6049700900);
insert into serves values(1014,6049700900);
insert into serves values(1020,6049700900);
insert into serves values(1021,6049700900);
insert into serves values(1022,6049700900);
insert into serves values(1023,6049700900);
insert into serves values(1024,6049700900);
insert into serves values(1025,6049700900);
insert into serves values(1026,6049700900);
insert into serves values(1027,6049700900);
insert into serves values(1028,6049700900);
insert into serves values(1029,6049700900);
insert into serves values(1030,6049700900);
insert into serves values(1031,6049700900);
insert into serves values(1032,6049700900);
insert into serves values(1033,6049700900);
insert into serves values(1034,6049700900);


-- now add in makes 'restaurantPhone - sale ID'
insert into makes values(7785688999,10000000);
insert into makes values(7785688999,10000001);
insert into makes values(6049566944,10000002);
insert into makes values(6049566944,10000003);
insert into makes values(6042677899,10000004);
insert into makes values(6042677899,10000005);
insert into makes values(6049700900,10000006);
insert into makes values(6049700900,10000007);


--now add in supplies 'purchaseID - supplier ID - supply ID'
insert into supplies values(200001,10010,100001);
insert into supplies values(200002,10002,100002);
insert into supplies values(200003,10002,100003);
insert into supplies values(200004,10007,100004);
insert into supplies values(200005,10001,100005);
insert into supplies values(200006,10003,100006);
insert into supplies values(200007,10003,100007);
insert into supplies values(200008,10006,100008);
insert into supplies values(200009,10004,100009);
insert into supplies values(200010,10004,100010);

insert into supplies values(200011,10005,100011);
insert into supplies values(200012,10005,100012);
insert into supplies values(200013,10004,100013);
insert into supplies values(200014,10007,100014);
insert into supplies values(200015,10001,100015);
insert into supplies values(200016,10007,100016);
insert into supplies values(200017,10002,100017);
insert into supplies values(200018,10006,100018);
insert into supplies values(200019,10010,100019);
insert into supplies values(200020,10003,100020);


--now add in purchase 'purchaseID - restaurantPhone'
insert into purchase values(200001,7785688999);
insert into purchase values(200002,7785688999);
insert into purchase values(200003,7785688999);
insert into purchase values(200004,7785688999);
insert into purchase values(200005,7785688999);
insert into purchase values(200006,6049566944);
insert into purchase values(200007,6049566944);
insert into purchase values(200008,6049566944);
insert into purchase values(200009,6049566944);
insert into purchase values(200010,6049566944);
insert into purchase values(200011,6042677899);
insert into purchase values(200012,6042677899);
insert into purchase values(200013,6042677899);
insert into purchase values(200014,6042677899);
insert into purchase values(200015,6042677899);
insert into purchase values(200016,6049700900);
insert into purchase values(200017,6049700900);
insert into purchase values(200018,6049700900);
insert into purchase values(200019,6049700900);
insert into purchase values(200020,6049700900);


--now add in stocks 'restaurantPhone - supplyID - quantity - units'
insert into stocks values(7785688999,100001,2,'jar(s)');
insert into stocks values(7785688999,100002,4,'bunch(es)');
insert into stocks values(7785688999,100003,3,'pound(s)');
insert into stocks values(7785688999,100004,5,'container(s)');
insert into stocks values(7785688999,100005,2,'bottle(s)');
insert into stocks values(6049566944,100006,4,'pound(s)');
insert into stocks values(6049566944,100007,8,'pound(s)');
insert into stocks values(6049566944,100008,3,'bunch(es)');
insert into stocks values(6049566944,100009,30,'pound(s)');
insert into stocks values(6049566944,100010,30,'pound(s)');

insert into stocks values(6042677899,100011,20,'pound(s)');
insert into stocks values(6042677899,100012,15,'pound(s)');
insert into stocks values(6042677899,100013,35,'pound(s)');
insert into stocks values(6042677899,100014,10,'bar(s)');
insert into stocks values(6042677899,100015,3,'bottle(s)');
insert into stocks values(6049700900,100016,6,'tin(s)');
insert into stocks values(6049700900,100017,4,'pound(s)');
insert into stocks values(6049700900,100018,6,'pound(s)');
insert into stocks values(6049700900,100019,2,'jar(s)');
insert into stocks values(6049700900,100020,10,'pound(s)');
