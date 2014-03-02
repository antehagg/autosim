<!DOCTYPE html>
<html>
	<head>
		<style>
			body
			{
				background-color: #98bf21;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<div class="container">
			<div class="header">
			<h1 class="h1">Autosim</h1>
			</div>
			<div class="menubox">
				<ul class="navilist">
					<li class="navilistitem"><a class="navibuttons" href="index.php">Home</a></li>
					<li class="navilistitem"><a class="navibuttons" href="charpage.php">Character</a></li>
				</ul>
			</div>
			<div class="mainbox">
				<div id="loginbox">
					<form action="charpage.php" method="get">
						<table>
							<tr>
								<td>Character:</td>
								<td><input type="text" name="charname" class="mainboxelement"></td>
							</tr>
							<tr>
								<td>Server:</td>
								<td><select name="server" class="mainboxelement">
								<?php
									require_once "/var/www/html/autosim/includes/dbApi/realmDb.php";
									$realmDb = new RealmDb();
									$realmNames = $realmDb->getRealmNames();

									foreach($realmNames as $realmName)
									{
										if($realmName != 'None')
											echo "<option value=\"$realmName\">$realmName</option>";
									}
								?>
								 </select></td>
							</tr>
							<tr>
								<td>Region:</td>
								<td><select name="region" class="mainboxelement">
								<?php
									require_once "/var/www/html/autosim/includes/dbApi/regionDb.php";
									$regionDb = new RegionDb();
									$regionNames = $regionDb->getRegionNames();

									foreach($regionNames as $regionName)
									{
										if($regionName != 'None')
											echo "<option value=\"$regionName\">$regionName</option>";
									}
								?>
								 </select></td>
							</tr>
							<tr>
								<td></td>
								<td><input class="alignright" type="submit" value="Submit"></td>
							</tr>
						</table>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>



