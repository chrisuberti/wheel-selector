<?php 

require('constants.php');
if(!empty($_POST['submit'])){
	
	//$rho = densityCalc($_POST['Tair'], $_POST['humidity'], $_POST['alt']);
	//echo "<br>Temperature: " . fariengheight2kelvin($_POST['Tair']);
	$data = densityCalc($_POST['Tair'], $_POST['humidity'], $_POST['alt']);
	foreach ($data as $key => $value) {
		echo "<br>" . $key . ": " . $value;
	}
	
}

include_once('header.php');	



//Prepare some data
if(!empty($_POST['submit'])){
	$Tair = $_POST['Tair'];$humidity = $_POST['humidity'];$alt = $_POST['alt'];$P_a = $_POST['P_a'];
}else{
	$Tair = 50;$humidity = 10;$alt = 100; $P_a = 30.00;
}
?>

<script type="text/javascript">
	function density_calc(){
		var Tair = document.getElementById('Tair').value;
		var humidity = document.getElementById('humidity').value;
		var alt = document.getElementById('alt').value;

		var httpreq = new XMLHttpRequest();
		httpreq.onreas
           
	}

</script>


<body>
<div class="jumbotron"><h1 class="text-centered">Wheel Selector</h1></div>
<form class = "form-horizontal" id = "form-data">
<h3 class="text-centered col-md-offset-1">Weather Metrics</h3>
        <div class="form-group">
            <label for="Tair" class="label-control col-md-1 col-md-offset-1">Air Temp (F):</label>
            <div class="col-md-4">
                <input type="number" id = "Tair" class= "form-control" name="Tair"/>
            </div>
        </div>
        <div class="form-group">
            <label for="humidity" class="label-control col-md-1 col-md-offset-1">Humidity (%):</label>
            <div class="col-md-4">
                <input type="number" id = "humidity" class= "form-control" name="humidity"/>
            </div>
        </div>
        <div class="form-group">
            <label for="alt" class="label-control col-md-1 col-md-offset-1">Altitude (ft):</label>
            <div class="col-md-4">
                <input type="number" id = "alt" class= "form-control" name="alt"/>
            </div>
        </div>
        <!--<div class="form-group">
            <label for="name" class="label-control col-md-1" for = "subject">Subject</label>
            <div class="col-md-5">
                <select name="" class="form-control" id = "subject">
                    <option value="">Select Subject</option>
                    <option value="Chemestry">Chemestry</option>
                    <option value="Physics">Physics</option>
                    <option value="Computers">Computers</option>
                    <option value="Math">Math</option>
                </select>
            </div>-->
            <div class="form-group">
                <div class="col-md-5 col-md-offset-1">
                    <button class = "btn btn-success btn-block" onclick="density_calc();">Add New Record</button>
                </div>
            </div>
        </div>
    </form>


</body>

</html>
