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
								    <option value="ravencrest">Ravencrest</option>
								    <option value="auchindoun">Auchindoun</option>
								 </select></td>
							</tr>
							<tr>
								<td>Region:</td>
								<td><select name="region" class="mainboxelement">
								    <option value="eu">Eu</option>
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

