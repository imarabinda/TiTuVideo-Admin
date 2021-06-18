<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Banner_model extends CI_Model{

    public function get_banner_by_id($id){
    return $this->db->where('banner_id',$id)->get('banners')->result()[0];
    } 

}