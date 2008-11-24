<?php


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

// SMARTY Setup

require_once('Smarty.class.php');

$smarty = new Smarty();
$smarty->caching = false;
$smarty->template_dir = template_dir;
$smarty->compile_dir  = compile_dir;
$smarty->config_dir   = config_dir;
$smarty->cache_dir    = cache_dir;


//grab all ids
$idString = $_GET["ids"];
$token = strtok($idString, ",");
$idList = array();

while ($token !== false) {
	$idList[] = (int)$token;
    $token = strtok(",");
}

if(count($idList) == 0)
	die("No items");


//Get all items
$items = array();
foreach($idList as $id)
{

	//item
	$query= "SELECT inventory.inventory_id, inventory.description, location, locations.location_id, current_condition, current_value  FROM inventory, locations WHERE locations.location_id=inventory.location_id and inventory.inventory_id = " . $id;
	$result = mysqli_query($link, $query);
	
	if(mysqli_num_rows($result) == 0)
		die("Invalid ID");
	
	$item = mysqli_fetch_object($result);
	$items[] = $item;
}



//Locations
$locQuery= "SELECT location_id, location  FROM locations";
$locResult = mysqli_query($link, $locQuery);
$locations = array();

while($loc = mysqli_fetch_object($locResult))
{
	$locations [] = $loc;
}

//BEGIN Page



	
//Assign vars
$smarty->assign('title', "Edit Item");
$smarty->assign('authority', $auth);
$smarty->assign('page_tpl', 'editItem');
$smarty->assign('items', $items);
$smarty->assign('itemCount', count($items));
$smarty->assign('locations', $locations);


$smarty->display('index.tpl');



mysqli_close($link);

?>
