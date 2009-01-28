{*
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

*}

<h3>Create Purchase</h3>


{if $count == 0}

<form name="purchaseCount" action="addPurchase.php" METHOD="get">


Item Count: <input type="text" name="count" size="10">

<input type="submit" value="Go">


{else}

<form id="AjaxForm" name="purchaseItem" action="insertPurchaseRecord.php" METHOD="post">

<input type="hidden" name="count" value="{$count}">

<ul style="list-style-type:none">
<li>
	Purchased From:
		
	<select id="business_id" name="business_id" onChange="OnChange('business_id', 'newBusiness')">
		<option value="-1">Select Business</option>
		{section name=bus loop=$businesses}
			<option value="{$businesses[bus]->business_id}">
				{$businesses[bus]->company_name}
			</option>
		{/section}

		<option value="newBusiness">
			Add a New Business
		</option>
	</select>
</li>
<li>
           <table id="newBusiness" style="display:none;padding-left:1cm">	

     	 	<tr>
			<td>Company Name:</td>
			<td><input type="text" name="company" size="30"></td>
     	 	</tr>

     	 	<tr>
			<td>Address:</td>
			<td> <input type="text" name="address" size="30"></td>
     	 	</tr>

     	 	<tr>
			<td>Address 2:</td>
			<td><input type="text" name="address2" size="30"></td>
     	 	</tr>

     	 	<tr>
			<td>City: </td>
			<td><input type="text" name="city" size="30"></td>
     	 	</tr>

     	 	<tr>
			<td>State: </td>
			<td><input type="text" name="state" size="10"></td>
     	 	</tr>

     	 	<tr>
			<td>Zip Code: </td>
			<td><input type="text" name="zip" size="10"></td>
     	 	</tr>

     	 	<tr>
			<td>Phone Number: </td>
			<td><input type="text" name="phone" size="20"></td>
     	 	</tr>

     	 	<tr>
			<td>Fax Number: </td>
			<td><input type="text" name="fax" size="20"></td>
     	 	</tr>

     	 	<tr>
			<td>E-mail: </td>
			<td><input type="text" name="email" size="30"></td>
     	 	</tr>

     	 	<tr>
			<td>Website: </td>
			<td><input type="text" name="website" size="30"></td>
     	 	</tr>
	</table>
</li>
<br />
<li>
	Date: 
	            <select name="months">
                    <option value="1"{if $selectDate.mon == 1}selected{/if}>January</option>
                    <option value="2"{if $selectDate.mon == 2}selected{/if}>February</option>
                    <option value="3"{if $selectDate.mon == 3}selected{/if}>March</option>
                    <option value="4"{if $selectDate.mon == 4}selected{/if}>April</option>
                    <option value="5"{if $selectDate.mon == 5}selected{/if}>May</option>
                    <option value="6"{if $selectDate.mon == 6}selected{/if}>June</option>
                    <option value="7"{if $selectDate.mon == 7}selected{/if}>July</option>
                    <option value="8"{if $selectDate.mon == 8}selected{/if}>August</option>
                    <option value="9"{if $selectDate.mon == 9}selected{/if}>September</option>
                    <option value="10"{if $selectDate.mon == 10}selected{/if}>October</option>
                    <option value="11"{if $selectDate.mon == 11}selected{/if}>November</option>
                    <option value="12"{if $selectDate.mon == 12}selected{/if}>December</option>
                </select>

                <select name="days">
                    <option value="1"{if $selectDate.mday == 1}selected{/if}>1</option>
                    <option value="2"{if $selectDate.mday == 2}selected{/if}>2</option>
                    <option value="3"{if $selectDate.mday == 3}selected{/if}>3</option>
                    <option value="4"{if $selectDate.mday == 4}selected{/if}>4</option>
                    <option value="5"{if $selectDate.mday == 5}selected{/if}>5</option>
                    <option value="6"{if $selectDate.mday == 6}selected{/if}>6</option>
                    <option value="7"{if $selectDate.mday == 7}selected{/if}>7</option>
                    <option value="8"{if $selectDate.mday == 8}selected{/if}>8</option>
                    <option value="9"{if $selectDate.mday == 9}selected{/if}>9</option>
                    <option value="10"{if $selectDate.mday == 10}selected{/if}>10</option>
                    <option value="11"{if $selectDate.mday == 11}selected{/if}>11</option>
                    <option value="12"{if $selectDate.mday == 12}selected{/if}>12</option>
                    <option value="13"{if $selectDate.mday == 13}selected{/if}>13</option>
                    <option value="14"{if $selectDate.mday == 14}selected{/if}>14</option>
                    <option value="15"{if $selectDate.mday == 15}selected{/if}>15</option>
                    <option value="16"{if $selectDate.mday == 16}selected{/if}>16</option>
                    <option value="17"{if $selectDate.mday == 17}selected{/if}>17</option>
                    <option value="18"{if $selectDate.mday == 18}selected{/if}>18</option>
                    <option value="19"{if $selectDate.mday == 19}selected{/if}>19</option>
                    <option value="20"{if $selectDate.mday == 20}selected{/if}>20</option>
                    <option value="21"{if $selectDate.mday == 21}selected{/if}>21</option>
                    <option value="22"{if $selectDate.mday == 22}selected{/if}>22</option>
                    <option value="23"{if $selectDate.mday == 23}selected{/if}>23</option>
                    <option value="24"{if $selectDate.mday == 24}selected{/if}>24</option>
                    <option value="25"{if $selectDate.mday == 25}selected{/if}>25</option>
                    <option value="26"{if $selectDate.mday == 26}selected{/if}>26</option>
                    <option value="27"{if $selectDate.mday == 27}selected{/if}>27</option>
                    <option value="28"{if $selectDate.mday == 28}selected{/if}>28</option>
                    <option value="29"{if $selectDate.mday == 29}selected{/if}>29</option>
                    <option value="30"{if $selectDate.mday == 30}selected{/if}>30</option>
                    <option value="31"{if $selectDate.mday == 31}selected{/if}>31</option>
                </select>
				
				
                <select name="year">
                    <option value="2007"{if $selectDate.year == 2007}selected{/if}>2007</option>
                    <option value="2008"{if $selectDate.year == 2008}selected{/if}>2008</option>
					<option value="2009"{if $selectDate.year == 2009}selected{/if}>2009</option>
                </select>
	
</li>

<br />

<li>
	Total Value of Purchase: 
	<input type="text" name="total_cost" value="">
</li>

<br>

<table width="500" border="0">

{section name=foo loop=$count}
<tr>
        <td><b>Item {$smarty.section.foo.index+1}:</b></td>
</tr>
<tr>
	<td>Item Description:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </td>
	<td><input type="text" name="desc{$smarty.section.foo.index}" size="40"></td>
</tr>

<tr>
	<td>Value: </td>
	<td><input type="text" name="value{$smarty.section.foo.index}"></td>
</tr>

<tr>
	<td>Condition: </td>
	<td>
		<select name="condition{$smarty.section.foo.index}">
			<option value="Excellent">Excellent</option>
			<option value="Good">Good</option>
			<option value="Fair">Fair</option>
			<option value="Poor">Poor</option>
		</select>
	</td>
</tr>

<tr>
	<td>Location: </td>

	<td>
	<select id="location{$smarty.section.foo.index}" name="location{$smarty.section.foo.index}" onChange="OnChangeDouble('location{$smarty.section.foo.index}', 'newLocation{$smarty.section.foo.index}', 'newDescription{$smarty.section.foo.index}')">
	{section name=loc loop=$locations}
		<option value="{$locations[loc]->location_id}">
			{$locations[loc]->location}
		</option>
	{/section}
		<option value="newLocation">
			New Location
		</option>
	</select>
	
	</td>
</tr>

<tr id="newLocation{$smarty.section.foo.index}" style="display:none">
        <td>New Location:</td>
	<td>
	        <input type="text" name="newlocation{$smarty.section.foo.index}" size="40">
	</td>
</tr>
<tr id="newDescription{$smarty.section.foo.index}" style="display:none">
        <td>Location Description:</td>
	<td>
	        <input type="text" name="newdescription{$smarty.section.foo.index}" size="40">
	</td>
</tr>

{/section}
</table>




</ul>

<br>

<input type="submit" value="Add">

{/if}


</form>