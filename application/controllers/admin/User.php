<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        // $this->load->model('admin/User_model','Auser');
        $this->load->model('Common');
        $this->load->model('Sound_model');
        $this->load->model('Report_model');
    }

    public function index()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/user/user_list');
    	$this->load->view('admin/include/footer');
    }


    public function security()
    {
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/security');
        $this->load->view('admin/include/footer');
    }

    public function edit_user()
    {
        $user_id = base64_decode($this->uri->segment(3));
        $data['user_data'] = $this->Common->get_data_row('users', array('user_id'=>$user_id), $field = '*', 'user_id');
        
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/edit_user',$data);
        $this->load->view('admin/include/footer');
    }

    public function send_perticular_noti(){
        
        $noti_user_id = intval($_POST['user_id']);
        $noti_data = get_row_data('users',array('user_id'=>$noti_user_id));
        $platform = $noti_data['platform'];
        $device_token = $noti_data['device_token'];
        $message = $_POST['message'];

        $notificationdata = array(
        'sender_user_id'=> 0,
        'received_user_id'=> $noti_user_id,
        'notification_type'=> 'personal_message',
        'message'=> $message,
        'created_date'=>date('Y-m-d H:i:s')
        );

        $insert = $this->Common->insert('notification', $notificationdata);
        send_push($device_token,$message,$platform);
        echo 1;
    }

    public function view_user()
    {
        $user_id = base64_decode($this->uri->segment(3));
        $data = $this->Common->get_data_row('users', array('user_id'=>$user_id), $field = '*', 'user_id');
        
        $followers_where = array('to_user_id'=>$user_id);
        $followers_count = $this->Common->get_total_rows('followers', $followers_where);

        $following_where = array('from_user_id'=>$user_id);
        $following_count = $this->Common->get_total_rows('followers', $following_where);

        $total_videos = $this->Common->get_total_rows('post', array('user_id'=>$user_id));

        
        $data['total_post']=$total_videos;
        $data['total_followers']=$followers_count;
        $data['total_following']=$following_count;
        
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/view_user',$data);
        $this->load->view('admin/include/footer');
    }
    
    public function user_posts(){
        $user_id = base64_decode($this->uri->segment(3));
        $data=array(
            'user_id'=>$user_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/user_posts',$data);
        $this->load->view('admin/include/footer');
    }
    
    public function user_reports(){
        $user_id = $this->uri->segment(3);
        $data=array(
            'user_id'=>$user_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/reports',$data);
        $this->load->view('admin/include/footer');
    }
    public function user_notifications(){
        $user_id = $this->uri->segment(3);
        $data=array(
            'user_id'=>$user_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/notifications',$data);
        $this->load->view('admin/include/footer');
    }
    public function user_sounds(){
        $user_id = $this->uri->segment(3);
        $data=array(
            'user_id'=>$user_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/sounds',$data);
        $this->load->view('admin/include/footer');
    }
    
    public function user_comments(){
        $user_id = $this->uri->segment(3);
        $data=array(
            'user_id'=>$user_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/user/comments',$data);
        $this->load->view('admin/include/footer');
    }
    
    
    public function update_user()
    {
        extract($_POST);

        $fb_url= $this->input->post('fb_url');
        $insta_url= $this->input->post('insta_url');
        $youtube_url= $this->input->post('youtube_url');

        $data = array(
            'full_name'=>$full_name,
            'user_name'=>$user_name,
            'user_email'=>$user_email,
            'fb_url'=>$fb_url,
            'insta_url'=>$insta_url,
            'youtube_url'=>$youtube_url,
        );

        $where = array('user_id'=>$user_id);
        $update = $this->Common->update('users', $where, $data);
        print_r($update);
    }


        public function user_verify(){
        
        $user_id = $this->input->get('user_id');
        $status = $this->input->get('status');
        
        $this->db->where('user_id', $user_id);
        $this->db->set('is_verify',$status);
        $status = $this->db->update('users');
        if($status){
            echo 1;
        }else{
            echo 0;
        }
    }

    
    public function showUserPost()
    {
        $id=intval($this->input->post("user_id"));
        
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
            2=>'post_description',
            3=>'post_hash_tag',
            4=>'sound_id',
            5=>'post_id',
            6=>'video_view_count',
            7=>'video_likes_count',
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

        $this->db->limit($length,$start);
        $posts = $this->db->where('user_id',$id)->get("post");

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
            $h = explode($rows->post_hash_tag,',');
            $hash_tags=array();
            foreach($h as $s){
                $hash_tags[]='<a href="'.base_url().'admin/hash-tags/'.$s.'/videos">'.$s.'</a>';
            }

            $sound = $this->db->select('sound_title')->where('sound_id',$rows->sound_id)->get('sound')->row_array();
            $reports = $this->db->where(array('report_type'=>'report_video','post_id'=>$rows->post_id))->get('report')->num_rows(); 
            
            $data[]= array(
                $video,
                $post_image,
                $rows->post_description ? $rows->post_description : '-',
                 $rows->post_hash_tag ? implode(',',$hash_tags) : '-',
                '<a href="'.base_url().'admin/sounds/'.base64_encode($rows->sound_id).'/videos">'.$sound['sound_title'].'</a>',
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

        $total_posts = $this->db->where('user_id',$id)->get("post")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_posts,
            "recordsFiltered" => $total_posts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }



    public function showUsers()
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
        $users = $this->db->get("users");

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
            $link= base_url().'admin/users/'.base64_encode($rows->user_id);
            $data[]= array(
                '<img height="50px;" width="50px;" src="'.base_url().'uploads/'.$p.'" class="" alt="">',
                '<a href="'.$link.'/view" class="settings"title="Edit User" data-toggle="tooltip" data-original-title="Manage User">'.$rows->full_name.'</a>',
                $rows->user_name,
                $rows->user_email,
                $isVerified,
                $followers_count,
                $total_videos,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $status,
                '<a href="'.$link.'/edit" class="settings"title="Edit User" data-toggle="tooltip" data-original-title="Manage User"><i class="i-cl-3 fa fa-edit"></i></a>
                <a href="'.$link.'/view" class="settings"title="View User" data-toggle="tooltip" data-original-title="View Matrix"><i class="i-cl-6 fa fa-eye"></i></a>
                <a href="'.$link.'/videos" class="settings" title="View User Posts" data-toggle="tooltip" data-original-title="View User Posts"><i class="fa fa-video col-red font-20 pointer p-l-5 p-r-5"></i></a>
                <a href="'.$link.'/reports"><i class="material-icons">bug_report</i></a>
                <a href="'.$link.'/comments"><i class="material-icons">comment</i></a>
                <a href="'.$link.'/notifications"><i class="material-icons">notifications</i></a>
                <a href="'.$link.'/sounds"><i class="material-icons">music_note</i></a>
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

        $total_user = $this->db->get("users")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_user,
            "recordsFiltered" => $total_user,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }


    public function showUserNotifications()
    {
        $id = intval(base64_decode($this->input->post('user_id')));
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
            0=>'sender_user_id',
            1=>'notification_type',
            2=>'message',
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
        $noti = $this->db->where('received_user_id',$id)->get("notification");

        $data = array();
        foreach($noti->result() as $rows)
        {
            $userFrom = useridtodata($rows->sender_user_id);
            $userTo = useridtodata($rows->received_user_id);

            if($rows->notification_type == "following")
            {
                $type = '<span class="badge badge-pill badge-success">Following</span>';
            }
            else if($rows->notification_type == "liked_video")
            {
                $type = '<span class="badge badge-pill badge-danger">Liked Video</span>';
            }
            else if($rows->notification_type == "comment_video")
            {
                $type = '<span class="badge badge-pill badge-warning">Comment on Video</span>';
            }else if($rows->notification_type == "payment_success")
            {
                $type = '<span class="badge badge-pill badge-success">Payment Success</span>';
            }
            else if($rows->notification_type == "payment_failure")
            {
                $type = '<span class="badge badge-pill badge-danger">Payment Failure</span>';
            }
            else if($rows->notification_type == "service_update")
            {
                $type = '<span class="badge badge-pill badge-warning">Service Update</span>';
            }
            else if($rows->notification_type == "commission_payment")
            {
                $type = '<span class="badge badge-pill badge-success">Commission Payment</span>';
            }
            else
            {
                $type = '-';
            }

            $data[]= array(
                '<a href="'.base_url().'users/'.base64_encode($rows->sender_user_id).'/view">'.$userFrom['full_name'].'</a>',
                $type,
                $rows->message,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),               
            );  
        }
        // $total_noti = $this->Common->get_total_rows('notification', array());
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

        $total_noti = $this->db->where('received_user_id',$id)->get("notification")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }


    public function showUserComments()
    {
        $id = intval(base64_decode($this->input->post('user_id')));
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
            0=>'post_id',
            1=>'user_id',
            2=>'comment',
            3=>'status',
            4=>'created_date'
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
        $noti = $this->db->where('user_id',$id)->get("comments");

        $data = array();
        foreach($noti->result() as $rows)
        {
            $userFrom = useridtodata($rows->user_id);

             
            $vid = $this->Report_model->get_video_link($rows->post_id);

            
            $view_post = '<button data-toggle="modal" data-target="#modal-video" data-src="'.base_url().'uploads/'.$vid->post_video.'" class="btn btn-success text-white" id="playvideomdl" title="Play Video"><i class="fa fa-play" style="font-size: 14px;"></i></button>';
           
            if($rows->status == 0)
            {
                $status = '<span class="badge badge-pill badge-warning">Un-verified</span>';
            }
            else if($rows->status == 1)
            {
                $status = '<span class="badge badge-pill badge-success">Verified</span>';
            }
            else
            {
                $status = '';
            }

            $data[]= array(
                $view_post,
                '<a href="'.base_url().'users/'.base64_encode($rows->user_id).'/view">'.$userFrom['full_name'].'</a>',
                $rows->comment,
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                'Disable'
            );  
        }
        // $total_noti = $this->Common->get_total_rows('notification', array());
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

        $total_noti = $this->db->where('user_id',$id)->get("comments")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }


 public function showUserSounds()
    {
        
        $id = $this->input->post("user_id");
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
        $noti = $this->db->where('added_by',base64_decode($id))->get("sound");

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
                   

            $data[]= array(
                $sound_image,
                $audio,
                $cat_link,
                $rows->sound_title,
                $rows->duration,
                $rows->singer,
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

        $total_noti = $this->db->where('added_by',base64_decode($id))->get("sound")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function showUserReports()
    {
        $id = $this->input->post("user_id");       
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
            0=>'reported_by',
            1=>'reason',
            2=>'description',
            3=>'contact_info',
            4=>'created_date',
            5=>'status'
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
        $reports = $this->db->where(array('report_type'=>'report_user','user_id'=>base64_decode($id)))->order_by('status','ASC')->get("report");

        $data = array();
        foreach($reports->result() as $rows)
        {
            
            $reportedBy = useridtodata($rows->reported_by);
            $by_user = '<a href="'.base_url().'admin/users/'.base64_encode($rows->reported_by).'/view">'.$reportedBy['full_name'].'</a>';
            
            $status = '<span class="badge badge-pill badge-success">Completed</span>';
            if($rows->status == 0 ){
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            }else if($rows->status == 2 ){
                $status = '<span class="badge badge-pill badge-danger">Denied</span>';
            }

            $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->report_id.',\'report_delete\');" class="delete" title="Delete Request"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>';
            if($rows->status == 1){
             $action .='<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->report_id.',\'report_deny\');" class="" title="Deny Report"><i class=" text-danger fa fa-reply font-20 pointer p-l-5 p-r-5"></i></a>';   
            }else{
            $action .='<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->report_id.',\'report_confirm\');" class="" title="Confirm Report"><i class=" text-success fa fa-share font-20 pointer p-l-5 p-r-5"></i></a>';   
            }
            
            $data[]= array(
                $by_user,
                $rows->reason,
                $rows->description,
                $rows->contact_info,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $status,
                $action
            );  
        }
        // $total_noti = $this->Common->get_total_rows('notification', array());
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

        $total_report = $this->db->where(array('report_type'=>'report_user','user_id'=>base64_decode($id)))->get("report")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_report,
            "recordsFiltered" => $total_report,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

}