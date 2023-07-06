<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Videos extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			$this->load->model('Video_model');
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
	

	public function subject($title_id = '1') {

		$contents = $this->Video_model->fetchVideoByTitle($title_id);
		$data['contents'] = $contents ;
		$data['title'] = $this->Video_model->fetchTitleById($title_id);
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

		// echo "<pre>";
		// print_r($contents);
		// echo "</pre>";
        // Get the video URL from the database based on the $video_id

        // Pass the video URL to the view
        // $data['video_url'] = $base_video_path . $video_id . '/' .'video.mp4'; // Replace with your video URL
        
        // Load the view
        // $this->load->view('video/video_player', $data);
    }

	public function fetchVideoByTitle(){
		$title_id = $this->input->post('title_id');
		$result = $this->Video_model->fetchVideoByTitle($title_id);
		// echo json_encode($result);
		if(count($result) > 0){
			$result['message'] = "Account selected has been deleted.";
			$result['status'] = '1';

		}else{
			$result['message'] = 'Data Not Found.'; 
			$result['status'] = '0';
		}
		echo json_encode($result);
	}

	public function play($video_id = '1') {

		echo $video_id;
        // Get the video URL from the database based on the $video_id

        // Pass the video URL to the view
        // $data['video_url'] = $base_video_path . $video_id . '/' .'video.mp4'; // Replace with your video URL
        
        // Load the view
        // $this->load->view('video/video_player', $data);
    }

}