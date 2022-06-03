<?php
class C extends CI_Controller{
    public function __construct()
    {
        parent::__construct(); 
        $this->load->model('m');  
        $this->load->helper('url');
        $this->load->library('session');
    }
    public function f($url_part)
    {
        $long_url = $this->m->get_long_url($url_part);
        if($long_url){
            if(!$this->session->userdata('user_id')){
                
                $check_count = $this->m->store_count_for_url($url_part);
                if(!$check_count){
                    die('DataBase error for storing count!!!');
                }
            }else{
                $url_user_id = $this->m->get_user_id($url_part);
                if($url_user_id != ($this->session->userdata('user_id'))){
                    $check_count = $this->m->store_count_for_url($url_part);
                    if(!$check_count){
                        die('DataBase error for storing count!!!');
                    }
                }
            }
            redirect($long_url);
            
        }else{
            die('Shorten URL is not working!!!');
        }
        
    }
}
?>