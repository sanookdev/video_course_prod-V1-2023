<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Main extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->get_options();
			}
		}else{
			redirect('member');
		}
	}
	public function dashboard()
	{
		$data['countUsers'] = $this->countUsers();
		$data['countVideos'] = $this->countVideos();
		$options = $this->get_options();
		$data['options'] = $options;
		$data['titles'] = $this->get_titles_video();
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('dashboard');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}

	public function get_titles_video(){
		$this->load->model('Video_model');
		return $this->Video_model->fetchTitle();
	}

	public function get_options(){
		$this->load->model('Setting_model');
		$options = $this->Setting_model->get_options();
		$this->session->options = $options;
		return $options;
	}
	
	public function countUsers(){
		$this->load->model('User_model');
		$rows = $this->User_model->countUsers();
		return $rows;
	}
	public function countVideos(){
		$this->load->model('Video_model');
		$rows = $this->Video_model->count_video();
		return $rows;
	}


}