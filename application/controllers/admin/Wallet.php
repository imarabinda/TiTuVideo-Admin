<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wallet extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('admin/Login_model','Alogin');
        $this->load->model('Common');
    }
 
    public function index()
    {
        
    }
}