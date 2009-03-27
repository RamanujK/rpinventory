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

// SMARTY Setup
require_once('lib/smarty_inv.class.php');
$smarty = new Smarty_Inv();

/* did something go wrong? */
$retry = false;
$error = '';

if ($_POST['install'] && !file_exists('config/config.ini.php')) {
  $retry = true;
  $error = 'Config file either nonexistant or unreadable. Please fix before continuing.';
} else if ($_GET['error']) {
  $retry = true;
  if ($_GET['error'] == 'connect')
    $error = 'Database connection failed: correct username and password or edit config.ini.php and try again.';
  else if ($_GET['error'] == 'missing')
    $error = 'Missing at least one field below required for installation.';
  else
    $error = 'Unknown error';
} else if ($_POST['adminpass1'] != $_POST['adminpass2']) {
  $retry = true;
  $error = 'Passwords do not match.';
}
  
if (!file_exists('config/config.ini.php') || $retry) {
  if ($retry)
    $smarty->assign('error', $error);

  $smarty->display('install.tpl');
} elseif ($_POST['install']) {
  /* perform installation */
  require_once('lib/config.class.php'); // configurations

  /* config data */
  $hostname = Config::get('database_hostname');
  $database = Config::get('database_name');
  $username = Config::get('database_username');
  $password = Config::get('database_password');
  $superuser = $_POST['superuser'];
  $superpass = $_POST['superpass'];
  $adminuser = $_POST['adminuser'];
  $adminpass = $_POST['adminpass1'];

  if (!$superuser || !$superpass || !$adminuser || !$adminpass) {
    header('Location: install.php?error=missing');
    die();
  }

  $link = mysqli_connect($hostname, $superuser, $superpass);
  if (!$link) {
    header('Location: install.php?error=connect');
    die();
  }
  
  /* create database */
  mysqli_query($link, "CREATE DATABASE IF NOT EXISTS `" . $database . "`");

  /* add user */
  mysqli_query($link, 'GRANT SELECT,INSERT,UPDATE,DELETE ON ' . $database . ".* TO '" . $username . "'@'" . $hostname . "' IDENTIFIED BY '" . $password . "'");

  mysqli_select_db($link, $database);

  /* read in setup sql and create database structure */
  $sql = file_get_contents('sql/setup.sql');
  mysqli_multi_query($link, $sql);

  /* create admin user for application */
  $sql = 'INSERT INTO logins (id, username, password, access_level, rin, email, name) VALUES ';
  $sql .= "(NULL, '" . $adminuser . "', '" . md5($adminpass) . "', 2, '0', 'admin', 'admin')";

  mysqli_query($link, $sql);

  /* close connection */
  mysqli_close($link);

  echo('Installation successful. <a href="index.php">Use RPInventory</a>');
} else {
  /* GO AWAY! Shouldn't be here if no need to install */
  header('Location: index.php');
}

?>