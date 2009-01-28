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

require_once("inc/connect.php");  //mysql
require_once("inc/auth.php");  //Session
require_once("inc/config.php");  //configs

$link = connect();
if($link == null)
	die("Database connection failed");

//Authenticate
$auth = GetAuthority();	
if($auth != 2)
	die("You dont have permission to access this page");

// SMARTY Setup

require_once('inc/setup.php');

$smarty = new Smarty_Inv();

$id = (int)$_GET['id'];
if($id == 0)
	die("Invalid ID");

//users
$userQuery= "SELECT * from logins where id = " . $id;
$userResult = mysqli_query($link, $userQuery);
$user = mysqli_fetch_object($userResult);

if($user == false)
	die("Invalid ID");

//BEGIN Page



	
//Assign vars
$smarty->assign('title', "Edit User");
$smarty->assign('authority', $auth);
$smarty->assign('page_tpl', 'editUser');
$smarty->assign('user', $user);


$smarty->display('index.tpl');



mysqli_close($link);

?>