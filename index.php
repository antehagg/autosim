
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/main.css">
	</head>
	<body>
		<div class="mainbox">
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
	</body>
</html>


