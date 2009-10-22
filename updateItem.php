<?php

/*

    Copyright (C) 2009, All Rights Reserved.

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
    along with RPInventory.  If not, see <http://www.gnu.org/licenses/>.

*/


require_once('lib/connect.lib.php');  //mysql
require_once('lib/auth.lib.php');  //Session
session_start();

$link = connect();
if($link == null)
	die('Database connection failed');
	
//Authenticate
$auth = GetAuthority();
if($auth < 1)
	die('You dont have permission to access this page');

$count = (int)$_POST['count'];
if($count == 0)
	die('Must edit at least one item');
	

//Run update for each item
for($x=0; $x<$count; $x++)
{
  //Description
  $desc = $_POST['desc-' . $x];
  if(strlen($desc) == 0)
    die('Must have a description');
  
	
  //Condition
  $condition = $_POST['condition-' . $x];
  if(strlen($condition) == 0)
    die('Must have a condition');	
  
  //Location	
  $location = (int)$_POST['location-' . $x];
  
  $newLocation = $_POST['newlocation-' . $x];
  
  $desc = mysqli_real_escape_string($link, $desc);
  $condition = mysqli_real_escape_string($link, $condition);
  $location = mysqli_real_escape_string($link, $location);
  $newLocation = mysqli_real_escape_string($link, $newLocation);
  
  $sql = 'SELECT * FROM locations';	
  $result = mysqli_query($link, $sql); 
  $checkRows = 0;
  $loc_match;
  
  // Check location exists
  while ($row = mysqli_fetch_array($result)) {
    if (strcasecmp($row['location'], $newLocation) == 0){ 
      $loc_match = $row['location'];
      $checkRows++;
    }
  }
  
  
  //if not in database, new location was specified
  if($location == -1 && $checkRows == 0){
    if(strlen($newLocation) == 0)
      die("New location must have a name.");	
    
    $locDescription = $_POST["newdescription-" . $x];
    $locDescription = mysqli_real_escape_string($link, $locDescription);
    
    if(strlen($locDescription) == 0)
      die("New location must have a description.");	
    
    $sql = "INSERT INTO locations (location_id, location, description) VALUES (NULL, '" . $newLocation . "', '" . $locDescription . "')";
    
    if(!mysqli_query($link, $sql))
      die("New Location Insert Query Failed");
    
    $location = mysqli_insert_id($link);  
    
    if($location == 0)
      die("Must have a location");
  }
  //stuff they entered already exists in the table
  else if($location == -1 && $checkRows == 1){
    $sql = "SELECT location_id FROM locations WHERE location = '" . $loc_match . "' LIMIT 1";
    $result = mysqli_query($link, $sql);
    $loc = mysqli_fetch_object($result);
    $location = $loc->location_id;
  }
  // Decided to not die(), but use the other location if duplicate was given
  /*	else{
	die("Cannot determine correct location_id from given name. Location already exists with name: ".$newLocation);
	}*/
  
  
  
  //Value
  $value = (double)$_POST['value-' . $x];
  if($value == 0)
    die("Invalid Value");
  
  //Item ID
  $inventory_id = (int)$_POST['inventory_id-' . $x];
  if($inventory_id == 0)
    die('Invalid item id');	
  
	/**
	 *	Categories
	 **/	
	
	/* All old categories are stored in session variables when editItem.php is loaded */	
	$currCatIDs = $_SESSION['item_old_categoryIDs-'.$inventory_id];

	/* Final categories can be retrieved from page */
	$finalCatIDs = array();
	for($c = 0; $c < $_POST['catCount-'.$x]; $c++)
	{
		/* Put each final category into array */
		$finalCatIDs[] = $_POST['category_'.$c.'-'.$x];
	}
	
	/* categories to delete are the ones from the original that are not in the final */
	$toDeleteIDs = array_diff($currCatIDs, $finalCatIDs);
	
	/* categories to add are the ones from the final that are not in the original */
	$toAddIDs = array_diff($finalCatIDs, $currCatIDs);

	if(sizeof($toDeleteIDs) > 0)
	{
		$toDeleteQuery = 'DELETE FROM inventory_category
											WHERE inventory_id='.$inventory_id;

		foreach($toDeleteIDs as $id)
		{
			$toDeleteQuery .= ' AND category_id='.$id;
		}
		/* Actually delete categories */
		mysqli_query($link, $toDeleteQuery) or die('Error deleting: '.mysqli_error($link));
	}
	
	if(sizeof($toAddIDs) > 0)
	{
		$toAddQuery = '';
		foreach($toAddIDs as $id)
		{
			$toAddQuery .= 'INSERT INTO inventory_category (inventory_id, category_id) VALUES ('.$inventory_id.', '.$id.');';		
		}
		/* actually insert categories */
		mysqli_query($link, $toAddQuery) or die('Error inserting: '.mysqli_error($link));
	}
  
  $query = "update inventory set description = '" . $desc . "', location_id = '" . $location . "', current_condition = '" . $condition . "', current_value = '" . $value . "' where inventory_id = '" . $inventory_id . "'";
  
  
  
  //Run update
  if(!mysqli_query($link, $query))
    die("Query failed");
  
}


mysqli_close($link);

header('Location: viewInventory.php');

?>
