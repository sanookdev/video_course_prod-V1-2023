<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Videos extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			$this->load->model('Video_model');
			$this->load->model('Setting_model');
			$this->title =  $this->get_titles_video();
			$base_video_path =  base_url('uploads/videos/');
		}else{
			redirect('member');
		}
	}

	public function get_titles_video(){
		if($this->session->userdata['user_role'] == '1'){
			return $this->Video_model->fetchTitle();
		}else{
			return $this->Video_model->fetchTitleByUserId($this->session->userdata['id']);
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
		if($this->session->userdata['user_role'] == '1'){
			$contents = $this->Video_model->fetchVideoByTitle($title_id);
		}else{
			$contents = $this->Video_model->fetchVideoByTitleUnpublic($title_id);
		}
		$data['contents'] = $contents ;
		$data['title'] = $this->Video_model->fetchTitleById($title_id);
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
	
		if(count($data['title']) > 0){
			$this->load->view('myCss');
			$this->load->view('myJs');
			$this->load->view('_partials/head',$data);
			$this->load->view('_partials/navbar');
			$this->load->view('_partials/sidebar_main');
			$this->load->view('video/clip/list');
			$this->load->view('_partials/sidebar_control');
			$this->load->view('_partials/footer');
		}else{
			show_error('This title not found.',403);
		}
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

	public function play($video_id = null) {
		$video_details = $this->Video_model->fetchVideoById($video_id);
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
        $data['video_url'] = base_url('uploads/videos/').$video_details[0]->title_id.'/'.$video_details[0]->filename; 
		$data['video_details'] = $video_details;
		$data['title'] = $this->Video_model->fetchTitleById($video_details[0]->title_id);
		if($this->session->userdata['user_role'] == '1'){
			$contents = $this->Video_model->fetchVideoByTitle($data['title'][0]->id);
		}else{
			$contents = $this->Video_model->fetchVideoByTitleUnpublic($data['title'][0]->id);
		}
		$data['contents'] = $contents ;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
        $this->load->view('video/clip/play');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
    }
}