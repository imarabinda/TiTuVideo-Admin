<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rewarding extends CI_Controller{



    function __construct(){
         parent::__construct();
        $this->load->model('Rewarding_model');
    }

    public function index(){
        $this->load->view('admin/include/header');
        $this->load->view('admin/rewarding_action/list');
        $this->load->view('admin/include/footer');
    }

    public function update_rewarding_action(){
        if(isset($_POST['rewarding_action_id']) && !empty($_POST['rewarding_action_id'])){
            $data =array(
                'coin'=>intval($_POST['coin'])
            );
            echo $this->Rewarding_model->update(intval($_POST['rewarding_action_id']),$data);
        }
    }

    public function showRewardingList(){
        
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
            0=>'action_name',
            1=>'coin',
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
        $reports = $this->db->order_by('status','ASC')->get("rewarding_action");

        $data = array();
        foreach($reports->result() as $rows)
        {
            
            $status = '<span class="badge badge-pill badge-success">Active</span>';
            if($rows->status == 0 ){
                $status = '<span class="badge badge-pill badge-warning">In-Active</span>';
            }

            $action = '<a data-id="'.$rows->rewarding_action_id.'" data-name="'.$rows->action_name.'" data-coin="'.$rows->coin.'" class="edit_rewarding_action" data-toggle="modal" data-target="#modal-rewarding_action"><i class="fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>';
            
            
            $data[]= array(
                $rows->action_name,
                $rows->coin,
                $status,
                date('jS F \of Y h:s A',strtotime($rows->created_date)),
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

        $total_report = $this->db->get("rewarding_action")->num_rows();

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