<body>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class = "page-header"><?php echo $title;?></h1>
            <p><?php echo lang('index_subheading');?></p>
        </div>
    </div>

    <div class="row">

            <?php 
                if(validation_errors()){echo validation_errors('<p class = "error">','</p>');}
                echo  ($this->session->flashdata('message'));
               // preprint($this->session->flashdata('weather_data'));
                echo anchor('wheels');
            ?>
         
            
            <div class='col-md-4'>
                <table>
                     <tr>
                        <td><h4>Or: </h4></td>
                        
                    </tr>
                    <tr>
                        <?php echo form_open('wheels');?>
                        <td><?php echo form_label('Enter Zip Code: ', 'zip_code');?></td>
                        <td><?php echo form_input($zip_code);?></td>
                       
                    </tr>
                    <tr>
                        <td><p><?php echo form_submit(array('name'=>'weather_submit', 'value'=>'Get Weather'));?></p></td>
                          <?php form_close();?>
                    </tr>
                    <?php echo form_open_multipart('wheels/index');?>
                    <tr><td><h3>Weather Metrics: </h3></td></tr>
                    <tr>
                        <td><?php echo form_label('Air Temperature (F): ', 'air_temp');?></td>
                        <td><?php echo form_input($air_temp);?>

                    </tr>
                    <tr>
                        <td><?php echo form_label('Ride Altitude (ft): ', 'altitutde');?></td>
                        <td><?php echo form_input($altitude);?>

                    </tr>
                    
                    <tr>
                        <td><?php echo form_label('Humidity (%): ', 'humidity');?></td>
                        <td><?php echo form_input($humidity);?></td>
                    </tr>

                   
                    <tr><td><h3>Ride Metrics: </h3></td></tr>
                    
                    <tr>
                        <td><?php echo form_label('Distance (miles): ', 'distance');?></td>
                        <td><?php echo form_input($distance);?></td>
                    </tr>
                    
                    <tr>
                        <td><?php echo form_label('Climbing (feet): ', 'climbing');?></td>
                        <td><?php echo form_input($climbing);?></td>
                    </tr>
                    <tr>
                        <td><?php echo form_label('Ride Type: ', 'ride_type');?></td>
                        <td><?php echo form_dropdown($ride_type,$ride_type_options);?></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-4">
                <table>
                    <tr><td><h3>Bike Metrics: </h3></td></tr>
                    <tr>
                        <td><?php echo form_label('Bike Weight (lbs): ', 'bike_weight');?></td>
                        <td><?php echo form_input($bike_weight);?>
                    </tr>
                    <tr>
                         <td><?php echo form_label('Wheelset: ', 'wheelset');?></td>
                         <td><?php echo form_dropdown($wheelset, $wheelset_options);?></td>
                    </tr>
                    <tr><td><h3>Rider Metrics: </h3></td></tr>
                    <tr>
                        <td><?php echo form_label('Rider Weight (lbs): ', 'rider_weight');?></td>
                        <td><?php echo form_input($rider_weight);?>
                    </tr>
                    <tr>
                         <td><?php echo form_label('Rider Height (inches): ', 'rider_height');?></td>
                         <td><?php echo form_input($rider_height);?></td>
                    </tr>
                    <tr>
                        <td><hr></td>
                    </tr>

                </table>
            </div>
            <div class="col-md-3">
                This is a test
            </div>
        </div>


    <div class="row">
                    
                    <?php echo form_submit(array('name'=>'wheel_submit', 'value'=>'Calculate', 'formaction'=>'wheels/index'));?></td>
                    
    </div>
</div>


</body>
	