<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notifications extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
    }

    public function index()
    {
        $this->load->view('admin/include/header');
        $this->load->view('admin/notification/list');
        $this->load->view('admin/include/footer');
    }


    public function send_notification(){
        $title = $this->input->post("notification_title");
        $body = $this->input->post("notification_body");
        $_data=array(
            'title'=>$title,
            'message'=>$body
        );
        
        if (!empty($_FILES['notification_icon']['name'])) {
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name']     = rand(0, 999999) . '-notification-icon-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('notification_icon')) {
                                $uploadData  = $this->upload->data();
                                $_data['icon'] = base_url().'uploads/'.$uploadData['file_name'];
                            }
        }

        
        if (!empty($_FILES['notification_image']['name'])) {
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name']     = rand(0, 999999) . '-notification-image-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('notification_image')) {
                                $uploadData  = $this->upload->data();
                                $_data['picture_url'] = base_url().'uploads/'.$uploadData['file_name'];
                            }
        }

        
        $sql = $this->db->select('device_token')->where(array('platform'=>0))->get('users')->result();
        
        $token_col = array_column($sql,'device_token');
    
        $registration_ids = array();
    
        if(count($sql) > 300){
            $registration_ids = array_chunk($token_col,400);
        }else{
            $registration_ids = array($token_col);
        }

        foreach ($registration_ids as $registration_id) {
            send_push($registration_id,$_data,'0');
        }
    
    }





    public function showNotification()
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
            0=>'sender_user_id',
            1=>'received_user_id',
            2=>'notification_type',
            3=>'message',
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
        $noti = $this->db->get("notification");

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
                '<a href="'.base_url().'users/'.base64_encode($rows->received_user_id).'/view">'.$userTo['full_name'].'</a>',
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