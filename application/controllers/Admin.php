<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct(){
		parent::__construct();
		if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
				$this->load->model('Video_model');
				$this->load->model('Setting_model');
				$this->title =  $this->Video_model->fetchTitle();
				$base_video_path =  base_url('uploads/videos/');
			}else{
				redirect('dashboard');
			}
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
        $data['options'] = $this->Setting_model->get_options();
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
		$path_directory = "uploads/videos/".$title_id;
		$videos_in_dir = $this->Video_model->getVideosInDir($title_id);
		$result = array();
		$empStatus = true;
		foreach ($videos_in_dir as $key => $value) {
			if(!$this->deleteVideoBeforeDir($value->id,$value->title_id,$value->filename)){
				$result['status'] = '0';
				$result['message'] = 'Cannot delete file name '.$value->filename;
				$empStatus = false;
				break;
			}
		}

		if($empStatus && is_dir($path_directory)){
			if(!$this->delete_directory($path_directory)){
				$result['message'] = 'Cannot delete directory id '.$path_directory ;
				$result['status'] = '0';
				$empStatus = false;
			}
		}
		
		if($empStatus){
			if($this->Video_model->deleteTitle($title_id)){
				$result['message'] = 'Deleted title id : ' . $title_id;
				$result['status'] = '1';
			}else{
				$result['message'] = $this->Video_model->deleteTitle($title_id);
				$result['status'] = '0';
			}
		}

		echo json_encode($result);
	}

	public function deleteVideoBeforeDir($video_id,$title_id,$filename){
		$videoPath = 'uploads/videos/'.$title_id.'/'.$filename;
		$result = array();
		if($this->Video_model->deleteVideo($video_id)){
			if(unlink($videoPath)){
				return 1;
			}else{
				return 0;
			}
		}else{
			return 0;
		}
	}

	private function delete_directory($directory_path)
    {
        $files = array_diff(scandir($directory_path), array('.', '..'));

        foreach ($files as $file) {
            (is_dir("$directory_path/$file")) ? $this->delete_directory("$directory_path/$file") : unlink("$directory_path/$file");
        }

        return rmdir($directory_path);
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

	public function addMultiple(){
		$dataSelected = $this->input->post('data');
		$table = $this->input->post('table');
		$result = array();
		if($this->Video_model->addMultiple($dataSelected,$table)){
			$result['message'] = "Account selected has been deleted.";
			$result['status'] = '1';

		}else{
			$result['message'] = $this->Video_model->deleteMultiple($dataSelected,$table);
			$result['status'] = '0';
		}
		echo json_encode($result);
	}
	
	public function title_manage_details($title_id = null)
	{
        $data['options'] = $this->Setting_model->get_options();
		$data['titles'] = $this->title;
		$data['title'] = $this->Video_model->fetchTitleById($title_id);
		$data['videos'] = $this->Video_model->fetchVideoByTitle($title_id);
		$data['users_active'] = $this->Video_model->fetchUsersPermissionByTitle($title_id);
		$data['users_inactive'] = $this->Video_model->fetchUsersNonePermissionByTitle($title_id);
		$this->load->model('User_model');
		$data['users'] = $this->User_model->fetchAll();
		$this->load->view('myCss');
		$this->load->view('myJs');
		$this->load->view('_partials/head', $data);
		$this->load->view('_partials/navbar');
		$this->load->view('_partials/sidebar_main');
		$this->load->view('admin/video/title/details');
		$this->load->view('_partials/sidebar_control');
		$this->load->view('_partials/footer');
	}
}