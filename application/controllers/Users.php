<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->load->model('User_model');
				$this->load->model('Video_model');
				$this->load->model('Setting_model');
				$this->title =  $this->Video_model->fetchTitle();
				$this->options = $this->Setting_model->get_options();
			}else{
				redirect('dashboard');
			}
			
		}else{
			redirect('member');
		}
	}
	public function report($response = null)
	{
        $data['users'] = $this->User_model->fetchAll();
        $data['options'] = $this->options;
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head' , $data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('user/report');
		$this->load->view('modal_event/reset_pass');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}
	public function add()
	{
		$data['options'] = $this->options;
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head', $data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main' );
		$this->load->view('user/add');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}

	public function uploadPage()
	{
		$data['options'] = $this->options;
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head', $data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main' );
		$this->load->view('user/import');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}

	public function create()
	{
		$username = $this->input->post('username');

		$res = array(
			'message' => '',
			'status' => 0
		);
		if($this->User_model->checkDuplicate($username)){
			$res['message'] = 'This email has already exit. !';
			$res['status'] = 0;
		}else{
			if($this->User_model->create($this->input->post())){
				$this->session->set_flashdata('err_message', 'This email has been created.');
				$this->session->set_flashdata('status', 1);
			}else{
				$this->session->set_flashdata('err_message', 'Something went wrong. !');
				$this->session->set_flashdata('status', 1);
			}
		}
		$this->add();
	}

	public function updateStatus(){
		$data = $this->input->post('data');
		$username = $data['username'];
		$dataUpdate = array(
			$data['column'] => $data[$data['column']]
		);
		unset($data['column']);

		$result = array();
		if($this->User_model->updateStatus($username,$dataUpdate)){
			$result['message'] = "Success.";
			$result['status'] = '1';
        }else{
			$result['message'] = "Fail : ". $this->User_model->updateStatus($username,$dataUpdate);
			$result['status'] = '0';
		}
		echo json_encode($result);

    }

	public function updatePassword(){
		$data = $this->input->post('data');
		$username = $data['username'];
		$dataUpdate = array(
			'password' => md5(md5($data['password']))
		);
		if($this->User_model->updatePassword($username,$dataUpdate)){
			$result['message'] = "Password updated.";
			$result['status'] = '1';
        }else{
			$result['message'] = "Fail : ". $this->User_model->updateStatus($username,$dataUpdate);
			$result['status'] = '0';
		}
		echo json_encode($result);
    }
	
	public function deleteUser(){

		$data = $this->input->post('data');
		$username = $data['username'];
		$dataDelete = array(
			'username' => $data['username']
		);
		$result = array();
		if($this->User_model->deleteUser($username)){
			$result['message'] = 'Deleted accout ' . $username;
			$result['status'] = '1';

		}else{
			$result['message'] = $this->User_model->deleteUser($username);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}

	public function deleteMultipleUser(){
		$dataSelected = $this->input->post('data');
		$result = array();
		if($this->User_model->deleteMultipleUser($dataSelected)){
			$result['message'] = "Account selected has been deleted.";
			$result['status'] = '1';

		}else{
			$result['message'] = $this->User_model->deleteMultipleUser($dataSelected);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}
}