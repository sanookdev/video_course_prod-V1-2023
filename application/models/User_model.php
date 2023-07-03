<?
class User_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkDuplicate($username){
        $this->db->select('*');
        $this->db->where('username',$username);
        $query = $this->db->get('tb_user',1);
        return $query->row();
    }

    public function fetchAll(){
        $this->db->select('*');
        $this->db->where('username <> "ADMIN"');
        $query = $this->db->get('tb_user');
        return $query->result();
    }
    public function create($data){
        $data['username'] = strtoupper($data['username']);
        $data['password'] = md5($data['password']);
        $data['updated_by'] = $this->session->userdata('username');
        if($this->db->insert('tb_user',$data)){
            return 1;
        }else{
            return 0;
        }
    }
    public function updateStatus($username,$data){
        $data['updated_by'] = $this->session->userdata('username');
        $data['last_updated'] = date('Y-m-d H:i:s');
        $this->db->where('username',$username);
        if($this->db->update('tb_user',$data)){
            return 1;
        }else{
            return 0;
        }
    }

    public function updatePassword($username,$data){
        $this->db->where('username',$username);
        if($this->db->update('tb_user',$data)){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function deleteUser($username){
        $this->db->where('username',$username);
        if($this->db->delete('tb_user')){
            return 1;
        }else{
            return 0;
        }
    }
    public function deleteMultipleUser($dataSelected){
        $this->db->where_in('username',$dataSelected);
        if($this->db->delete('tb_user')){
            return 1;
        }else{
            return 0;
        }
    }

    public function countUsers(){
        $this->db->select('*');
        $this->db->where('username != ', 'ADMIN');
        $query = $this->db->get('tb_user');
        return $query->num_rows();
    }

}
?>