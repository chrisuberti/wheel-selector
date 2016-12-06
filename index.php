<?php 

require('constants.php');
include_once('components.php');
if(!empty($_POST['submit'])){
	
	$data = densityCalc($_POST['Tair'], $_POST['humidity'], $_POST['alt']);

include_once('header.php');	

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
=======


//Prepare some data
//if(!empty($_POST['submit'])){
//	$Tair = $_POST['Tair'];$humidity = $_POST['humidity'];$alt = $_POST['alt'];$P_a = //$_POST['P_a'];
//}else{
//	$Tair = 50;$humidity = 10;$alt = 100; $P_a = 30.00;
//}
?>

<script type="text/javascript">
	function density_calc(){
		var Tair = document.getElementById('Tair').value;
		var humidity = document.getElementById('humidity').value;
		var alt = document.getElementById('alt').value;
		
		var params = "Tair="+Tair+"&humidity="+humidity+"&alt="+alt;

		var xmlreq = new XMLHttpRequest();
		
		xmlreq.open("POST", "test.php", true);
		xmlreq.onreadystatechange = function(){
			if(xmlreq.readyState == 4 && xmlreq.status == 200){
				console.log(xmlreq.response);
				document.getElementById('test').innerHTML = xmlreq.responseText;
				document.getElementById('Tair').value = '';
				
			}
		};
			
		
		
		xmlreq.send(params);
         
	}

</script>
<body>
    <div class="jumbotron">
        <h1 class="text-center">Wheel Selector</h1>
    </div>
    <h2 id="test"></h2>

    <form class="form-horizontal" id="form-data" action = "index.php">
        <div class="col-md-6">
            <h3 class="text-center col-md-offset-1">Weather Metrics</h3>
            <div class="form-group">
                <label for="Tair" class="label-control col-md-2 col-md-offset-2">Air Temp (F):</label>
                <div class="col-md-8">
                    <input type="number" id="Tair" class="form-control" name="Tair" onkeyup="" />
                </div>
            </div>
            <div class="form-group">
                <label for="humidity" class="label-control col-md-2 col-md-offset-2">Humidity (%):</label>
                <div class="col-md-8">
                    <input type="number" id="humidity" class="form-control" name="humidity" />
                </div>
            </div>
            <div class="form-group">
                <label for="alt" class="label-control col-md-2 col-md-offset-2">Altitude (ft):</label>
                <div class="col-md-8">
                    <input type="number" id="alt" class="form-control" name="alt" />
                </div>
            </div>
            </div>
            <div class="col-md-6">
            	 <h3 class="text-center col-md-offset-1">Rider Metrics</h3>
	            <div class="form-group">
	                <label for="Wrider" class="label-control col-md-2 ">Rider Weight(kg):</label>
	                <div class="col-md-8">
	                    <input type="number" id="Wrider" class="form-control" name="Wrider" />
	                </div>
	            </div>
	            
	            <div class="form-group">
	                <label for="Wbike" class="label-control col-md-2">Bike Weight(kg):</label>
	                <div class="col-md-8">
	                    <input type="number" id="Wbike" class="form-control" name="Wbike" />
	                </div>
	            </div>
	        

            <div class="form-group">
	            <label for="wheelset" class="label-control col-md-2" >Wheelset:</label>
	            <div class="col-md-8">
	                <select name="wheelset" class="form-control" id = "wheelset">
	                    <option value="">Select Subject</option>
						<?php 
	                	foreach($positions as $position){
	                		echo "<option value='".$position."'>".$position."</option>";
	                	}?>
	                </select>
	            </div>
	            </div>
	         <div class="form-group">
	            <label for="rider_pos" class="label-control col-md-2">Rider Position:</label>
	            <div class="col-md-8">
	                <select name="rider_pos" class="form-control" id = "rider_pos">
	                	<option value="">Select Subject</option>
	                	<?php 
	                	foreach($positions as $position){
	                		echo "<option value='".$position."'>".$position."</option>";
	                	}?>
	                </select>
	            </div>
	            </div>
	            </div>
	       
                <div class="col-md-4 col-md-offset-4">
                    <button class="btn btn-success btn-block" onclick="density_calc();">Add New Record</button>
                </div>
              
	           
    </form>
            

>>>>>>> laptop2

</body>

</html>
