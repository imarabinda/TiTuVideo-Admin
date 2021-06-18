<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Report_model extends CI_Model{


    public function get_video_link($vid_id){
        return $this->db->select(array('post_video','user_id'))->from('post')->where('post_id', $vid_id)->get()->row();
    }
    
    public function get_image_link($u_id){
        return $this->db->select('user_profile')->from('users')->where('user_id', $u_id)->get()->row();
    }
}