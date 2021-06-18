<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Comments extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Report_model');
    }

    public function index()
    {
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/comments/list');
    	$this->load->view('admin/include/footer');
    }

    public function showComments()
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
        $noti = $this->db->get("comments");

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

        $total_noti = $this->db->get("comments")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_noti,
            "recordsFiltered" => $total_noti,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
}