<?php

class Login_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }
 
    public function jadminlogin($username,$password,$is_mail = false)
    {
        $this->db->select('*');
        $this->db->from('tbl_admin');
        if($is_mail){
            $this->db->where('admin_email',$username);
        }else{
            $this->db->where('admin_name',$username);
        }

        $this->db->where('admin_password',$password);
        $query = $this->db->get();
        $row_count = $query->num_rows();
        $row_array = $query->row_array();

        if($row_count > 0)
        {
            $this->session->set_userdata('is_admin_login',true);
            $this->session->set_userdata('admin_id',$row_array['admin_id']);
            $this->session->set_userdata('admin_full_name',$row_array['admin_full_name']);
            $this->session->set_userdata('admin_name',$row_array['admin_name']);
            $this->session->set_userdata('admin_email',$row_array['admin_email']);
            $this->session->set_userdata('admin_password',$row_array['admin_password']);
            $this->session->set_userdata('admin_profile',$row_array['admin_profile']);
            $this->session->set_userdata('is_twofa',$row_array['is_twofa']);

            if($row_array['is_twofa'] == 0)
            {
                $this->session->set_userdata('is_login_verify',1);
            }

            return 1;
        }
        else if(!$is_mail){
            return $this->jadminlogin($username,$password,!$is_mail);
        }else{
            return 0;
        }
    }
}