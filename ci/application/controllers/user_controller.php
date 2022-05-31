<?php
class User_controller extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('user_model','um');
    }
    public function url_shorten_app()
    {
        $this->load->view('login_signup_page');
        
    }
    public function check_user()
    {
        $request= json_decode(file_get_contents('php://input'), TRUE);
        $data = $this->um->check_user_exist($request);
        if($data['check'] == true){
            $user_id = $this->um->get_user_id($request['email']);
            $response = (object)array('check'=>$data['check'],'id'=>$user_id,'error'=>$data['error']);
        }else{
            $response = (object)array('check'=>$data['check'],'error'=>$data['error']);
        }
        echo json_encode($response);
        
    }
    public function add_user()
    {
        $request= json_decode(file_get_contents('php://input'), TRUE);
        $check_email = $this->um->check_email_exist($request['email']);
        $check = false;
        $user_id = 0;
        if($check_email == false){
            $check = $this->um->insert_user($request);
            $user_id = $this->um->get_user_id($request['email']);
            $response = (object)array('check'=>$check,'id'=>$user_id,'check_email'=>$check_email);
        }else{
            $response = (object)array('check'=>$check,'id'=>$user_id,'check_email'=>$check_email);
        }
        echo json_encode($response); 
    }
}
?>