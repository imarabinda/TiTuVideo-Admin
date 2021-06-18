<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verification_Request extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
    }

    public function index()
    {
        $this->load->view('admin/include/header');
        $this->load->view('admin/verification_request/list');
        $this->load->view('admin/include/footer');
    }


    public function showVerificationRequest()
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
            // 2=>'user_id',
            3=>'id_number',
            4=>'name',
            5=>'address',
            6=>'created_date',
            7=>'status'
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
        $requests = $this->db->get("verification_request");
        
        $data = array();
        foreach($requests->result() as $rows)
        {
            $id = useridtodata($rows->user_id);
            $photo_id = '<img height="100px;" width="100px;" src="'.base_url().'uploads/'.$rows->photo_id_image.'">';
            $image_photo_id = '<img height="100px;" width="100px;" src="'.base_url().'uploads/'.$rows->photo_with_id_image.'">';
       
        $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->id.',\'verification_request\');" class="text-success" title="Verify Request"><i class="fa fa-reply font-20 pointer p-l-5 p-r-5"></i></a>';
  
        if($rows->status == 1){
            $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->id.',\'verification_request_deny\');" class="text-danger" title="Deny Verify Request"><i  class="fa fa-mail-forward font-20 pointer p-l-5 p-r-5"></i></a>';    
        }
        
        $status = '<span class="badge badge-pill badge-success">Completed</span>';
        
        if($rows->status == 0){
            $status = '<span class="badge badge-pill badge-warning">Pending</span>';
        }
        
        $action .= '<a href="JavaScript:Void(0);" onclick="removeverify('.$rows->id.');" class="delete" title="Remove Verifion Request"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>';
       
       
            $data[]= array(
                $photo_id,
                $image_photo_id,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$id['full_name'].'</a>',
                $rows->name,
                $rows->id_number,
                $rows->address,
                $rows->created_date,
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

        $totals_req = $this->db->get("verification_request")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $totals_req,
            "recordsFiltered" => $totals_req,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function showVerificationRequestExplore()
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
            // 2=>'user_id',
            3=>'id_number',
            4=>'name',
            5=>'address',
            6=>'created_date',
            7=>'status'
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
        $requests = $this->db->where('status',1)->get("verification_request");
        
        $data = array();
        foreach($requests->result() as $rows)
        {
            $id = useridtodata($rows->user_id);
            $photo_id = '<img height="100px;" width="100px;" src="'.base_url().'uploads/'.$rows->photo_id_image.'">';
            $image_photo_id = '<img height="100px;" width="100px;" src="'.base_url().'uploads/'.$rows->photo_with_id_image.'">';
       
        $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->id.',\'verification_request\');" class="text-success" title="Verify Request"><i class="fa fa-reply font-20 pointer p-l-5 p-r-5"></i></a>';
  
        if($rows->status == 1){
            $action = '<a href="JavaScript:Void(0);" onclick="deletedata('.$rows->id.',\'verification_request_deny\');" class="text-danger" title="Deny Verify Request"><i  class="fa fa-mail-forward font-20 pointer p-l-5 p-r-5"></i></a>';    
        }
        
        $status = '<span class="badge badge-pill badge-success">Completed</span>';
        
        if($rows->status == 0){
            $status = '<span class="badge badge-pill badge-warning">Pending</span>';
        }
        
        $action .= '<a href="JavaScript:Void(0);" onclick="removeverify('.$rows->id.');" class="delete" title="Remove Verifion Request"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>';
       
       
            $data[]= array(
                $photo_id,
                $image_photo_id,
                '<a href="'.base_url().'admin/users/'.base64_encode($rows->user_id).'/view">'.$id['full_name'].'</a>',
                $rows->name,
                $rows->id_number,
                $rows->address,
                $rows->created_date,
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

        $total_noti = $this->db->get("notification")->num_rows();

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