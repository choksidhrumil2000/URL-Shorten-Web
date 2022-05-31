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
}
?>