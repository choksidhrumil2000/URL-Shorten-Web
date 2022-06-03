<?php
class M extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();   
    }
    public function get_long_url($url_part)
    {
        $this->db->select('url');
        $arr = array(
            'url_part'=>$url_part
        );
        $this->db->where($arr);
        $data = $this->db->get('urls');
        if($data->num_rows > 0){
            $long_url = $data->row()->url;
            return $long_url;
        }else{
            return false;
        }
    }
    public function store_count_for_url($url_part)
    {
        $this->db->select('id');
        $arr = array(
            'url_part'=>$url_part
        );
        $this->db->where($arr);
        $data = $this->db->get('urls');
        if($data->num_rows > 0){
            $url_id = $data->row()->id;
        }else{
            return false;
        }
        $arr2 = array(
            'url_id'=>$url_id,
            'click_cout'=>1,
            'time_at_click'=>date('Y-m-d H:i:s')
        );
        $check = $this->db->insert('url_analytics',$arr2);
        if($check == true){
            return true;
        }else{
            return false;
        }
    }
    public function get_user_id($url_part)
    {
        $this->load->library('session');
        $this->db->select('user_id');
        $this->db->where(array('url_part'=>$url_part));
        $data = $this->db->get('urls');
        if($data->num_rows > 0){
            $user_id = $data->row()->user_id;
        }else{
            $user_id = $this->session->userdata('user_id');
        }
        return $user_id;
    }
}
?>