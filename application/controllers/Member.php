<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Member extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model('Member_model');
	}
	public function index()
	{
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				redirect('dashboard');
			}
		}else{
			$this->signin();
		}
	}

	public function signin(){
		$this->load->model('Setting_model');
		$data['options'] = $this->Setting_model->get_options();
		$this->load->view('loginCss');
		$this->load->view('myJs');
		$this->load->view('bgAnimation');
		$this->load->view('auth/login',$data);
	}
	
	public function check()
	{
			if($this->input->post('email') == '' || $this->input->post('password') == ''){
				$this->load->view('auth/login');
			}else{
				$email = strtoupper($this->input->post('email'));
				$password = $this->input->post('password');
				$password = MD5($password);
				$user = $this->Member_model->fetch_user_login($email,$password);
				if(count($user) > 0){
					$this->session->set_flashdata('err_message', 'Log In Success.');
					$sess = array(
						'id' => $user->id,
						'created' => $user->created,
						'username' => $user->username,
						'fullname' => $user->fname . ' ' . $user->lname,
						'fname' => $user->fname,
						'lname' => $user->lname,
						'username' => $user->username,
						'phone' => $user->phone,
						'user_role' => $user->user_role
					);
					$this->session->set_userdata($sess);
				}else{
					$this->load->library('session');
					$this->session->set_flashdata('err_message', 'Email or Password is invalid');
					$this->session->unset_userdata(array('email','userRole'));
				}
				redirect('member');
			}
	
	}

	public function logout(){
		$this->session->sess_destroy();
		// print_r($this->session);
		redirect('member');
	}
}