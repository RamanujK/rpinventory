<?php

/*

    Copyright (C) 2008, All Rights Reserved.

    This file is part of RPInventory.

    RPInventory is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    RPInventory is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

*/


require_once("inc/connect.php");  //mysql
require_once("inc/auth.php");  //Session
require_once("inc/config.php");  //configs

$link = connect();
if($link == null)
	die("Database connection failed");
	
//Authenticate
$auth = GetAuthority();
if($auth < 1)
	die("You dont have permission to access this page");

	
//Description
$desc = $_POST["description"];
if(strlen($desc) == 0)
	die("Must have a description");
	
//Location
$location = $_POST["location"];
if(strlen($location) == 0)
	die("Must have a location");

	
//Location  ID
$location_id = (int)$_POST["location_id"];
if($location_id == 0)
	die("Invalid item id");	
	
	
$query = "update locations set description = '" . $desc . "', location = '" . $location . "' where location_id = " . $location_id;


//Run update
if(!mysqli_query($link, $query))
	die("Query failed");	
	



mysqli_close($link);

header('Location: manageLocations.php');

?>
