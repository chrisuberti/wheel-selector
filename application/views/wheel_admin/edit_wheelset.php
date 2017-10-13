<?php $this->load->view('dressings/header');?>
<?php $this->load->view('dressings/navbar');?>

<!-- Added these scripts to beautify textarea's-->


<body>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class = "page-header"><?php echo $title;?></h1>
            <p><?php echo lang('index_subheading');?></p>
        </div>

    <div id="content-outer" class ="clear"><div id="content-wrapper">
        <div id="content"><div class="col-one">
            <?php 
            if(validation_errors()){echo validation_errors('<p class = "error">','</p>');}?>
            <?php echo output_message($this->session->flashdata('message')); ?>
            <?php echo "<br>". anchor('wheels/all_wheelsets', "All Wheelsets");?>
         
         
         
            <?php echo form_open('wheels/edit_wheelset/'.$wheelset_id);?>
            <p><strong>Wheelset Name</strong>:<br />
			<input type="text" name="wheel_name" size="80" value = "<?php echo $name?>" /></p>
			Wheelset Weight (grams): 
			<input type="number" name="weight" value = "<?php echo $weight?>" /></p>
			Tubular (select if true):
			<?php echo form_radio(array('name'=>'tubular', 'checked' => $tubular));?>
			<hr>
			<br>
			<table>
			    <tr>
			        <td>Enter Wheel Drag</td>
			     <tr>
			     <tr>
			         <td> 0 </td> <td>  5</td> <td>  10 </td> <td> 15</td> <td>20</td>
			     </tr>
			     <tr>
			         
			<?php 
			    for($i = 0; $i < 25; $i = $i+5){
			        $drag='deg'.$i;
			        echo "<td>". form_input(array('name'=>'deg'.$i, 'type' => 'number', 'value'=>$$drag)) . "</td>";
			    }
			?>
				</tr>
			</table>
			
            <br clear="all" />
            
            
            <p><input type="submit" value="Update" /></p>
            <?php echo form_close(); ?>
            <?php echo $del_button;?>
            
            <hr />
        </div><!-- Close content -->
        </div>

</body>
	

<?php $this->load->view('dressings/footer');?>
