<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sound_model extends CI_Model{



    public function get_sound_by_id($id){
    return $this->db->where('sound_id',$id)->get('sound')->result()[0];
    } 

    public function get_sound_categories(){
        return $this->db->get('sound_category')->result();
    }
    public function get_sound_name($id){
        return $this->db->select('sound_title')->where('sound_id',$id)->get('sound')->row_array();
    }

    public function get_category_name($cat_id){
     return $this->db->select('sound_category_name')->from('sound_category')->where('sound_category_id', $cat_id)->get()->row_array();  
    }
}