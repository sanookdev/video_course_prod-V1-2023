<?
class Video_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkDuplicateTitle($nameTitle,$table){
        $this->db->select('*');
        $this->db->where('name',$nameTitle);
        $query = $this->db->get($table,1);
        return $query->row();
    }

    public function fetchTitle(){
        $this->db->select('*');
        $query = $this->db->get('tb_title');
        return $query->result();
    }

    public function fetchTitleByUserId($user_id){
        $this->db->select('tb_title.*,tb_permission_title.id AS permission_id');
        $this->db->from('tb_title');
        $this->db->join('tb_permission_title', 'tb_title.id = tb_permission_title.title_id ');
        $this->db->where('tb_permission_title.user_id',$user_id);
        $this->db->where('tb_title.status',1);
        $this->db->order_by('last_updated','desc');
        $query = $this->db->get();
        return $query->result();
    }

    
    public function fetchTitleById($title_id){
        $this->db->select('*');
        $this->db->where('id',$title_id);
        $query = $this->db->get('tb_title');
        return $query->result();
    }
    public function fetchVideo(){
        $this->db->select('*');
        $query = $this->db->get('tb_videos');
        return $query->result();
    }

    public function fetchVideoWithTitle(){
        $this->db->select('tb_videos.*,tb_title.name AS title_name');
        $this->db->from('tb_videos');
        $this->db->join('tb_title', 'tb_title.id = tb_videos.title_id');
        $query = $this->db->get();
        return $query->result();

    }
    public function fetchVideoByTitle($title_id){
        $this->db->select('tb_videos.*,tb_title.name AS title_name');
        $this->db->from('tb_videos');
        $this->db->join('tb_title', 'tb_title.id = tb_videos.title_id');
        $this->db->where('title_id',$title_id);
        $this->db->order_by('last_updated','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function fetchVideoByTitleUnpublic($title_id){
        $this->db->select('tb_videos.*,tb_title.name AS title_name');
        $this->db->from('tb_videos');
        $this->db->join('tb_title', 'tb_title.id = tb_videos.title_id');
        $this->db->where('tb_videos.title_id',$title_id);
        $this->db->where('tb_videos.status',1);
        $this->db->where('tb_title.status',1);
        $this->db->order_by('tb_videos.last_updated','desc');
        $query = $this->db->get();
        return $query->result();
    }

    public function fetchUsersPermissionByTitle($title_id){
        $this->db->select('tb_user.*');
        $this->db->from('tb_permission_title');
        $this->db->join('tb_user', 'tb_permission_title.user_id = tb_user.id');
        $this->db->where('tb_permission_title.title_id',$title_id);
        $this->db->where('tb_user.username !=','ADMIN');
        $this->db->order_by('tb_permission_title.created','desc');
        $query = $this->db->get();
        return $query->result();
    }
    public function fetchUsersNonePermissionByTitle($title_id){
        $userActive = $this->fetchUsersPermissionByTitle($title_id);
        $this->db->select('tb_user.*');
        $this->db->from('tb_user');
        $this->db->where('tb_user.username !=','ADMIN');
        $query = $this->db->get();
        $userInactive =  $query->result(); 
        $id_active = array();
        foreach ($userActive as $row) {
            $id_active[] = $row->id;
        }
        $diff = array();
        foreach ($userInactive as $row) {
            if(!in_array($row->id,$id_active)){
                $diff[] = $row;
            }
        }

        return $diff;
    }
    public function getArrayDifference($array1, $array2) {
        // Custom comparison function
        $compareObjects = function($obj1, $obj2) {
            return $obj1->id - $obj2->id;
        };
        
        // Get the difference between the arrays
        $difference = array_udiff($array1, $array2, $compareObjects);
        
        // Convert the difference to a regular array
        $difference = array_values($difference);

        return $difference;
    }

    public function fetchTitleForUser(){
        $this->db->select('*');
        $this->db->where('public',1);
        $query = $this->db->get('tb_title');
        return $query->result();
    }
    public function createTitle($data){
        $data['created_by'] = $this->session->userdata('username');
        $data['status'] = 1;
        if(!$this->checkDuplicateTitle($data['name'],'tb_title')){
            if($this->db->insert('tb_title',$data)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
    public function update_status_title($id,$data, $table){
        $data['updated_by'] = $this->session->userdata('username');
        $data['last_updated'] = date('Y-m-d H:i:s');
        $this->db->where('id',$id);
        if($this->db->update($table,$data)){
            return 1;
        }else{
            return 0;
        }
    }
    public function getVideosInDir($title_id){
        $this->db->select('');
        $this->db->where('title_id',$title_id);
        $query = $this->db->get('tb_videos');
        return $query->result();
    }
    public function deleteTitle($title_id){
        $this->db->trans_start();
		$this->db->delete('tb_videos', ['title_id' => $title_id]);
		$this->db->delete('tb_permission_title', ['title_id' => $title_id]);
		$this->db->delete('tb_title', ['id' => $title_id]);
        if($this->db->trans_commit()){
            return 1;
        }else{
            return 0;
        }
    }
    public function deleteVideo($video_id){
        $this->db->where('id',$video_id);
        if($this->db->delete('tb_videos')){
            return 1;
        }else{
            return 0;
        }
    }

    public function deleteMultiple($dataSelected,$table){
        if($table == 'tb_title'){
            $this->db->trans_start();
            foreach ($dataSelected as $title_id) {
                $this->db->delete('tb_videos', ['title_id' => $title_id]);
                $this->db->delete('tb_permission_title', ['title_id' => $title_id]);
                $this->db->delete('tb_title', ['id' => $title_id]);
            }
        }else if ($table == 'tb_videos'){
            $this->db->trans_start();
            foreach ($dataSelected as $v_id) {
                $this->db->delete('tb_videos', ['id' => $v_id]);
            }
        }else if ($table == 'tb_user'){
            $this->db->trans_start();
            foreach ($dataSelected as $user_id) {
                $this->db->delete('tb_permission_title', ['user_id' => $user_id]);
                $this->db->delete('tb_user', ['id' => $user_id]);
            }
        }else if ($table == 'tb_permission_title'){
            $this->db->trans_start();
            foreach ($dataSelected as $user_id) {
                $this->db->delete('tb_permission_title', ['user_id' => $user_id]);
            }
        }
        

        if($this->db->trans_commit()){
            return 1;
        }else{
            return 0;
        }
    }

    public function addMultiple($dataSelected,$table){
        if($this->db->insert_batch($table, $dataSelected)){
            return 1;
        }else{
            return 0;
        }
    }

    public function count_title(){
        $this->db->select('*');
        $query = $this->db->get('tb_title');
        return $query->num_rows();
    }
    public function count_video(){
        $this->db->select('*');
        $query = $this->db->get('tb_videos');
        return $query->num_rows();
    }

    public function uploadVideoDetails($data){
        $data['created_by'] = $this->session->userdata('username');
        $data['status'] = 1;
        if(!$this->checkDuplicateTitle($data['name'],'tb_title')){
            if($this->db->insert('tb_videos',$data)){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }

    public function fetchVideoById($v_id){
        $this->db->select('tb_videos.*,tb_title.name AS title_name');
        $this->db->from('tb_videos');
        $this->db->join('tb_title', 'tb_title.id = tb_videos.title_id');
        $this->db->where('tb_videos.id',$v_id);
        $query = $this->db->get();
        return $query->result();
    }
}
?>