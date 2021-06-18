<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Report_model');
    }

    public function index()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/report/list');
    	$this->load->view('admin/include/footer');
    }

    public function showReport()
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
            0=>'report_type',
            1=>'reported_by',
            2=>'user_id',
            3=>'post_id',
            4=>'reason',
            5=>'description',
            6=>'contact_info',
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
        $reports = $this->db->where('report_type','report_video')->order_by('status','ASC')->get("report");

        $data = array();
        foreach($reports->result() as $rows)
        {
            $reportedByUser = useridtodata($rows->user_id);

            
            $vid = $this->Report_model->get_video_link($rows->post_id);
            
            $type = '<span class="badge badge-pill badge-danger">Video Report</span>';
            $reportedVideoUser = useridtodata($vid->user_id);
            
            $view_post = '<button data-toggle="modal" data-target="#modal-video" data-src="'.base_url().'uploads/'.$vid->post_video.'" class="btn btn-success text-white" id="playvideomdl" title="Play Video"><i class="fa fa-play" style="font-size: 14px;"></i></button>';
            $view_user = '<a href="'.base_url().'admin/users/'.base64_encode($vid->user_id).'/view">'.$reportedVideoUser['full_name'].'</a>';
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
                $type,
                $by_user,
                $view_user,
                $view_post,
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

        $total_report = $this->db->where('report_type','report_video')->get("report")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_report,
            "recordsFiltered" => $total_report,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }


    public function showReportUser()
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
            0=>'report_type',
            1=>'reported_by',
            2=>'user_id',
            3=>'post_id',
            4=>'reason',
            5=>'description',
            6=>'contact_info',
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
        $reports = $this->db->where('report_type','report_user')->order_by('status','ASC')->get("report");

        $data = array();
        foreach($reports->result() as $rows)
        {
            $reportUser = useridtodata($rows->user_id);
            
            $img = $this->Report_model->get_image_link($rows->user_id);

            $type = '<span class="badge badge-pill badge-danger">User Report</span>';
            $img = $img->user_profile ? $img->user_profile : 'no-profile-image.png';
            $view_post = '<img height="50px" width="50px" src="'.base_url().'uploads/'.$img.'" />';
            $view_user = '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$reportUser['full_name'].'</a>';
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
                $type,
                $by_user,
                $view_user,
                $view_post,
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

        $total_report = $this->db->where('report_type','report_user')->get("report")->num_rows();

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