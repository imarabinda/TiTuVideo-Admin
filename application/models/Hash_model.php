<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Hash_model extends CI_Model
{

	private $table_name = "hash_tags";
	function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }


	    public function hash_tag_videos($hash_tag,$length,$start)
    {
    	$this->db->select('*');
		$this->db->from('post');
		$this->db->group_start();
		$this->db->like('post_hash_tag',$hash_tag);
		$this->db->group_end();
		$this->db->order_by('video_likes_count','desc');
		$this->db->limit($length,$start);
		$query = $this->db->get();
		$result = $query->result();
		return $result;
    }

    public function hash_tag_videos_count($hash_tag)
    {
    	$this->db->select('*');
		$this->db->from('post');
		$this->db->group_start();
		$this->db->like('post_hash_tag',$hash_tag);
		$this->db->group_end();
		$query = $this->db->get();
		$result = $query->num_rows();
		return $result;
    }


	public function toggle_explore_hash_tags($id,$v){
		$this->db->where('id',$id);
		return $this->db->update($this->table_name,array('move_explore'=>$v));
	}
	public function move_to_explore($data){
		$this->db->where('id',$data['id']);
		return $this->db->update($this->table_name,$data);

	}
}