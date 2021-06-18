<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller{


    function __construct(){

        parent::__construct();
        $this->load->database();
        // $this->load->model('Common');
        // $this->load->model('Sound_model');
    }

    public function manage_change(){
        $type = $this->input->post('for');
        $value = $this->input->post('value');
        $data = array(
            'settings_id'=>$type,
            'settings_value'=>$value
        );
        switch($type){
            case 'video_reward_limit':
                echo $this->db->where('settings_id',$type)->update('settings',$data);
                break;
            default:
                echo false;
                break;
        }
    }

    public function index()
    {
        $d = array();
        $d['settings'] = $this->db->get('settings')->result_array();

    	$this->load->view('admin/include/header');
        
        $this->load->view('admin/settings/list',$d);
        
    	$this->load->view('admin/include/footer');
    }
}