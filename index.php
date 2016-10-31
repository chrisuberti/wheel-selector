<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	echo "Temperature: " . fariengheight2kelvin($_POST['TempAir']);
	echo "Pressure: ". densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt']);
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Wheel Selector</title>
</head>

<body>
	<div>
		<form action="index.php" method="POST">
			<table>
				<tr>
				<td>Air Temperature: </td><td><input type="number" name="TempAir" value=7 0> Degrees F</td>
				</tr>
				<tr>
					<td>Relative Humidity: </td><td><input type="number" name="RelHumidity" value=10> %</td>
				</tr>
				<tr>
					<td>Altitude: </td><td><input type="number" name="alt" value=0> feet</td>
				</tr>
				<tr>
					
					<td><input type="submit" name="submit"></td>
				</tr>
			</table>
		</form>
	</div>

</body>

</html>
