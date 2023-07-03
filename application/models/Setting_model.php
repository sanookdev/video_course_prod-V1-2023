<?
class Setting_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->tb = 'tb_options';
    }
    public function get_options(){
        $this->db->select('*');
        $query = $this->db->get($this->tb);
        return $query->row();
    }

    public function update($data){
        if($this->db->update($this->tb,$data)){
            return 1;
        }else{
            return 0;
        }
    }
    public function save_file($data){
        if($this->db->update('tb_options',$data)){
            return 1;
        }else{
            return 0;
        }
    }
}
?>