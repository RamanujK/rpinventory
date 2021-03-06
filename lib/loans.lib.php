<?php
/*

  Copyright (C) 2010, All Rights Reserved.

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

/* Returns the loan associated with the loanId given */
function getLoan($loanId, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'SELECT loans.*, inventory.description, borrowers.name, borrowers.borrower_id,locations.location, inventory.current_condition FROM borrowers, loans, inventory, locations WHERE loans.loan_id = ? AND loans.inventory_id = inventory.inventory_id AND loans.borrower_id = borrowers.borrower_id AND loans.original_location_id = locations.location_id';

    $result = $db->query($sql, $loanId);

    $loan = $db->getObject($result);

    if ($close)
    {
        $db->close();
    }

    return $loan;
}

/* Takes two dates, formatted as YYYY-MM-DD */
function getLoans($startDate, $endDate, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    if (!isset($_SESSION['club']))
    {
        return array();
    }

    $club_id = $_SESSION['club'];

    // Loan History
    $query= 'SELECT issue_date, return_date, starting_condition, inventory.description, inventory.club_id, borrowers.borrower_id, borrowers.name AS username FROM loans, inventory, borrowers WHERE borrowers.borrower_id = loans.borrower_id AND loans.inventory_id = inventory.inventory_id AND issue_date >= ? AND (return_date <= ? OR return_date IS NULL) AND inventory.club_id = ?';

    $result = $db->query($query, $startDate, $endDate, $club_id);

    $records = $db->getObjectArray($result);

    if ($close)
    {
        $db->close();
    }

    return $records;
}

function getViewLoans($currentSortIndex=0, $currentSortDir=0, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    if (!isset($_SESSION['club']))
    {
        return array();
    }

    $club_id = $_SESSION['club'];

    //items
    $query = 'SELECT loan_id, loans.inventory_id, loans.club_id, name, loans.borrower_id, borrowers.borrower_id, issue_date, return_date, starting_condition, description FROM borrowers, loans, inventory WHERE loans.borrower_id = borrowers.borrower_id and inventory.inventory_id = loans.inventory_id AND loans.club_id = ? ';

    //Filter
    if(!isset($_GET['view']))
        $view = "all";
    else
        $view = $_GET['view'];

    if($view == "outstanding"){
        $query .= 'and return_date IS NULL ';
    }
    else if($view == "returned"){
        $query .= 'and return_date IS NOT NULL ';
    }

    $query .= 'ORDER BY ';

    /* Determine query argument for sorting */
    if($currentSortIndex == 0)
        $query .= 'description';
    else if($currentSortIndex == 1)
        $query .= 'starting_condition';
    else if($currentSortIndex == 2)
        $query .= 'username';
    else if($currentSortIndex == 3)
        $query .= 'issue_date';
    else if($currentSortIndex == 4)
        $query .= 'return_date';

    /* Determine sort direction */
    if($currentSortDir == 1)
        $query .= ' DESC';

    $result = $db->query($query, $club_id);

    $items = $db->getObjectArray($result);

    if ($close)
    {
        $db->close();
    }

    return $items;
}

function isLoanedOut($inventory_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'SELECT description FROM loans, inventory WHERE return_date is NULL and loans.inventory_id = inventory.inventory_id and loans.inventory_id = ?';

    $result = $db->query($sql, $inventory_id);

    $obj = NULL;

    if (mysqli_num_rows($result) != 0)
    {
        $obj = $db->getObject($result);
    }

    if ($close)
    {
        $db->close();
    }

    return $obj;
}

function addLoan($inventory_id, $borrower_id, $date, $condition, $location_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    if (!isset($_SESSION['club']))
    {
        return array();
    }

    $club_id = $_SESSION['club'];

    $sql = 'INSERT INTO loans (loan_id, inventory_id, borrower_id, issue_date, return_date, starting_condition, original_location_id, club_id) VALUES (NULL, ?, ?, ?, NULL, ?, ?, ?)';

    $db->query($sql, $inventory_id, $borrower_id, $date, $condition, $location_id, $club_id);

    if ($close)
    {
        $db->close();
    }

    return;
}

function getBorrowerActiveLoans($borrower_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'SELECT * from loans WHERE return_date is null AND borrower_id = ?';

    $result = $db->query($sql, $borrower_id);

    $records = $db->getObjectArray($result);

    if ($close)
    {
        $db->close();
    }

    return $records;
}

function getActiveLoansByOriginalLocation($location_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'SELECT original_location_id FROM loans WHERE return_date is null AND original_location_id = ?';

    $result = $db->query($sql, $borrower_id);

    $records = $db->getObjectArray($result);

    if ($close)
    {
        $db->close();
    }

    return $records;
}

function deleteLoan($loan_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'DELETE FROM loans WHERE loan_id = ?';

    //Run update
    $db->query($sql, $loan_id);

    if ($close)
    {
        $db->close();
    }

    return;
}

function deleteInventoryLoans($inventory_id, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'DELETE FROM loans WHERE inventory_id = ?';

    //Run update
    $db->query($sql, $loan_id);

    if ($close)
    {
        $db->close();
    }

    return;
}

function returnLoan($loan_id, $return_date, $db = null)
{
    $close = false;

    if (is_null($db))
    {
        require_once('class/database.class.php');

        $db = new database();

        $close = true;
    }

    $sql = 'UPDATE loans SET return_date = ? WHERE loan_id = ?';

    $db->query($sql, $return_date, $loan_id);

    if ($close)
    {
        $db->close();
    }

    return;
}

?>
