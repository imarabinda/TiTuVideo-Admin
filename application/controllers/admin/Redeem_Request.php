<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Redeem_Request extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
    }

    public function index()
    {
        $this->load->view('admin/include/header');
        $this->load->view('admin/redeem_request/list');
        $this->load->view('admin/include/footer');
    }


    
    public function showRedeemRequest()
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
            0=>'redeem_request_type',
            1=>'account',
            2=>'amount',
            3=>'user_id',
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
        $redeem_req = $this->db->where('status',0)->get("redeem_request");

        $data = array();
        foreach($redeem_req->result() as $rows)
        {
            $user_name = useridtodata($rows->user_id);
            
            $status = '<span class="badge badge-pill badge-warning">Pending</span>';
            
            $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->redeem_request_id.',\'redeem_request\');" class="" title="Confirm Redeem Request"><i class=" text-success fa fa-share font-20 pointer p-l-5 p-r-5"></i></a>';
            
            $data[]= array(
                $rows->redeem_request_type,
                $rows->account,
                $rows->amount,
                '<a href="'.base_url().'users/'.$rows->user_id.'/view">'.$user_name['full_name'].'</a>',
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

        $total_requests = $this->db->where('status',0)->get("redeem_request")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_requests,
            "recordsFiltered" => $total_requests,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    
    public function showRedeemRequest_confirm()
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
            0=>'redeem_request_type',
            1=>'account',
            2=>'amount',
            3=>'user_id',
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
        $redeem_req = $this->db->where('status',1)->get("redeem_request");

        $data = array();
        foreach($redeem_req->result() as $rows)
        {
            $user_name = useridtodata($rows->user_id);
            $status = '<span class="badge badge-pill badge-success">Redeemed</span>';
            
            $data[]= array(
                $rows->redeem_request_type,
                $rows->account,
                $rows->amount,
                '<a href="'.base_url().'users/'.$rows->user_id.'/view">'.$user_name['full_name'].'</a>',
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
                $status    
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

        $total_requests = $this->db->where('status',0)->get("redeem_request")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_requests,
            "recordsFiltered" => $total_requests,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }
}