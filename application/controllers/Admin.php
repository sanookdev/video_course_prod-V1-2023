<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
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
		$this->load->view('admin/video/title/list');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}
	public function list_video()
	{
        $data['videos'] = $this->Video_model->fetchVideoWithTitle();
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('admin/video/clip/list_manage');
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
		$this->load->view('admin/video/title/add');
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
		redirect('videos/addtitle');
	}

	public function addVideo()
	{
		$data['videos'] = $this->Video_model->fetchVideoWithTitle();
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head',$data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('admin/video/clip/add');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}

	public function upl_video() {
		$namefile = uniqid();
		$title_id = $this->input->post('title_id');
		$videoName = $this->input->post('name');
		$updated = $this->input->post('updated');
		$upload_path = './uploads/videos/'.$title_id .'/';
		$directory = './uploads/videos/';
		if (!is_dir($upload_path)) {
			mkdir($upload_path, 0777, true);
		}

		$config['upload_path'] = $upload_path;
		$config['allowed_types'] = 'mp4|mov|avi';
		$config['max_size'] = 542000; // 500MB
        $this->load->library('upload',$config);		

		if (!$this->upload->do_upload('video')) {
			$error = $this->upload->display_errors();
			$response = array(
				'message' => 'failed : '.$this->upload->display_errors(),
				'status' => 0
			);
		  } else {
			$data = $this->upload->data();
			$file_path = $data['full_path'];
			// Get the file extension
			$file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
			// New file name with the random name and original extension
			$new_file_name = $namefile . '.' . $file_extension;
			// Rename the uploaded file with the new file name
			$new_file_path = $data['file_path'] . $new_file_name;
			rename($file_path, $new_file_path);

			$dataUp = array(
				'title_id' =>$title_id,
				'name' => $videoName,
				'last_updated' => $updated." ".date('h:i:s'),
				'filename' => $namefile.$data['file_ext']
 			);

			if($this->Video_model->uploadVideoDetails($dataUp)){
				$response = array(
					'message' => 'This video has been uploaded.',
					'namefile' => $videoName,
					'status' => 1
				);
			}else{
				$response = array(
					'message' => 'Cannot upload video details to Database :' .
					 $this->Video_model->uploadVideoDetails($dataUp),
					'namefile' => $videoName,
					'status' => 0
				);
			}

			// Process the renamed file, e.g., save the file path to the database
			// ...
	   
			// Redirect or display success message
		  }
        header('Content-Type: application/json');
        echo json_encode($response);            
    }  

    public function get_options(){
		$this->load->model('Setting_model');
		return $this->Setting_model->get_options();
	}

	public function updateStatus(){
		$data = $this->input->post('data');
		$id = $data['id'];
		$table = $data['table'];
		$dataUpdate = array(
			'status' => $data['status']
		);
		$result = array();
		if($this->Video_model->update_status_title($id,$dataUpdate,$table)){
			$result['message'] = "Success.";
			$result['status'] = '1';
        }else{ 
			$result['message'] = "Fail : ". $this->Video_model->update_status_title($id,$dataUpdate,$table);
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
	public function deleteVideo(){

		$data = $this->input->post('data');
		$video_id = $data['id'];
		$title_id = $data['title_id'];
		$filename = $data['filename'];
		$videoPath = 'uploads/videos/'.$title_id.'/'.$filename;
		$dataDelete = array(
			'id' => $video_id
		);
		$result = array();
		if($this->Video_model->deleteVideo($video_id)){
			if(unlink($videoPath)){
				$result['message'] = 'Deleted video id : ' . $video_id;
				$result['status'] = '1';
			}else{
				$result['message'] = 'Cannot unlink video file on server !';
				$result['status'] = '0';
			}
			
		}else{
			$result['message'] = $this->Video_model->deleteVideo($video_id);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}
	public function deleteMultiple(){
		$dataSelected = $this->input->post('data');
		$table = $this->input->post('table');
		$result = array();
		if($this->Video_model->deleteMultiple($dataSelected,$table)){
			$result['message'] = "Account selected has been deleted.";
			$result['status'] = '1';

		}else{
			$result['message'] = $this->Video_model->deleteMultiple($dataSelected,$table);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}

	public function subject($title_id = '1') {

		$contents = $this->Video_model->fetchVideoByTitle($title_id);
		$data['contents'] = $contents ;
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
		// $this->load->view('_partials/footer');

		// echo "<pre>";
		// print_r($contents);
		// echo "</pre>";
        // Get the video URL from the database based on the $video_id

        // Pass the video URL to the view
        // $data['video_url'] = $base_video_path . $video_id . '/' .'video.mp4'; // Replace with your video URL
        
        // Load the view
        // $this->load->view('video/video_player', $data);
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