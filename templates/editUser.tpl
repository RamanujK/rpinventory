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
    along with Foobar.  If not, see <http://www.gnu.org/licenses/>.

*}

<form name="storeTransaction" action="updateUserRecord.php" METHOD="post">

<h3>Edit User</h3>

<table width="400">

<input type="hidden" name="id" size="40" value="{$user->id}">

<tr>
	<td>Name: </td>
	<td><input type="text" name="name" size="40" value="{$user->name}"></td>
</tr>

<tr>
	<td>RIN: </td>
	<td><input type="text" name="rin" size="40" value="{$user->rin}"></td>
</tr>

<tr>
	<td>Email: </td>
	<td><input type="text" name="email" size="40" value="{$user->email}"></td>
</tr>

<tr>
	<td>Username: </td>
	<td><input type="text" name="username" size="40" value="{$user->username}"></td>
</tr>

<tr>
	<td>Password: (blank for same)</td>
	<td><input type="password" name="password" size="40"></td>
</tr>

<tr>
	<td>Permissions: </td>
	<td>
	<select name="access_level">
		<option value="2" {if $user->access_level == 2}selected{/if}>Administrator</option>
		<option value="1" {if $user->access_level == 1}selected{/if}>Manager</option>
		<option value="0" {if $user->access_level == 0}selected{/if}>User</option>
	</select>	
	</td>
</tr>



</table>

<br>
<input type="submit" value="Update User">

<form>
