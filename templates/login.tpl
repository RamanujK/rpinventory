{*
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

*}

{include file=notificationArea.tpl}
<form name="inventoryLogin" id="inventoryLogin" action="authenticate.php" method="post">	
  <div class="ui-widget-smaller ui-widget-content ui-corner-all mainForm">
  

	{if $loginStatus == "fail"}
		<h3>Login Failed</h3>
	{/if}	

	<table cellspacing="5">	
		<tr>
			<td width="100">Username</td>
			<td><input type="text" name="username" id="username"></td>
		</tr>
		<tr>
			<td width="100">Password</td>
			<td><input type="password" name="password" id="password"></td>
		</tr>
		<tr>
			<td width="100">Club</td>
			<td>
				<select class="dropDown" id="club_id" name="club_id">
					<option value="-1">Select a club</option>
					{section name=club loop=$clubs}
					  <option value="{$clubs[club]->club_id}">
					  {$clubs[club]->club_name}</option>
					{/section}
				</select>
			</td>
		</tr>
	</table>

	<br>

	<input type="submit" value="Login">

</div>
</form>