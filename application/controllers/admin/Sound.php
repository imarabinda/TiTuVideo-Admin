<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sound extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Sound_model');
    }

    public function index()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/sound/list');
    	$this->load->view('admin/include/footer');
    }
    
    public function sound_category_list()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/sound/category_list');
    	$this->load->view('admin/include/footer');
    }

    public function sounds_by_category()
    {
        $sound_category_id = $this->uri->segment(3);
        $data=array( 'sound_category_id' => $sound_category_id );
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/sound/sounds_by_category',$data);
    	$this->load->view('admin/include/footer');
    }

    public function sound_posts()
    {
        $sound_id = $this->uri->segment(3);
        $data=array( 'sound_id' => $sound_id );
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/sound/sound_posts',$data);
    	$this->load->view('admin/include/footer');
    }


public function manage_sound(){
                    
                        $sound_title = $this->input->post('sound_title');
                        $duration    = $this->input->post('duration');
                        $singer      = $this->input->post('singer');
                        if(empty($sound_title) || empty($duration) || empty($singer)){
                            echo json_encode(array('status'=>false));
                            exit();
                        }

                        $post_sound  = '';
                        $sound_image = '';

                        $sound_data   = array(
                            'sound_title' => $sound_title,
                            'duration' => $duration,
                            'singer' => $singer,
                            'added_by'=>'admin_'.$this->session->userdata('admin_full_name'),
                            'sound_category_id'=>intval($this->input->post('sound_category_id')),
                        );
                        
                        if (!empty($_FILES['sound']['name'])) {
                     
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = '*';
                            $config['file_name']     = rand(0, 999999) . '-sound-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('sound')) {          
                                $uploadData = $this->upload->data();
                                $sound_data['sound'] = $uploadData['file_name'];
                            }
                        }
                        
                        if (!empty($_FILES['sound_image']['name'])) {
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name']     = rand(0, 999999) . '-sound-image-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('sound_image')) {
                                $uploadData  = $this->upload->data();
                                $sound_data['sound_image'] = $uploadData['file_name'];
                            }
                        }
                        
                    if(!$this->input->post('sound_id')){
                        $insert_sound = $this->Common->insert('sound', $sound_data);
                        $sound_id     = $this->db->insert_id();
                    }else{
                        $update_sound = $this->Common->update('sound',array('sound_id'=>$this->input->post('sound_id')), $sound_data);
                    }
                        echo json_encode(array('status'=>1));
}

    public function manage_sound_category(){
        $title = $this->input->post('sound_category_name');

        if(isset($_FILES['sound_category_profile']['name']) && !empty($_FILES['sound_category_profile']['name'])){
                $image_name = $_FILES['sound_category_profile']['name'];
                $upload_path =  "uploads/";
                $image_url='';
                $uploadConfig = array(
                    'upload_path' => $upload_path,
                    'allowed_types' => "jpg|png|jpeg",
                    'overwrite' => TRUE,
                    'file_name' => rand(0,9999).'-sound-cat-'.time().rand(0,9999)
                );
                    $this->load->library('upload', $uploadConfig);
                    if($this->upload->do_upload('sound_category_profile')){
                        $uploadData = $this->upload->data();
                        $image_url = $uploadData['file_name'];
                     }

                     $sound_cat_data =array(
                         'sound_category_name'=>$title,
                     'sound_category_profile'=>$image_url,
                     'status'=>1,
                     'created_date'=>date('Y-m-d H:i:s'));

                      
                     if(!$this->input->post('sound_category_id')){
                        $insert_sound_cat = $this->Common->insert('sound_category', $sound_cat_data);
                        
                    }else{
                        $update_sound = $this->Common->update('sound_category',array('sound_category_id'=>$this->input->post('sound_category_id')), $sound_cat_data);
                    }

                     echo json_encode(array(
                         'status'=>2
                     ));
            }
    }
    
    


    public function get_category(){
        echo json_encode(array('status'=>true,'data'=>array('sound_category_data'=>$this->Sound_model->get_sound_categories())));
    }
    public function get_sound_data_by_id(){
        $id = intval($this->input->post("sound_id"));
        if(!$id){
            return false;
        }
        
        $s_data = $this->Sound_model->get_sound_by_id($id);
        $s_data->sound_image =base_url().'uploads/'.$s_data->sound_image;
        $s_data->sound =base_url().'uploads/'.$s_data->sound;
        
        echo json_encode(array('status'=>true,'data'=>
        array('sound_data'=>$s_data,'sound_category_data'=>$this->Sound_model->get_sound_categories())));
    }

    public function showSound()
    {
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
            0=>'sound_image',
            1=>'sound',
            2=>'sound_category_id',
            3=>'sound_title',
            4=>'duration',
            5=>'singer',
            6=>'added_by',
            7=>'status',
            8=>'created_date'
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
        $noti = $this->db->get("sound");

        $data = array();
        foreach($noti->result() as $rows)
        {
            $sound_cat = $this->Sound_model->get_category_name($rows->sound_category_id);

            if($rows->status == 0)
            {
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            }
            else if($rows->status == 1)
            {
                $status = '<span class="badge badge-pill badge-success">Approved</span>';
            }
            else
            {
                $status = '';
            }
            $sound_image=$rows->sound_image ? $rows->sound_image : 'no-sound-image.png';
            $sound_image = '<img src="'.base_url(). 'uploads/' . $sound_image . '" alt="Sound Image" height="50" width="50" />';
            $audio = '<audio controls><source src="' . base_url() .'uploads/'. $rows->sound . '" type="audio/ogg">Your browser does not support the audio element.</audio>';

            $action = '<a data-toggle="modal" data-target="#modal-sound" data-id="'.$rows->sound_id.'" class="settings edit_sound" title="Edit Sound" data-original-title="Manage Sound "><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->sound_id.',\'sound\');" class="delete" title="Delete Sound"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="'.base_url().'admin/sounds/'.base64_encode($rows->sound_id).'/videos" class="settings" title="View Posts by this sound" data-toggle="tooltip" data-original-title="View Posts by this sound"><i class="fa fa-video col-red font-20 pointer p-l-5 p-r-5"></i></a>';
            $cat_link='Category Not Assigned';
            if($sound_cat['sound_category_name']){
                $cat_name =  $sound_cat['sound_category_name'];
                $cat_link = '<a href="'.base_url().'admin/sound-categories/'.base64_encode($rows->sound_category_id).'/sounds">'.$cat_name.'</a>';
            }
                 
            $f = true;
            if(!strpos($rows->added_by, 'admin_')){
                $f =false;
                $u =useridtodata($rows->added_by); 
            }

                
            $data[]= array(
                $sound_image,
                $audio,
                $cat_link,
                $rows->sound_title,
                $rows->duration,
                $rows->singer,  
                $f ? $rows->added_by : '<a href="'.base_url().'admin/users/'.base64_encode($rows->added_by).'/view" class="settings" title="View User" data-toggle="tooltip" data-original-title="View Posts by this sound">'.$u['full_name'].'</a>',
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
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

        $total_noti = $this->db->get("sound")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    
    public function showCategorySounds()
    {
        $cat_id = intval(base64_decode($this->input->post('sound_category_id')));
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
            0=>'sound_image',
            1=>'sound',
            2=>'sound_title',
            3=>'duration',
            4=>'singer',
            5=>'added_by',
            6=>'status',
            7=>'created_date'
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
        $noti = $this->db->where('sound_category_id',$cat_id)->get("sound");

        $data = array();
        foreach($noti->result() as $rows)
        {

            if($rows->status == 0)
            {
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            }
            else if($rows->status == 1)
            {
                $status = '<span class="badge badge-pill badge-success">Approved</span>';
            }
            else
            {
                $status = '';
            }
            $sound_image=$rows->sound_image ? $rows->sound_image : 'no-sound-image.png';
            $sound_image = '<img src="'.base_url(). 'uploads/' . $sound_image . '" alt="Sound Image" height="50" width="50" />';
            $audio = '<audio controls><source src="' . base_url() .'uploads/'. $rows->sound . '" type="audio/ogg">Your browser does not support the audio element.</audio>';

            $action = '<a data-toggle="modal" data-target="#modal-sound" data-id="'.$rows->sound_id.'" class="settings edit_sound" title="Edit Sound" data-original-title="Manage Sound "><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->sound_id.',\'sound\');" class="delete" title="Delete Sound"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="'.base_url().'admin/sounds/'.base64_encode($rows->sound_id).'/videos" class="settings" title="View Posts by this sound" data-toggle="tooltip" data-original-title="View Posts by this sound"><i class="fa fa-video col-red font-20 pointer p-l-5 p-r-5"></i></a>';
                
            $f = true;
            if(!strpos($rows->added_by, 'admin_')){
                $f =false;
                $u =useridtodata($rows->added_by); 
            }

            $data[]= array(
                $sound_image,
                $audio,
                $rows->sound_title,
                $rows->duration,
                $rows->singer,
                $f ? $rows->added_by : '<a href="'.base_url().'admin/users/'.base64_encode($rows->added_by).'/view" class="settings" title="View User" data-toggle="tooltip" data-original-title="View Posts by this sound">'.$u['full_name'].'</a>',
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
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
        $total_noti = $this->db->where('sound_category_id',$cat_id)->get("sound")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }




     public function showSoundCategory()
    {
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
            0=>'sound_category_name',
            1=>'sound_category_profile',
            2=>'status',
            3=>'created_date'
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
        $noti = $this->db->get("sound_category");

        $data = array();
        foreach($noti->result() as $rows)
        {
            if($rows->status == 0)
            {
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            }
            else if($rows->status == 1)
            {
                $status = '<span class="badge badge-pill badge-success">Approved</span>';
            }
            else
            {
                $status = '';
            }
            $sound_cat_image_p =$rows->sound_category_profile ? $rows->sound_category_profile : 'no-sound-cat-image.png';
            $sound_cat_image = '<img src="'.base_url(). 'uploads/' . $sound_cat_image_p . '" alt="Sound Image" height="50" width="50" />';

            $action = '<a data-toggle="modal" data-target="#modal-soundcategory" data-id="'.$rows->sound_category_id.'" data-name="'.$rows->sound_category_name.'" data-src="'.base_url(). 'uploads/' . $sound_cat_image_p . '" class="settings edit_soundcategory" title="Edit Sound" data-original-title="Manage Sound Category"><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->sound_category_id.',\'sound_category\');" class="delete" title="Delete Sound Category"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="'.base_url().'admin/sound-categories/'.base64_encode($rows->sound_category_id).'/sounds" class="view" title="View sounds of this category"><i class="fa fa-music text-success font-20 pointer p-l-5 p-r-5"></i></a>
            ';
            $data[]= array(
                $sound_cat_image,
                $rows->sound_category_name,
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
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

        $total_noti = $this->db->get("sound_category")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }



    
    public function showSoundPosts()
    {
        $id=intval(base64_decode($this->input->post("sound_id")));
        
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
            1=>'post_id',
            2=>'user_id',
            3=>'post_description',
            4=>'post_hash_tag',
            5=>'post_id',
            6=>'video_view_count',
            7=>'video_likes_count',
            9=>'status',
            10=>'is_trending',
            11=>'created_date'
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
        $posts = $this->db->where('sound_id',$id)->get("post");

        $data = array();
        foreach($posts->result() as $rows)
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


            $action .='<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->post_id.',\'post\');" class="delete" title="Delete Post"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="'.base_url().'admin/videos'.base64_encode($rows->post_id).'/reports"><i class="material-icons">bug_report</i></a>
            ';
            
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
$reports = $this->db->where(array('report_type'=>'report_video','post_id'=>$rows->post_id))->get('report')->num_rows(); 
            
            
            $data[]= array(
                $video,
                $post_image,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$userData['full_name'].'</a>',
                $rows->post_description ? $rows->post_description : '-', 
                $rows->post_hash_tag ? implode(',',$hash_tags) : '-',
                $reports,
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

        $total_posts = $this->db->where('sound_id',$id)->get("post")->num_rows();

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
