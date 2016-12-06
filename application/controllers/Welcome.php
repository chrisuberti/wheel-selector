<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 function __construct(){
	 	parent::__construct();
	 	$this->load->model('post');
  }
  
  public function index(){
  	$this->load->view('dressings/header');
  	$this->load->view('dressings/navbar');
  	$this->load->view('index_view');
  	$this->load->view('dressings/footer');
  }
	public function test(){
		
		echo form_open('Welcome/add');
		echo form_input('title', 'Post Title');
		echo form_input(array('name'=>'content','id'=>'content','type'=>'textarea'));
		echo form_submit('submti','Submit this Shit');
		echo form_close();
		echo "<pre>";
		
		print_r(Post::find_by('title','Post Title'));
		echo "</pre>";
		
		echo "<hr>";
		$posts = $this->post->find_all();
		foreach($posts as $post){
			echo "<h3>".$post->title ."</h3>: " . $post->id ."<br>";
			echo "<p>".$post->content ."</p><br>";
			echo form_open("Welcome/delete/{$post->id}");
			echo form_submit('submit', 'Delete');
			echo form_close();
		}
		
		
	}
	
	public function add(){
		$post = new Post;
		$post->title = $this->input->post('title');
		$post->content = $this->input->post('content');
		$post->save();
		redirect('welcome');
	}
	public function delete(){
		$id = $this->uri->segment(3);
		$post = Post::find_by_id($id);
		$post->delete();
		redirect('welcome');
	}
}
