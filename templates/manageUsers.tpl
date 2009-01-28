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

<h3><a href="addUser.php">Add new user</a></h3>

<table width="900" border="0" class="itemsTable" cellspacing="0">
	<tr>
		<th>Name</th>
		<th width="100">Username</th>
		<th width="100">Access</th>
		<th width="100">RIN</th>
		<th width="150">Email</th>
		<th width="150">Actions</th>
	</tr>

{section name=userLoop loop=$users}
<tr{cycle values=" class=\"alt\","}>
	<td align="center">{$users[userLoop]->name}</td>
	<td align="center">{$users[userLoop]->username}</td>
	<td align="center">
	{if $users[userLoop]->access_level == 2}
		Administrator
	{elseif $users[userLoop]->access_level == 1}
		Manager
	{else}
		User
	{/if}
		
	</td>
	
	
	<td align="center">{$users[userLoop]->rin}</td>
	<td align="center">{$users[userLoop]->email}</td>
	
	<td align="center"><a href="editUser.php?id={$users[userLoop]->id}">Edit</a> or <input type="button" onclick="confirmation('Are you sure you want to delete user {$users[userLoop]->username} ?','deleteUser.php?id={$users[userLoop]->id}')" value="Delete User"></td>
</tr>
{/section}	


</table>