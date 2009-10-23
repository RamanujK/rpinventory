{*
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

*}
<span class="TopOfTable">
	<h3>Create Purchase</h3>
</span>
{$tooltip.helpDiv}
<form id="AjaxForm" name="purchaseItem" action="insertPurchaseRecord.php" onsubmit="return ValidateForm()" METHOD="post">

  <input type="hidden" name="count" id="count" value="1">

  <ul style="list-style-type:none">
    <input type="checkbox" name="ignoreBusiness" id="ignoreBusiness" onclick="hideBusiness()"/>
    <label for="ignoreBusiness">Ignore Business Information</label>
		{$tooltip.ignoreBusiness}
    <br />

    <span id="businessInformation">
    <br />
    <li>
        <table><tr>
	<td>Purchased	From:</td>
      
	<td><select class="dropDown" id="business_id" name="business_id" onChange="OnChange('business_id', 'newBusiness')" class="validate_cond">
	<option value="-1">Select a Business</option>
	{section name=bus loop=$businesses}
	<option value="{$businesses[bus]->business_id}">
	  {$businesses[bus]->company_name}
	</option>
	{/section}

	<option value="newBusiness">
	  Add a New Business
	</option>
      </select>
		<span id="business_result" style="display:none"></span>
      </td>
     </tr>
     <tr id="newBusiness" style="display:none;">
      <td colspan="2">
      <table style="padding-left: 1cm">	
     	<tr>
	  <td>Company Name:</td>
	  <td><input type="text" name="company" size="30" id="company" class="validate_cond_bus" onchange="sendValidateRequest('company')"></td>
     	</tr>

     	<tr>
	  <td>Address:</td>
	  <td> <input type="text" name="address" size="30" id="address" class="validate_cond_bus"></td>
     	</tr>

     	<tr>
	  <td>Address 2:</td>
	  <td><input type="text" name="address2" id="address2" size="30"></td>
     	</tr>

     	<tr>
	  <td>City: </td>
	  <td><input type="text" name="city" size="30" id="city" class="validate_cond_bus"></td>
     	</tr>

     	<tr>
	  <td>State: </td>
	  <td><input type="text" name="state" size="10" id="state" class="validate_cond_bus"></td>
     	</tr>

     	<tr>
	  <td>Zip Code: </td>
	  <td><input type="text" name="zip" size="10" id="zip" class="validate_cond_bus"></td>
     	</tr>

     	<tr>
	  <td>Phone Number: </td>
	  <td><input type="text" name="phone" size="20" id="phone" class="validate_cond_bus"></td>
     	</tr>

     	<tr>
	  <td>Fax Number: </td>
	  <td><input type="text" name="fax" id="fax" size="20"></td>
     	</tr>

     	<tr>
	  <td>E-mail: </td>
	  <td><input type="text" name="email" id="email" size="30"></td>
     	</tr>

     	<tr>
	  <td>Website: </td>
	  <td><input type="text" name="website" id="website" size="30"></td>
	  <td><input type="button" value="Save Business" onclick="saveBusiness('business_result', 'business_id', 'newBusiness', 'company', 'address', 'address2', 'city', 'state', 'zip', 'phone', 'fax', 'email', 'website');" /></td>
     	</tr>
      </table>
     </td>
    </tr>
    <tr>
      <td>
	Date:
      </td>
      <td>
	{html_select_date start_year="-3" end_year="+2"	class="dropDown"}
     </td>
    </tr>

    <tr>
     <td>
      Total Value of Purchase: 
     </td>
     <td>
      <input type="text" name="total_cost" value="0.00" id="total_cost" class="validate" readonly="readonly" />
     </td>
    </tr>
    <tr>
        <td>
            Miscellaneous Costs:
        </td>
        <td>
            <input type="text" name="misc_cost" value="0.00" title="0.00" id="misc_cost" class="autoClear validate" onchange="updateTotal('misc_cost')" />
        </td>
    </tr>
    </table>
    </span>

    <br />

    <div id="itemTable">
      <div id="item-0" class="item">
	<table>
	  <tr>
	    <td>Item Description: </td>
	    <td><input type="text" name="desc-0" size="40" id="description-0" class="validate"></td>
	  </tr>
	  
	  <tr>
	    <td>Value: </td>
	    <td><input type="text" name="value-0" id="value-0" class="value validate" onchange="updateTotal('value-0')"></td>
	  </tr>
	  
		<tr>
			<td>Category: </td>
			<td>
				<input type="hidden" id="category_count-0" name="category_count-0" value="1">

				<select multiple="multiple" id="category-0" name="category-0[]" class="category_select" title="Please select a category">
					{$category_options}
				</select>
				
				<br />
				<a id="add_category_button-0" class="ui-state-default ui-corner-all icon_button add_category_button">
					<span class="ui-icon ui-icon-plus icon_button_icon"><!-- --></span>Add Category
				</a>
				
			</td>
			<td>
				<span id="category_notification-0" name="category_notification-0" class="notification"><!-- --></span>
			</td>
		</tr>

	  <tr>
	    <td>Condition: </td>
	    <td>
	      <select class="dropDown" name="condition-0" id="condition-0">
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
	      <select class="dropDown" id="location-0" name="location-0" onChange="OnChangeDouble('location-0', 'newLocation-0', 'newDescription-0')" onFocus="getLocationOptions(this);">

			{$locations}
		
	      </select>
	    <span id="resultText-0"></span>
	    </td>
	  </tr>

	  <tr id="newLocation-0" style="display:none">
	    <td>New Location:</td>
	    <td>
	      <input type="text" name="newlocation-0" id="newlocation-0" size="40" onChange="sendValidateRequest('newlocation-0')">
	    </td>
	  </tr>
	  <tr id="newDescription-0" style="display:none">
	    <td>Location Description:</td>
	    <td>
	      <input type="text" name="newdescription-0" id="newdescription-0" size="40">
	    </td>
	    <td><input value="Save Location" type="button" onClick="saveLocation('newlocation-0', 'newdescription-0', 'resultText-0', 'location-0', 'newLocation-0', 'newDescription-0');">
	    </td>
	  </tr>
	</table>
      </div>
    <br />
    </div>
    <div>
      <td><input type="button" class="button" onClick="addItemField();" value="Add Item">
	<input type="button" class="button" id="removeButton" style="display:none;" onClick="removeItemField();" value="Remove Last Item"></td>
      <td></td>
    </div>

    
</ul>
<br />
<input type="submit" value="Purchase">
</form>
