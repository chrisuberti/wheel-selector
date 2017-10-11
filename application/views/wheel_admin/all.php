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
            <?php echo anchor('wheels/add_wheelset', '+ Add Wheelset');?>
            <?php 
            if(validation_errors()){echo validation_errors('<p class = "error">','</p>');}?>
            <?php echo output_message($this->session->flashdata('message')); ?>
            <?php echo $wheelset_table;?>
          </div><!-- Close content -->
        </div>
    </div>
</div>

</body>
	

        <?php $this->load->view('dressings/footer');?>
