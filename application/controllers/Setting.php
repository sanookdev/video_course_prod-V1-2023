<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->load->model('Setting_model');
				$this->load->model('Video_model');
				$this->title =  $this->Video_model->fetchTitle();
			}else{
				redirect('member');
			}
		}else{
			redirect('member');
		}
	}
    
    public function index($response = null){

        $data['options'] = $this->get_options();
		$data['titles'] = $this->title;
        $this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('admin/setting');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
    }

	public function upl_img() {

		$nameInput = '';

		foreach ($_FILES as $key => $value) {
			$nameInput = $key;
			break;
			// Get name of input file.
		}

		$config['upload_path'] = './uploads/banner/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['overwrite'] = TRUE; // replace old file.
		$config['file_name'] = $nameInput;

        $this->load->library('upload',$config);		

        if (!$this->upload->do_upload($nameInput)) {
            $response = array(
				'message' => 'failed : '.$this->upload->display_errors(),
				'status' => 0
			);
        } else {
            $data = $this->upload->data();
            $imagename = $data['file_name'];
			$response = array(
				'message' => 'This image has been uploaded.',
				'namefile' => $imagename,
				'status' => 1
			);
        }
        header('Content-Type: application/json');
        echo json_encode($response);            
    }  

    public function get_options(){
		$this->load->model('Setting_model');
		return $this->Setting_model->get_options();
	}


	public function update(){
		$data = $this->input->post();
		if($this->Setting_model->update($data)){
			$this->session->set_flashdata('err_message', 'This setting has been updated.');
			$this->session->set_flashdata('status', 1);
			$this->session->options = $this->get_options();
		}else{
			$this->session->set_flashdata('err_message', $this->Setting_model->update($data));
			$this->session->set_flashdata('status', 1);
		}
		redirect('setting','refresh');
    }
}