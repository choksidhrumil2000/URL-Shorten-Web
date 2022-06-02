<?php
class Dashboard_model extends CI_Model{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();   
    }
    public function getdata($userid)
    {
        $this->db->select('firstname,lastname');
        $arr = array('id'=>$userid);
        $this->db->where($arr);
        $data=$this->db->get('users');
        $row_data = $data->row();
        $fname = $row_data->firstname;
        $lname = $row_data->lastname;
        $response = array('firstname'=>$fname,'lastname'=>$lname);
        return $response;
    }
    public function create_url_part()
    {
        $this->load->helper('string');
        $is_unique = false;
        $url_part = "";
        do{
            $url_part = random_string('alnum',6);
            $is_unique = $this->check_unique_url_part($url_part);
        }while(! $is_unique);

        return $url_part;
    }
    public function check_unique_url_part($url_part)
    {
        $this->db->select('id');
        $arr = array('url_part'=>$url_part);
        $this->db->where($arr);
        $check_url_part = $this->db->get('urls');
        if($check_url_part->num_rows > 0){
            return false;
        }else{
            return true;
        }
    }
    public function make_url_short_and_insert($id,$long_url)
    {
        $this->load->helper('url');
        $url_part = $this->create_url_part();
        $short_url = base_url().'c/f/'.$url_part;
        // $short_url = 'https://dc.ly/i/'.$url_part;
        $created_date_time = date('Y-m-d H:i:s');
        $arr = array(
            'url'=>$long_url,
            'shorten_url'=>$short_url,
            'url_part'=>$url_part,
            'user_id'=>$id,
            'created_date_time'=>$created_date_time
        );
        $check = $this->db->insert('urls',$arr);
        // if($check_insert == true){
        //     $this->db->select('id');
        // $arr2 = array(
        //     'shorten_url'=>$short_url
        // );
        // $this->db->where($arr2);
        // $check = $this->db->get('urls');
        // if($check->num_rows > 0){
        //     $url_id = $check->row()->id;
        //     $arr2 = array(
        //         'id'=>$url_id,
        //         'check'=>$check,
        //         'check_insert'=>$check_insert,
        //         'short_url'=>$short_url,
        //         'long_url'=>$long_url,
        //         'created_date_time'=>$created_date_time
        //     );
        // }
        // }else{
            $arr2 = array(
                'check'=>$check,
                'short_url'=>$short_url,
                'long_url'=>$long_url,
                'created_date_time'=>$created_date_time
            );
        // }
        // }
        
        return $arr2;
    }
    public function geturls($user_id)
    {
        $this->db->select('id,url,shorten_url,created_date_time');
        $this->db->where(array('user_id'=>$user_id));
        $data = $this->db->get('urls');
        if($data->num_rows > 0){
            $urls['urls_array'] = $data->result_array();
            return $urls;
        }else{
            return array('check'=>false);
        }

    }
    // public function store_url_with_count($url_id)
    // {
    //     $time_at_click = date('Y-m-d H:i:s');
    //     $arr = array(
    //         'url_id'=>$url_id,
    //         'click_cout'=>1,
    //         'time_at_click'=>$time_at_click
    //     );
    //     $check = $this->db->insert('url_analytics',$arr);
    //     if($check == true){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
    // public function store_url_with_count_using_short_url($short_url){
    //     $this->db->select('id');
    //     $arr2 = array(
    //         'shorten_url'=>$short_url
    //     );
    //     $this->db->where($arr2);
    //     $check = $this->db->get('urls');
    //     if($check->num_rows > 0){
    //         $url_id = $check->row()->id;
    //     }else{
    //         return false;
    //     }
    //     $time_at_click = date('Y-m-d H:i:s');
    //     $arr = array(
    //         'url_id'=>$url_id,
    //         'click_cout'=>1,
    //         'time_at_click'=>$time_at_click
    //     );
    //     $check = $this->db->insert('url_analytics',$arr);
    //     if($check == true){
    //         return true;
    //     }else{
    //         return false;
    //     }
    // }
}
?>