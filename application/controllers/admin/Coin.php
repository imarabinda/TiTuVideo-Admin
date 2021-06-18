<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class Coin extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Coin_model');
        $this->load->model('Common');
    }
    public function coin_rate(){
        $d = $this->Coin_model->get_coin_rate();
        $data =array(
            'usd_rate'=>$d->usd_rate,
            'coin_rate_id'=>$d->coin_rate_id
        );
     $this->load->view('admin/include/header');
     $this->load->view('admin/coin/coin_rate',$data);
     $this->load->view('admin/include/footer');
    }

    public function coin_plan(){
        
     $this->load->view('admin/include/header');
     $this->load->view('admin/coin/coin_plan');
     $this->load->view('admin/include/footer');
    }

    public function update_coin_rate(){
        if(intval($this->input->post('coin_rate_id')) && $this->input->post('usd_rate')){
           echo $this->Coin_model->update_coin_rate($this->input->post('coin_rate_id'),array('usd_rate'=>$this->input->post('usd_rate')));
        }
    }

    public function get_coinplan_data_by_id(){
            if(isset($_POST['coin_plan_id']) && !empty($_POST['coin_plan_id'])){
                $array =array(
                    'data'=>array(
                        'coin_plan'=>$this->Coin_model->get_coin_plan_by_id(base64_decode($_POST['coin_plan_id']))
                    ),
                    'status'=>1
                );
                echo json_encode($array);
            }
    }

    public function showCoinPlan(){
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
            0=>'coin_plan_name',
            1=>'coin_plan_description',
            2=>'coin_plan_price',
            3=>'coin_amount',
            4=>'playstore_product_id',
            5=>'appstore_product_id',
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
        $coin_plans = $this->db->order_by('status','ASC')->get("coin_plan");

        $data = array();
        foreach($coin_plans->result() as $rows)
        {
            

            
            $status = '<span class="badge badge-pill badge-success">Active</span>';
            if($rows->status == 0 ){
                $status = '<span class="badge badge-pill badge-danger">In-Active</span>';
            }

            $action = '<a data-toggle="modal" data-target="#modal-coin-plan" data-id="'.base64_encode($rows->coin_plan_id).'" class="settings edit_coin-plan" title="Edit Coin Plan" data-original-title="Edit Coin Plan "><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
                <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->coin_plan_id.',\'coin_plan\');" class="delete" title="Delete Coin Plan"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>
                ';
            
            $data[]= array(
                $rows->coin_plan_name,
                $rows->coin_plan_description,
                $rows->coin_plan_price,
                $rows->coin_amount,
                $rows->playstore_product_id,
                $rows->appstore_product_id,
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

        $total_coin_plan = $this->db->get("coin_plan")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_coin_plan,
            "recordsFiltered" => $total_coin_plan,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

    public function manage_coin_plan(){
        
        if(isset($_POST['coin_plan_id'])){
            $data = array(
                'coin_plan_name'=>$this->input->post('coin_plan_name'),
                'coin_plan_description'=>$this->input->post('coin_plan_description'),
                'coin_plan_price'=>intval($this->input->post('coin_plan_price')),
                'coin_amount'=>intval($this->input->post('coin_amount')),
                'playstore_product_id'=>$this->input->post('playstore_product_id'),
                'appstore_product_id'=>$this->input->post('appstore_product_id'),
                
            );
            
            if(empty($this->input->post('coin_plan_id')) && $this->Coin_model->add_coin_plan($data)){
                echo json_encode(array('status'=>2));
            }else if(!empty($this->input->post('coin_plan_id')) && $this->Coin_model->update_coin_plan($this->input->post('coin_plan_id'),$data)){
                echo json_encode(array('status'=>2));
            }else{
                echo 0;
            }
        
        }
    }
    
}