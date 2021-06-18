<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hash_Tag extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Hash_model');
    }
 
    public function index()
    {
        $this->load->view('admin/include/header');
    	$this->load->view('admin/hash/list');
    	$this->load->view('admin/include/footer');
        
    }


    public function update_explore_image(){
         if(isset($_POST['hash_tag_id'])){
            if(isset($_FILES['hash_tag_profile']['name'])){
                
                $image_name = $_FILES['hash_tag_profile']['name'];

                $upload_path =  "uploads/";
        
                $image_url='';
                $uploadConfig = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => "jpg|png|jpeg",
                    'overwrite' => TRUE,
                    'file_name' => 'hash-tag-'.rand(0,9999999).time()
                );
                    $this->load->library('upload', $uploadConfig);
                    if($this->upload->do_upload('hash_tag_profile')){
                        $uploadData = $this->upload->data();
                        $image_url = $uploadData['file_name'];
                     }
                      
                $this->Hash_model->move_to_explore(array('id'=>$_POST['hash_tag_id'],'hash_tag_image'=>$image_url ? $image_url : 'no-hash-image.png'));
            }
            echo true;
        }
    }
    public function showHashTag(){
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
            0=>'hash_tag_name',
            1=>'hash_tag_image',
            2=>'hash_tag_name',
            3=>'move_explore'
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
        $this->db->where('move_explore',0);
        $hash_tags = $this->db->get("hash_tags");

        $data = array();
        foreach($hash_tags->result() as $rows)
        {
            
            $move ='<a href="JavaScript:Void(0);" onclick="deletedata(\''.$rows->id.'\',\'hash_tags\');"   class="settings edit_hashtag" title="Edit Image" data-original-title="Edit Image"><i class="fa fa-reply text-success font-20 pointer p-l-5 p-r-5"></i></a>'; 
            $move .='<a data-toggle="modal" data-target="#modal-hashtag" data-id="'.$rows->id.'" data-src="'.base_url().'uploads/'.$rows->hash_tag_image.'" class="settings edit_hashtag" title="Edit Image" data-original-title="Edit Image"><i class="fa fa-edit text-success font-20 pointer p-l-5 p-r-5"></i></a>'; 
            
            $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            if($rows->move_explore == 1){
                $status ='<span class="badge badge-pill badge-success">Completed</span>';
            }
            $data[]= array(
                $rows->hash_tag_name,
                '<img style="height:50px;" width="50px" src="'.base_url().'uploads/'.$rows->hash_tag_image.'">',
                '<a href="'.base_url().'admin/hash-tags/'.$rows->hash_tag_name.'/videos">'. $this->Hash_model->hash_tag_videos_count($rows->hash_tag_name).'</a>',
                $status,
                $move,
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

        $total_tags = $this->db->get("hash_tags")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_tags,
            "recordsFiltered" => $total_tags,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }



    public function showHashTagExplore(){
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
            0=>'hash_tag_name',
            1=>'hash_tag_image',
            2=>'hash_tag_name',
            3=>'move_explore'
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
        $this->db->where('move_explore', 1);
        $hash_tags = $this->db->get("hash_tags");

        $data = array();
        foreach($hash_tags->result() as $rows)
        {
            
            $move ='<a href="JavaScript:Void(0);" onclick="deletedata(\''.$rows->id.'\',\'remove_hash_tags\');" class="text-danger" title="ReMove to explore"><i class="fa fa-mail-forward font-20 pointer p-l-5 p-r-5"></i></a>'; 
            $move .='<a data-toggle="modal" data-target="#modal-hashtag" data-id="'.$rows->id.'" data-src="'.base_url().'uploads/'.$rows->hash_tag_image.'" class="settings edit_hashtag" title="Edit Image" data-original-title="Edit Image"><i class="fa fa-edit text-success font-20 pointer p-l-5 p-r-5"></i></a>'; 
            
            $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            if($rows->move_explore == 1){
                $status ='<span class="badge badge-pill badge-success">Completed</span>';
            }
            
            $data[]= array(
                $rows->hash_tag_name,
                '<img style="height:50px;" width="50px" src="'.base_url().'uploads/'.$rows->hash_tag_image.'">',
                '<a href="'.base_url().'admin/hash-tags/'.$rows->hash_tag_name.'/videos">'. $this->Hash_model->hash_tag_videos_count($rows->hash_tag_name).'</a>',
                $status,
                $move,
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

        $total_tags = $this->db->get("hash_tags")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_tags,
            "recordsFiltered" => $total_tags,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }



    
    public function hash_tag_posts(){
        $hash_tag = $this->uri->segment(3);
        $data=array(
            'hash_tag_name'=>$hash_tag
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/hash/hash_posts',$data);
        $this->load->view('admin/include/footer');
    }



    public function showHashPosts()
    {
        $id=$this->input->post("hash_tag_name");
        
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
            0=>'post_video',
            2=>'user_id',
            3=>'post_description',
            4=>'post_hash_tag',
            5=>'total_view',
            6=>'video_likes_count',
            8=>'status',
            9=>'is_trending',
            10=>'created_date'
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

        $posts = $this->Hash_model->hash_tag_videos($id,$length,$start);

        $data = array();
        foreach($posts as $rows)
        {
            $userData = useridtodata($rows->user_id);

            $action = '';
            if($rows->status == 0)
            {
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                $action = '<a href="javascript:void(0);" onClick="deletedata(' . $rows->post_id . ', \'post_allow\')" class="btn btn-primary">Allow</a>';
            }
            else if($rows->status == 1)
            {
                $status = '<span class="badge badge-pill badge-success">Approved</span>';
                $action = '<a href="javascript:void(0);" style="color:white" onClick="deletedata(' . $rows->post_id . ', \'post_ban\')" class="btn btn-danger">Ban</a>';
            }
            else
            {
                $status = '';
            }


            $action .='<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->post_id.',\'post\');" class="delete" title="Delete Post"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>';
            
            if($rows->is_trending == 1)
            {
                $isTrending = '<span class="badge badge-pill badge-success">Trending</span>';
                $make = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->post_id.',\'remove_from_trending\');" class="delete" title="Remove to trending"><i style="font-size:20px;" class="fa fa-reply"></i></a>';
             }
            else
            {
                $make = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->post_id.',\'move_to_trending\');" class="text-success" title="Move to trending"><i style="font-size:20px;" class="fa fa-share text-success"></i></a>';
                $isTrending = '<span class="badge badge-pill badge-danger">No</span>';
            }
            $image = $rows->post_image ? $rows->post_image : 'logo.png';
            $post_image = '<img src="'.base_url(). 'uploads/' .$image  . '" alt="Post Image" height="50" width="50" />';
            $video = '<button data-toggle="modal" data-target="#modal-video" data-src="' . base_url() .'uploads/'. $rows->post_video . '" class="btn btn-success text-white" id="playvideomdl" title="Play Video"><i class="fa fa-play" style="font-size: 14px;"></i></button>';
            
            $h = explode(',',$rows->post_hash_tag);
            $hash_tags=array();
            foreach($h as $s){
                $hash_tags[]='<a href="'.base_url().'admin/hash-tags/'.$s.'/videos">'.$s.'</a>';
            }
            $data[]= array(
                $video,
                $post_image,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$userData['full_name'].'</a>',
                $rows->post_description ? $rows->post_description : '-',
                $rows->post_hash_tag ? implode(',',$hash_tags) : '-',
                $rows->video_view_count,
                $rows->video_likes_count,
                $isTrending,
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $make,
                $action,
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

        $total_posts = $this->Hash_model->hash_tag_videos_count($id);

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_posts,
            "recordsFiltered" => $total_posts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

}