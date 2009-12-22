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


function getBusinesses()
{
    require_once('class/database.class.php');
    require_once('lib/auth.lib.php');  //Session

    // Connect
    $db = new database();

    // Authenticate
    $auth = GetAuthority();

    if (!isset($_SESSION['club']))
    {
        return array();
    }

    $club_id = $_SESSION['club'];

    // Loan History
    $query = 'SELECT business_id, company_name, fax, email, website, address, address2, city, state, zipcode, phone, businesses.club_id FROM businesses, addresses WHERE businesses.address_id = addresses.address_id AND businesses.club_id = ?';

    $result = $db->query($query, $club_id);

    $records = $db->getObjectArray($result);

    $db->close();

    return $records;
}

// Returns HTML for the content of a drop-down 'select' box
function getBusinessesOptions() {
    $output = '';

    $businesses = getBusinesses();	

    $output .= '<option value="-1">Select a Business</option>';

    foreach( $businesses as $business ) {
        $output .= '<option value="'.$business->business_id.'">';
        $output .= $business->company_name . '</option>';
    }

    $output .= '<option value="newBusiness">Add a New Business</option>';

    return $output;
}

function getViewBusinesses( $currentSortIndex=0, $currentSortDir=0 )
{
    require_once('class/database.class.php');
    require_once("lib/auth.lib.php");  //Session

    $db = new database();

    //Authenticate
    $auth = GetAuthority();	

    if (!isset($_SESSION['club']))
    {
        return array();
    }

    $club_id = $_SESSION['club'];

    /* Determine query argument for sorting */
    if($currentSortIndex == 0)
        $sortBy = 'company_name';
    else if($currentSortIndex == 1)
        $sortBy = 'address';
    else if($currentSortIndex == 2)
        $sortBy = 'address2';
    else if($currentSortIndex == 3)
        $sortBy = 'city';
    else if($currentSortIndex == 4)
        $sortBy = 'state';
    else if($currentSortIndex == 5)
        $sortBy = 'zipcode';
    else if($currentSortIndex == 6)
        $sortBy = 'phone';  
    else if($currentSortIndex == 7)
        $sortBy = 'fax';
    else if($currentSortIndex == 8)
        $sortBy = 'email';
    else if($currentSortIndex == 9)
        $sortBy = 'website';

  /*  Determine query argument for sort direction
  Ascending is default    */
    if($currentSortDir == 1)
        $sortBy .= ' DESC';

    //users
    $query= "SELECT company_name, address, address2, city, state, zipcode, phone, fax, email, website, businesses.club_id FROM businesses, addresses WHERE businesses.address_id=addresses.address_id AND businesses.club_id = ? ORDER BY ".$sortBy;

    $result = $db->query($query, $club_id);
    $businesses = $db->getObjectArray($result);

    $db->close();

    return $businesses;
}

function addBusiness($address_id, $company, $fax, $email, $website)
{
    require_once('class/database.class.php');
    require_once('lib/auth.lib.php');  //Session

    $db = new database();

    if (!isset($_SESSION['club']))
    {
        die('Need a club');
    }

    $club_id = $_SESSION['club'];

    // Authenticate
    $auth = GetAuthority();	
    if($auth<1)
        die('Please login to complete this action');

    $sql = 'INSERT INTO businesses (business_id, address_id, company_name, fax, email, website, club_id) VALUES ( NULL, ?, ?, ?, ?, ?, ?)';

    $db->query($sql, $address_id, $company, $fax, $email, $website, $club_id);

    $id = $db->insertId();

    $db->close();

    return $id;
}

// AJAX function
function insertBusiness( $company, $address, $address2, $city, $state, $zip, $phone, $fax, $email, $website ) 
{
    require_once('class/database.class.php');
    require_once('lib/auth.lib.php');  //Session

    if (!isset($_SESSION['club']))
    {
        die('Need a club');
    }

    $club_id = $_SESSION['club'];

    // Authenticate
    $auth = GetAuthority();	
    if($auth<1)
        die('Please login to complete this action');

    $db = new database();

    if( strlen( $company ) == 0 ) {
        die( 'Must have a company name' );
    }

    if( strlen( $address )  == 0 ) {
        die( 'Must have an address' );
    }

    if( strlen( $city )  == 0 ) {
        die( 'Must have a city' );
    }

    if( strlen( $state ) == 0 ) {
        die( 'Must have a state' );
    }

    if( strlen( $zip ) == 0 ) {
        die( 'Must have a zip' );
    }

    if( strlen( $phone ) == 0 ) {
        die( 'Must have a phone number' );
    }

    if( strlen( $address2 )  == 0 ) {
        $address2 = null;
    }

    if( strlen( $fax ) == 0 ) {
        $fax = null;
    }

    if( strlen( $email ) == 0 ) {
        $email = null;
    }

    if( strlen( $website ) == 0 ) {
        $website = null;
    }

    $sql = 'INSERT INTO addresses (address_id, address, address2, city, state, zipcode, phone, club_id) VALUES ( NULL, ?, ?, ?, ?, ?, ?, ?)';

    $db->query($sql, $address, $address2, $city, $state, $zip, $phone, $club_id);

    $address_id = $db->insertId();

    $sql = 'INSERT INTO businesses (business_id, address_id, company_name, fax, email, website, club_id) VALUES ( NULL, ?, ?, ?, ?, ?, ?)';

    $db->query($sql, $address_id, $company, $fax, $email, $website, $club_id);

    $db->close();

    return 'success';
}

?>
