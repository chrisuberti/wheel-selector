<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	//$rho = densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt']);
	//echo "<br>Temperature: " . fariengheight2kelvin($_POST['TempAir']);
	$data = densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt'], $_POST['P_a']);
	foreach ($data as $key => $value) {
		echo "<br>" . $key . ": " . $value;
	}
	
	
	
	
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Wheel Selector</title>
</head>

<body>
	<div id = "input-form">
		<form action="index.php" method="POST">
			<?php
			if(!empty($_POST['submit'])){
				$Tair = $_POST['TempAir'];$humidity = $_POST['RelHumidity'];$alt = $_POST['alt'];$P_a = $_POST['P_a'];
			}else{
				$Tair = 50;$humidity = 10;$alt = 100;
			}?>
				<table>
					<tr>
					<td><h4>Weather Metrics</h4></td>
					</tr>
					<tr>
						<td>Air Temperature: </td>
						<td><input type="number" name="TempAir" value=<?php echo $Tair;?>> Degrees F</td>
					</tr>
					<tr>
						<td>Relative Humidity: </td>
						<td><input type="text" name="RelHumidity" value=<?php echo $humidity;?>> %</td>
					</tr>
					<tr>
						<td>Air Pressure: </td>
						<td><input type="text" name="P_a" value=<?php echo $P_a;?>> inHg</td>
					</tr>
					<tr>
						<td>Altitude: </td>
						<td><input type="number" name="alt" value=<?php echo $alt;?>> feet</td>
					</tr>
					<tr>
						<td>
							<h4>Rider Metrics</h4>
						</td>
					</tr>
					<tr>
						<td>Rider Weight: </td>
						<td><input type="number" name="weight_rider" value=<?php echo $weight_rider;?>> Kilograms</td>
					</tr>
					<tr>
						<td>Bike Weight: </td>
						<td><input type="number" name="weight_bike" value=<?php echo $weight_bike;?>> Kilograms</td>
					</tr>
					<tr>
						<td>Riding Position: </td>
						<td>
							<select name="position" id="">
								<option value="hoods">Hoods</option>
								<option value="drops">Drops</option>
								<option value="super-tuck">SuperTuck</option>
							</select>
						</td>
					</tr>
					<tr>
						<td><input type="submit" name="submit"></td>
					</tr>
				</table>
		</form>
	</div>
	<hr>

</body>

</html>
