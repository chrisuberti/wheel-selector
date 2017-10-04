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
         
         
         
            <?php echo form_open('add_wheels');?>
            <p><strong>Wheelset Name</strong>:<br />
			<input type="text" name="wheel_name" size="60" value = "<?php echo set_value('wheel_name')?>" /></p>
			
			<input type="number" name="weight" value = "<?php echo set_value('weight')?>" /></p>
			<input type="number" name="tubular" value = "<?php echo set_value('tubular')?>" /></p>
			
			
            <br clear="all" />
            
            
            <p><input type="submit" value="Submit" /></p>
            <?php echo form_close(); ?>
            
            <hr />
        </div><!-- Close content -->
        </div>

</body>
	

<?php $this->load->view('dressings/footer');?>
