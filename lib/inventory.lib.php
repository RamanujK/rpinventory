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
  along with RPInventory.  If not, see <http://www.gnu.org/licenses/>.

*/

	//inventory.lib.php
	require_once("inc/connect.php");  //mysql
	require_once("inc/auth.php");  //Session
		
	function getInventory()
	{

		$link = connect();
		if($link == null)
			die("Database connection failed");
			
		//Authenticate
		$auth = GetAuthority();
		
		
		//items
		$query= "SELECT inventory.inventory_id, inventory.description, location, current_condition, current_value
				FROM inventory, locations
				WHERE locations.location_id=inventory.location_id";
		$result = mysqli_query($link, $query);
		$items = array();
		
		while($item = mysqli_fetch_object($result))
		{
			$items [] = $item;
		}

		return $items;
		
		mysqli_close($link);	
	}

?>