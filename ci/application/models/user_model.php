<?php
class User_model extends CI_Model{
    public function __construct()
    {   
        parent::__construct();
        $this->load->database();
        $this->load->library('encrypt');
    }
    public function insert_user($request)
    {
        $password = $this->encrypt->encode($request['password']);
        $data = array(
            'firstname'=>$request['firstname'],
            'lastname'=>$request['lastname'],
            'email'=>$request['email'],
            'password'=>$password
        );
        $check = $this->db->insert('users',$data);
        if($check){
            return true;
        }else{
            return false;
        }
    }
    public function get_user_id($email)
    {
        $this->load->database();
		$this->db->select('id');
		$arr = array('email'=>$email);
		$this->db->where($arr);
		$data = $this->db->get('users');
		if($data->num_rows >0){
			return $data->row()->id;
		}else{
			return 0;
		}
    }
    public function check_user_exist($request)
    {
        $this->db->select('email');
        $arr = array('email'=>$request['email']);
        $this->db->where($arr);
        $data = $this->db->get('users');
        if($data->num_rows >0){
            $this->db->select('password');
            $arr2 = array('email'=>$request['email']);
            $this->db->where($arr2);
            $pass_data = $this->db->get('users');
            if($pass_data->num_rows > 0){
                $pass = $this->encrypt->decode($pass_data->row()->password);
                if($pass == $request['password']){
                    return array('check'=>true,'error'=>'no errors');
                }else{
                    return array('check'=>false,'error'=>'password is incorrect');
                }
            }
        }else{
            return array('check'=>false,'error'=>'User Not Found!!');
        }
    }
    public function check_email_exist($email)
    {
        $this->db->select('email');
        $arr = array('email'=>$email);
        $this->db->where($arr);
        $data = $this->db->get('users');
        if($data->num_rows > 0){
            return true;
        }else{
            return false;
        }
        
    }
}
?>