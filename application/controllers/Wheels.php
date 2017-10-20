<?php
defined('BASEPATH') OR exit('No direct script access allowed');



class Wheels extends MY_Controller {

	 public function __construct(){
	 	parent::__construct();
	 	$this->load->model(array('wheelset'));
	 	$this->load->library(array('form_validation', 'table'));
		$this->load->helper(array('url','language', 'constants', 'form'));

		$this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
		
		
		$data['title']='Wheelsets - '.$this->config->item('site_title', 'ion_auth');
		
		$this->load->vars($data);
	 }

	 	
	 public function all_wheelsets(){
	 	    	if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			$this->table->set_template(array('table_open'=>"<table class='table table-striped table-bordered table-hover' id='post_summary_table'>"));
			$this->table->set_heading('Wheelset',array('data'=>'&nbsp', 'style'=>'width:20%'), 'Weight', '');
				
			$wheelsets = $this->wheelset->find_all();
			//preprint($wheelsets);
			if($wheelsets){
				foreach($wheelsets as $wheel_info){
					
					$wheel_name = $wheel_info->wheel_name;
					$wheel_drag = Wheelset_drag::find_by('wheelset_id', $wheel_info->id);
					$title = $wheel_info->wheel_name . "<br>".anchor('wheels/edit_wheelset/'.$wheel_info->id, 'Edit', array('class'=>'btn btn-success'));
					$picture = "blank";
					//$wheel_mfg = $wheel_info->manufacturer; 
					$wheel_weight = $wheel_info->weight;
					
					$del_button = form_open('wheels/del_wheelset/'.$wheel_info->id);
	    			$del_button .= form_submit('del_wheelset', 'Delete', array('class'=>'btn btn-danger',"onClick"=>"return deleteconfirm();"));
	    			$del_button .= form_close();
	    			
	    								
					$edit_button = form_open('wheels/edit_wheelset/'.$wheel_info->id);
	    			$edit_button .= form_submit('edit_wheelset', 'Edit', array('class'=>'btn btn-success'));
	    			$edit_button .= form_close();
					
					$this->table->add_row($wheel_name, $picture, $wheel_weight, $del_button, $edit_button);
					
				}
				$data['wheelset_table']=$this->table->generate();
			}else{
				$data['wheelset_table']="<br> There are no Wheels yet add some wheels";
			}
			$this->load->view('wheel_admin/all', $data);
		}
			
	}
		
	
	 
	 public function edit_wheelset($id=NULL){
    	if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
		}else{
			
			$this->form_validation->set_rules('wheel_name', 'Wheel Name', 'required|max_length[255]');
			$this->form_validation->set_rules('weight', 'Weight', 'required|numeric|greater_than[0]');
			$this->form_validation->set_rules('tubular', 'Tubular', '');
			$this->form_validation->set_rules('deg0', 'CdA at 0 deg', 'required|numeric');
			$this->form_validation->set_rules('deg5', 'CdA at 5 deg', 'required|numeric');
			$this->form_validation->set_rules('deg10', 'CdA at 10 deg', 'required|numeric');
			$this->form_validation->set_rules('deg15', 'CdA at 15 deg', 'required|numeric');
			$this->form_validation->set_rules('deg20', 'CdA at 20 deg', 'required|numeric');
		
			if($id == NULL){
				$this->session->set_flashdata('message', 'No Photo Found');
				
				redirect('wheels/all_wheelsets');
			}elseif($wheelset_info = Wheelset::find_by_id($id)){
				//prepopulate information from edit 
				$data['name'] = $wheelset_info->wheel_name;
				$data['weight']=$wheelset_info->weight;
				$data ['tubular']=$wheelset_info->tubular;
				$data['wheelset_id']=$wheelset_info->id;
				$drag_data = Wheelset_drag::find_by('wheelset_id', $wheelset_info->id);
				
				$data['deg0'] = $drag_data->deg0;
				$data['deg5'] = $drag_data->deg5;
				$data['deg10'] = $drag_data->deg10;
				$data['deg15'] = $drag_data->deg15;
				$data['deg20'] = $drag_data->deg20;
				
				
				if(!empty($_POST)){
					
					$wheelset_info->wheel_name = $this->input->post('wheel_name');
					$wheelset_info->weight = $this->input->post('weight');
					$wheelset_info->tubular = $this->input->post('tubular')==NULL ? 0 : 1;
					$wheelset_info->save();
					
					$drag_data->deg0 = $this->input->post('deg0');
					$drag_data->deg5 = $this->input->post('deg5');
					$drag_data->deg10 = $this->input->post('deg10');
					$drag_data->deg15 = $this->input->post('deg15');
					$drag_data->deg20 = $this->input->post('deg20');
					$drag_data->save();
					
					$this->session->set_flashdata('message', 'Wheelset Successfully Updated');
					redirect('wheels/edit_wheelset/'.$wheelset_info->id);
				}
				
        		

				$data['del_button']=anchor("wheels/del_wheelset/".$wheelset_info->id, "Delete", array('class'=>'btn btn-danger','onClick'=>"return deleteconfirm();"));
				$this->load->view('wheel_admin/edit_wheelset', $data);
    		}
    		else{
    			$this->session->set_flashdata('message', 'No Wheelset Found');
    			redirect('wheels/all_wheelsets');
    		}
		}
    }
    
    
    	public function add_wheelset(){
		if (!$this->ion_auth->logged_in()){
			redirect('auth/login', 'refresh');
			}else{
				$data['title']='Add new wheelset - '.$this->config->item('site_title', 'ion_auth');
				
				if(!empty($_POST)){	
					
					// redirect them to the home page because they must be an administrator to view this
					$this->form_validation->set_rules('wheel_name', 'Wheel Name', 'required|max_length[255]');
					$this->form_validation->set_rules('weight', 'Weight', 'required|numeric|greater_than[0]');
					$this->form_validation->set_rules('tubular', 'Tubular', '');
					$this->form_validation->set_rules('deg0', 'CdA at 0 deg', 'required|numeric');
					$this->form_validation->set_rules('deg5', 'CdA at 5 deg', 'required|numeric');
					$this->form_validation->set_rules('deg10', 'CdA at 10 deg', 'required|numeric');
					$this->form_validation->set_rules('deg15', 'CdA at 15 deg', 'required|numeric');
					$this->form_validation->set_rules('deg20', 'CdA at 20 deg', 'required|numeric');
					
					if ($this->form_validation->run()==FALSE){
						//not valid
						//These temporary info are used to re-populate fields
						$data['wheel_name'] = $this->input->post('wheel_name');
						$data['weight']= $this->input->post('weight');
						$data['tubular']= $this->input->post('tubular');
						$data['deg0']= $this->input->post('deg0');
						$data['deg5']= $this->input->post('deg5');
						$data['deg10']= $this->input->post('deg10');
						$data['deg15']= $this->input->post('deg15');
						$data['deg20']= $this->input->post('deg20');
						
						
							
						$this->load->view('wheel_admin/add_wheels', $data);
					}else{//form validation works
						$wheel_info = new Wheelset;
						$wheel_drag = new Wheelset_drag;
						
						$wheel_info->wheel_name = $this->input->post('wheel_name');
						$wheel_info->weight = $this->input->post('weight');
						$wheel_info->tubular = $this->input->post('tubular')==NULL ? 0 : 1;
						$wheel_info->save();
						
						$wheel_drag->wheelset_id = $wheel_info->id;
						$wheel_drag->deg0 = $this->input->post('deg0');
						$wheel_drag->deg5 = $this->input->post('deg5');
						$wheel_drag->deg10 = $this->input->post('deg10');
						$wheel_drag->deg15 = $this->input->post('deg15');
						$wheel_drag->deg20 = $this->input->post('deg20');
						$wheel_drag->save();
						
						$this->session->set_flashdata('message', '1 New Wheelset Added!');
						redirect('wheels/all_wheelsets');
					}
				}
				$this->load->view('wheel_admin/add_wheels', $data);
		}
	}
	
	
	public function del_wheelset($id=NULL){
    	if($id==NULL){
    		redirect('wheels/all_wheels');
		}else{
			$wheel = Wheelset::find_by_id($id);
			$drag_data = Wheelset_drag::find_by('wheelset_id', $id);
			
			if($wheel && $drag_data){
				$drag_data->delete();
				$wheel->delete();
				redirect('wheels/all_wheelsets');
			}else{
				$this->session->set_flashdata('Sorry, could not find comment');
				redirect('wheels/all_wheelsets');
				
			}
    	}
    }
	
    
     public function test(){

     }


	
	 
	
	 	

  }
  