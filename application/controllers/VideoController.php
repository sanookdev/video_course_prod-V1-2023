<?php
defined('BASEPATH') or exit('No direct script access allowed');

class VideoController extends CI_Controller {
    public function play($token = "ABCD") {
        // Validate the token and check authorization
        if ($this->_validateToken($token)) {
            // Retrieve the actual video path URL from a secure location
            $videoPath = $this->_getVideoPath();

            // Generate the video URL with token appended
            $protectedURL = base_url('video/protected/') . $token;

            // Pass the video URL to the view
            $data['videoURL'] = $protectedURL;
            $data['videoPath'] = $videoPath;
			$this->load->view('myCss');
			$this->load->view('myJs');
            // Load the view with Video.js player
            $this->load->view('video/clip/_play', $data);
        } else {
            // Handle invalid token or unauthorized access
            show_error('Invalid token or unauthorized access', 403);
        }
    }

    private function _validateToken($key) {
		if($key == $this->config->item('encryption_key')){
			return true;
		}else{
			return false;
		}
        // Implement your token validation logic here
        // Return true if the token is valid and authorized, false otherwise
    }

    private function _getVideoPath() {
		$path = base_url('uploads/videos/31/64abcb0664777.mp4');
		return $path;
        // Retrieve the actual video path URL from a secure location
        // Return the video path URL
    }
}