<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Videos extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->load->model('Video_model');
			}
			$this->load->model('Setting_model');
			$this->title =  $this->Video_model->fetchTitle();
			$base_video_path =  base_url('uploads/videos/');

		}else{
			redirect('member');
		}
	}
	
	public function list_title()
	{
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head', $data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('video/title/list');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}
	public function list_video()
	{
		$this->load->model('Setting_model');
        $data['videos'] = $this->Video_model->fetchVideo();
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('video/clip/list');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}
	
	public function addTitle()
	{
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('video/title/add');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}


	public function createTitle()
	{
		if($this->Video_model->createTitle($this->input->post())){
            $this->session->set_flashdata('err_message', 'Title Created');
            $this->session->set_flashdata('status', 1);
        }else{
            $this->session->set_flashdata('err_message', 'Fails : Something went wrong !');
            $this->session->set_flashdata('status', 1);
        }
		redirect('videos/addTitle');
	}



	public function updateStatus(){
		$data = $this->input->post('data');
		$title_id = $data['id'];
		$dataUpdate = array(
			'status' => $data['status']
		);
		$result = array();
		if($this->Video_model->update_status_title($title_id,$dataUpdate)){
			$result['message'] = "Success.";
			$result['status'] = '1';
        }else{ 
			$result['message'] = "Fail : ". $this->Video_model->update_status_title($title_id,$dataUpdate);
			$result['status'] = '0';
		}
		echo json_encode($result);

    }

	
	public function deleteTitle(){

		$data = $this->input->post('data');
		$title_id = $data['id'];
		$dataDelete = array(
			'id' => $title_id
		);
		$result = array();
		if($this->Video_model->deleteTitle($title_id)){
			$result['message'] = 'Deleted title id : ' . $title_id;
			$result['status'] = '1';
		}else{
			$result['message'] = $this->Video_model->deleteTitle($title_id);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}

	public function deleteMultipleTitle(){
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

	public function play($video_id = '1') {
        // Get the video URL from the database based on the $video_id

        // Pass the video URL to the view
        $data['video_url'] = $base_video_path . $video_id . '/' .'video.mp4'; // Replace with your video URL
        
        // Load the view
        $this->load->view('video/video_player', $data);
    }

}