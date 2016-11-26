<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	//$rho = densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt']);
	//echo "<br>Temperature: " . fariengheight2kelvin($_POST['TempAir']);
	$data = densityCalc($_POST['TempAir'], $_POST['RelHumidity'], $_POST['alt']);
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
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


</head>

<body>
	<div class="jumbotron"><h1>Wheel Selector</h1></div>
	<div id = "input-form">
		<form action="index.php" method="POST">
			<?php
			if(!empty($_POST['submit'])){
				$Tair = $_POST['TempAir'];$humidity = $_POST['RelHumidity'];$alt = $_POST['alt'];$P_a = $_POST['P_a'];
			}else{
				$Tair = 50;$humidity = 10;$alt = 100; $P_a = 30.00;
			}?>
				<table class = "table">
					<tr>
					<td><h4>Weather Metrics</h4></td>
					</tr>
					<tr>
						<td><label for="TempAir">Air Temperature: </label></td>
						<td><input type="number" name="TempAir" value=<?php echo $Tair;?>> Degrees F</td>
					</tr>
					<tr>
						<td>Relative Humidity: </td>
						<td><input type="text" name="RelHumidity" value=<?php echo $humidity;?>> %</td>
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
