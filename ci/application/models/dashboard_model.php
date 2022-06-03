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
        $this->db->select('id,url,shorten_url,created_date_time,url_part');
        $this->db->where(array('user_id'=>$user_id));
        $data = $this->db->get('urls');
        if($data->num_rows > 0){
            $urls['urls_array'] = $data->result_array();
            $array_for_counts = array();
            foreach($data->result_array() as $row){
                $this->db->select('*');
                $arr = array(
                    'url_id'=>$row['id']
                );
                $this->db->where($arr);
                $this->db->from('url_analytics');
                $count = $this->db->count_all_results();
                array_push($array_for_counts,$count);
            }
            $urls['count_of_urls'] = $array_for_counts;
            $urls['check'] = true;
            return $urls;
        }else{
            // return array('check'=>false);
            $urls['check'] = false;
            return $urls;
        }

    }
    public function geturldata_with_count($url_part)
    {
        $this->db->select('id,url,shorten_url,url_part');
        $arr = array(
            'url_part'=>$url_part
        );
        $this->db->where($arr);
        $data = $this->db->get('urls');
        if($data->num_rows >0){
            $this->db->select('*');
            $arr2 = array(
                'url_id'=>$data->row()->id
            ); 
            $this->db->where($arr2);
            $this->db->from('url_analytics');
            $count = $this->db->count_all_results();
            $url_data['check'] = true;
            $url_data['long_url'] = $data->row()->url;
            $url_data['short_url'] = $data->row()->shorten_url;
            $url_data['click_count'] = $count;
            $url_data['url_part'] = $data->row()->url_part;
        }else{
            $url_data['check'] = false;
        }
        return $url_data;
    }
    public function get_graph_data_array($graph_time,$url_part){
        $this->db->select('id');
        $this->db->where(array('url_part'=>$url_part));
        $id_data = $this->db->get('urls');
        if($id_data->num_rows > 0){
            $url_id = $id_data->row()->id;
        }
        $graph_data = [];
        $graph_data[] = array('Date','Click_count');
        if($graph_time == 'last_week'){
            for($i=-6;$i<=0;$i+=1){
                $date = date('Y-m-d',strtotime($i." days"));
                $this->db->select('*');
                $this->db->where(array('url_id'=>$url_id,'DATE(time_at_click)'=>$date));
                $this->db->from('url_analytics');
                $count = $this->db->count_all_results();
                $arr = array($date,$count);
                $graph_data[] = $arr;
            }
        }else if($graph_time == 'last_month'){
            for($i=-30;$i<=0;$i+=1){
                $date = date('Y-m-d',strtotime($i." days"));
                $this->db->select('*');
                $this->db->where(array('url_id'=>$url_id,'DATE(time_at_click)'=>$date));
                $this->db->from('url_analytics');
                $count = $this->db->count_all_results();
                $arr = array($date,$count);
                $graph_data[] = $arr;
            }
        }else{
            for($i=-60;$i<=0;$i+=1){
                $date = date('Y-m-d',strtotime($i." days"));
                $this->db->select('*');
                $this->db->where(array('url_id'=>$url_id,'DATE(time_at_click)'=>$date));
                $this->db->from('url_analytics');
                $count = $this->db->count_all_results();
                $arr = array($date,$count);
                $graph_data[] = $arr;
            }
        }
        $total_data['graph_data_array'] = $graph_data;
        return $total_data;
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