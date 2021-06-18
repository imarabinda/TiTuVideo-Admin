<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Post extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Report_model');
    }

    public function index()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/post/list');
    	$this->load->view('admin/include/footer');
    }

    
    public function user_reports(){
        $user_id = $this->uri->segment(3);
        $data=array(
            'video_id'=>$video_id
        );
        $this->load->view('admin/include/header');
        $this->load->view('admin/post/reports',$data);
        $this->load->view('admin/include/footer');
    }
    

    public function showPost()
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
            0=>'post_video',
            1=>'post_id',
            2=>'user_id',
            3=>'post_description',
            4=>'post_hash_tag',
            5=>'sound_id',
            6=>'post_id',
            7=>'video_view_count',
            8=>'video_likes_count',
            10=>'status',
            11=>'is_trending',
            12=>'created_date'
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
        $posts = $this->db->get("post");

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


            $action .= '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->post_id.',\'post\');" class="delete" title="Delete Post"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
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

            $sound = $this->db->select('sound_title')->where('sound_id',$rows->sound_id)->get('sound')->row_array();
            $reports = $this->db->where(array('report_type'=>'report_video','post_id'=>$rows->post_id))->get('report')->num_rows(); 
            $data[]= array(
                $video,
                $post_image,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$userData['full_name'].'</a>',
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

        $total_posts = $this->db->get("post")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_posts,
            "recordsFiltered" => $total_posts,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }




    
    public function showVideoReports()
    {
        $id = intval($this->input->post("video_id")); 
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
        $reports = $this->db->where(array('report_type'=>'report_video','post_id'=>base64_decode($id)))->order_by('status','ASC')->get("report");

        $data = array();
        foreach($reports->result() as $rows)
        {

            $type = '<span class="badge badge-pill badge-danger">Video Report</span>';
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

        $total_report = $this->db->where(array('report_type'=>'report_video','post_id'=>base64_decode($id)))->get("report")->num_rows();

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