<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Verification_model extends CI_Model {

    private $table_name = 'verification_request';
    function __construct(){
        parent::__construct();
    }
    public function get_user_id($id){
        $this->db->select('user_id');
        $this->db->where('id',$id);
        return $this->db->get($this->table_name)->row_array();
    }

}