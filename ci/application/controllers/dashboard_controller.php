<?php
class Dashboard_controller extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('dashboard_model','dm');
    }
    public function dashboard()
    {
        $this->load->view('dashboard');
    }
    public function getuserdata($userid)
    {
        $data = $this->dm->getdata($userid);
        $object_data = (object)$data;
        echo json_encode($object_data);
    }
    public function shorten_url($id)
    {
        $request= json_decode(file_get_contents('php://input'), TRUE);
        // var_dump($request);
        if(empty($request)){
            $data = array(
                'check'=>false,
                'long_url'=>null
            );
        }else{
            $data = $this->dm->make_url_short_and_insert($id,$request['url']);
        }
        $arr = (object)$data;
        echo json_encode($arr);
    }
    public function geturlsdata($userid)
    {
        $data = $this->dm->geturls($userid);
        echo json_encode($data);
    }
    // public function store_url_analytics($url_id){
    //     $data = $this->dm->store_url_with_count($url_id);
    //     echo json_encode((object)array('check'=>$data));
    // }
    // public function store_url_analytics_with_short_url($short_url)
    // {
    //     $data = $this->dm->store_url_with_count_using_short_url($short_url);
    //     echo json_encode((object)array('check'=>$data));
    // }
}
?>