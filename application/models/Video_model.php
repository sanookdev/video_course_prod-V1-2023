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
        $query = $this->db->get();
        return $query->result();
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
    public function deleteTitle($title_id){
        $this->db->where('id',$title_id);
        if($this->db->delete('tb_title')){
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
        $this->db->where_in('id',$dataSelected);
        if($this->db->delete($table)){
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
}
?>