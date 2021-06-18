<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Profile_Categories extends CI_Controller {

    function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('User_model');
    }


    public function index(){
        $this->load->view('admin/include/header');
        $this->load->view('admin/profile_category/list');
        $this->load->view('admin/include/footer');
    }


    public function users_by_category(){
        $category_id = $this->uri->segment(3);
        $d = $this->User_model->get_profile_category_name(base64_decode($category_id));
        $data=array(
            'category_id'=>$category_id,
            'category_name'=>$d['profile_category_name']
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/profile_category/users_list',$data);
        $this->load->view('admin/include/footer');      
    }


    
    public function showUsers()
    {

        $category = intval(base64_decode($this->input->post('category_id')));
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            1=>'full_name',
            2=>'user_name',
            3=>'user_email',
            4=>'is_verify',
            7=>'created_date',
            8=>'status'
        );

        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }
        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);
        $users = $this->db->where('profile_category',$category)->get("users");

        $data = array();
        foreach($users->result() as $rows)
        {
            if ($rows->status == 0) {
                $status =  '<span class="badge badge-pill badge-danger">De-Active</span>';
            } elseif ($rows->status == 1) {
                $status =  '<span class="badge badge-pill badge-success">Active</span>';
            } 

            
            if($rows->is_verify== 1){
                $isVerified = '<span class="btn btn-primary">Verified</span>';
            }else{
                $isVerified = '<span class="btn btn-danger">Un-Verified</span>';
            }

            $user_id = $rows->user_id;
            $followers_where = array('to_user_id'=>$user_id);
            $followers_count = $this->Common->get_total_rows('followers', $followers_where);

            $following_where = array('from_user_id'=>$user_id);
            $following_count = $this->Common->get_total_rows('followers', $following_where);

            $total_videos = $this->Common->get_total_rows('post', array('user_id'=>$user_id));

            $p = $rows->user_profile ? $rows->user_profile : 'logo.png';
            $data[]= array(
                '<img height="50px;" width="50px;" src="'.base_url().'uploads/'.$p.'" class="" alt="">',
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view" class="settings"title="Edit User" data-toggle="tooltip" data-original-title="Manage User">'.$rows->full_name.'</a>',
                $rows->user_name,
                $rows->user_email,
                $isVerified,
                $followers_count,
                $total_videos,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $status,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/edit" class="settings"title="Edit User" data-toggle="tooltip" data-original-title="Manage User"><i class="i-cl-3 fa fa-edit"></i></a>
                <a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view" class="settings"title="View User" data-toggle="tooltip" data-original-title="View Matrix"><i class="i-cl-6 fa fa-eye"></i></a>
                <a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/videos" class="settings" title="View User Posts" data-toggle="tooltip" data-original-title="View User Posts"><i class="fa fa-video col-red font-20 pointer p-l-5 p-r-5"></i></a>
                '
            );  
        }
      
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $total_user = $this->db->where('profile_category',$category)->get("users")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_user,
            "recordsFiltered" => $total_user,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }



    public function showProfileCategories(){

        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
        $order = $this->input->post("order");
        $search= $this->input->post("search");
        $search = $search['value'];
        $col = 0;
        $dir = "";
        if(!empty($order))
        {
            foreach($order as $o)
            {
                $col = $o['column'];
                $dir= $o['dir'];
            }
        }

        if($dir != "asc" && $dir != "desc")
        {
            $dir = "desc";
        }
        $valid_columns = array(
            0=>'profile_category_image',
            1=>'profile_category_name',
            2=>'created_date',
            3=>'status',
        );
        if(!isset($valid_columns[$col]))
        {
            $order = null;
        }
        else
        {
            $order = $valid_columns[$col];
        }
        if($order !=null)
        {
            $this->db->order_by($order, $dir);
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $this->db->limit($length,$start);
        $coin_plans = $this->db->order_by('status','ASC')->get("profile_category");

        $data = array();
        foreach($coin_plans->result() as $rows)
        {
            
            $status = '<span class="badge badge-pill badge-success">Active</span>';
            if($rows->status == 0 ){
                $status = '<span class="badge badge-pill badge-danger">In-Active</span>';
            }
            $action = '<a data-toggle="modal" data-target="#modal-profilecategory" data-id="'.$rows->profile_category_id.'" data-name="'.$rows->profile_category_name.'" data-src="'.base_url().'uploads/'.$rows->profile_category_image.'" class="settings edit_profilecategory" title="Edit Profile Category" data-original-title="Manage Profile Category"><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
                <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->profile_category_id.',\'profile_category\');" class="delete" title="Delete Profile Category"><i class="fa fa-trash  text-danger font-20 pointer p-l-5 p-r-5"></i></a>
                <a href="'.base_url().'admin/profile-categories/'.base64_encode($rows->profile_category_id).'/users"><i class="fa fa-users text-danger font-20 pointer p-l-5 p-r-4"></i></a>';
            
            $data[]= array(
                '<img height="50px;" width="50px;" src="'.base_url().'uploads/'.$rows->profile_category_image.'">',
                $rows->profile_category_name,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $status,
                $action
            );  
        }
        
        if(!empty($search))
        {
            $x=0;
            foreach($valid_columns as $sterm)
            {
                if($x==0)
                {
                    $this->db->like($sterm,$search);
                }
                else
                {
                    $this->db->or_like($sterm,$search);
                }
                $x++;
            }                 
        }

        $total_coin_plan = $this->db->get("profile_category")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_coin_plan,
            "recordsFiltered" => $total_coin_plan,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function manage_profile_category(){

        $category_name = $this->input->post('profile_category_name');
        $_data = array(
            'profile_category_name'=>$category_name,
            'status'=>1
        );

        if (!empty($_FILES['profile_category_image']['name'])) {
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name']     = rand(0, 999999) . '-profile-cat-image-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('profile_category_image')) {
                                $uploadData  = $this->upload->data();
                                $_data['profile_category_image'] = $uploadData['file_name'];
                            }
        }

                    if(!$this->input->post('profile_category_id')){
                        $insert = $this->Common->insert('profile_category', $_data);
                        $_id     = $this->db->insert_id();
                    }else{
                        $update_ = $this->Common->update('profile_category',array('profile_category_id'=>$this->input->post('profile_category_id')), $_data);
                    }

                    echo json_encode(array('status'=>1));
    }

}

