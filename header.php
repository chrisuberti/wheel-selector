
<?php $url = 'c9';?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Wheel Selector</title>

	<?php 
	if($url=='local'){?>

	<script src = "..\..\CDN\jquery-3.1.1.min.js"></script>
	<link rel="stylesheet" href="..\..\CDN\bootstrap-3.3.7-dist\css\bootstrap.min.css">
	<link rel="stylesheet" href="..\..\CDN\bootstrap-3.3.7-dist\css\bootstrap.min.css">
	<link rel="stylesheet" href="..\..\CDN\bootstrap-3.3.7-dist\css\bootstrap-theme.css">

	<?php
	}

		elseif($url == 'c9'){
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
<?php 
		}
	?>

</head>
