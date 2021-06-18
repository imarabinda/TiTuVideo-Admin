<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rewarding_model extends CI_Model{


    public function update($id,$data){
        return $this->db->where('rewarding_action_id',$id)->update('rewarding_action',$data);
    }
}