<?php 

require('constants.php');

echo "Temperature: " . celcius2farienheight($_POST['temp'])
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wheel Selector</title>
</head>
<body>
	<div>
		<form action="index.php" method = "POST">
			<table>
			<tr>
				<input type="number" name ="TempAir" value = 70> Degrees F
				</tr>
				<tr>
				<input type="number" name ="RelHumidity" value=10> %
				</tr>
				
				<input type="submit">
			</table>
		</form>
	</div>
	
</body>
</html>