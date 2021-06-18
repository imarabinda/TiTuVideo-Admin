<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coin_model extends CI_Model{
    function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('email');
    }
    

    public function get_coin_plan_by_id($id){
        return $this->db->where('coin_plan_id',$id)->get('coin_plan')->row_array();
    }

    public function add_coin_plan($data){
        return $this->db->insert('coin_plan',$data);
    }
    public function update_coin_plan($id,$data){
        return $this->db->where('coin_plan_id',$id)->update('coin_plan',$data);
    }

    public function update_coin_rate($id,$data){
        return $this->db->where('coin_rate_id',$id)->update('coin_rate',$data);
    }
    
    public function get_coin_rate()
	{
		$this->db->select('*');
        $this->db->from('coin_rate');
        $query = $this->db->get();
        
        if($query->num_rows()  > 0 ){
            return $query->row();
        }
        return 0;
    }
    


    public function get_total_coin(){
        $this->db->from('users');
        $this->db->select_sum('my_wallet');
        $query = $this->db->get()->row()->my_wallet; 
        return $query;
    }


    public function check_rate_available()
	{
		$this->db->select('*');
        $this->db->from('coin_rate');
        $query = $this->db->get();
        $num_rows = $query->num_rows();
        return $num_rows;
	}
}