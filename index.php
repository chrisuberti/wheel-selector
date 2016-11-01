<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	echo "Temperature: " . fariengheight2kelvin($_POST['TempAir']);
	echo "Density: ". densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt']);
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
			<?php
			if(!empty($_POST['submit'])){
				$Tair = $_POST['TempAir'];$humidity = $_POST['RelHumidity'];$alt = $_POST['alt'];
			}else{
				$Tair = 50;$humidity = 10;$alt = 100;
			}
			?>
			<table>
				<tr>
				<td>Air Temperature: </td><td><input type="number" name="TempAir" value= <?php echo $Tair;?>> Degrees F</td>
				</tr>
				<tr>
					<td>Relative Humidity: </td><td><input type="number" name="RelHumidity" value=<?php echo $humidity;?>> %</td>
				</tr>
				<tr>
					<td>Altitude: </td><td><input type="number" name="alt" value=<?php echo $alt;?>> feet</td>
				</tr>
				<tr>
					
					<td><input type="submit" name="submit"></td>
				</tr>
			</table>
		</form>
	</div>

</body>

</html>
