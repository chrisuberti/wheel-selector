<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	//$rho = densityCalc($_POST['TempAir'], $_POST['relH'], $_POST['alt']);
	//echo "<br>Temperature: " . fariengheight2kelvin($_POST['TempAir']);
	$data = densityCalc($_POST['TempAir'], $_POST['relH'], $_POST['alt']);
	foreach ($data as $key => $value) {
		echo "<br>" . $key . ": " . $value;
	}
	
	
	
	include('header.php');
}


?>

<body>
	<div class="jumbotron"><h1>Wheel Selector</h1></div>
	<div id = "input-form">
		<form action="index.php" method="POST">
			<?php
			if(!empty($_POST['submit'])){
				$Tair = $_POST['TempAir'];$humidity = $_POST['relH'];$alt = $_POST['alt'];$P_a = $_POST['P_a'];
			}else{
				$Tair = 50;$humidity = 10;$alt = 100; $P_a = 30.00;
			}?>			
			<label for="TempAir">Air Temperature (F): </label>
			input.
			
			
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
