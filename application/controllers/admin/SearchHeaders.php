<?php  if(!defined('BASEPATH')) exit('No direct script access allowed');

class SearchHeaders extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->model('Common');
        $this->load->model('Banner_model');
    }

    private $banner_options = array(
        array(
            'banner_action'=>'hashtag',
            'banner_action_name'=>'HashTag'
        ),array(
            'banner_action'=>'hashtag2',
            'banner_action_name'=>'HashTag2'
        ),
    );

    public function index()
    {
        $op =array(
            'banner_options'=>$this->banner_options
        );
    	$this->load->view('admin/include/header');
    	$this->load->view('admin/banners/list',$op);
    	$this->load->view('admin/include/footer');
    }
    
public function manage_banner(){
                        $banner_action    = $this->input->post('banner_action');
                        $banner_action_value      = $this->input->post('banner_action_value');
                        if(empty($banner_action) || empty($banner_action_value)){
                            echo json_encode(array('status'=>false));
                            exit();
                        }

                        $banner_image = '';

                        $banner_data   = array(
                            'banner_action' => $banner_action,
                            'banner_action_value' => $banner_action_value,
                           );
                        
                        
                        
                        if (!empty($_FILES['banner_image']['name'])) {
                            $config['upload_path']   = 'uploads/';
                            $config['allowed_types'] = 'jpg|jpeg|png';
                            $config['file_name']     = rand(0, 999999) . '-banner-image-' . rand(0, 9999) . time();
                            
                            //Load upload library and initialize configuration
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            
                            if ($this->upload->do_upload('banner_image')) {
                                $uploadData  = $this->upload->data();
                                $banner_data['banner_image'] = $uploadData['file_name'];
                            }
                        }
                        
                    if(!$this->input->post('banner_id')){
                        $insert_banner = $this->Common->insert('banners', $banner_data);
                       }else{
                        $update_banner = $this->Common->update('banners',array('banner_id'=>$this->input->post('banner_id')), $banner_data);
                    }
                        echo json_encode(array('status'=>1));
}



    public function showSearchHeaders(){

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
            0=>'banner_image',
            1=>'banner_action',
            2=>'banner_action_value',
            3=>'status',
            4=>'created_date',
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
        $banners = $this->db->order_by('status','ASC')->get("banners");

        $data = array();
        foreach($banners->result() as $rows)
        {
            
            $status = '<span class="badge badge-pill badge-success">Active</span>';
            if($rows->status == 0 ){
                $status = '<span class="badge badge-pill badge-danger">In-Active</span>';
            }

            $action = '<a data-toggle="modal" data-target="#modal-banner" data-id="'.$rows->banner_id.'" class="settings edit_banner" title="Edit Banner" data-original-title="Manage Banner "><i class="i-cl-3 fa fa-edit col-blue font-20 pointer p-l-5 p-r-5"></i></a>
            <a href="JavaScript:Void(0);" onclick="deletedata('.$rows->banner_id.',\'banner\');" class="delete" title="Delete Banner"><i class="fa fa-trash text-danger font-20 pointer p-l-5 p-r-5"></i></a>';
            
            $data[]= array(
                '<img height="50px;" width="50px;" src="'.base_url().'uploads/'.$rows->banner_image.'">',
                $rows->banner_action,
                $rows->banner_action_value,
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

        $total_coin_plan = $this->db->get("banners")->num_rows();

        $output = array(
            "draw" => $draw,
            "recordsTotal" => $total_coin_plan,
            "recordsFiltered" => $total_coin_plan,
            "data" => $data
        );
        echo json_encode($output);
        exit();
    }

public function get_banner_data_by_id(){
        $id = intval($this->input->post("banner_id"));
        if(!$id){
            return false;
        }
        
        $b_data = $this->Banner_model->get_banner_by_id($id);
        $b_data->banner_image =base_url().'uploads/'.$b_data->banner_image;
        
        echo json_encode(array('status'=>true,'data'=>
        array('banner_data'=>$b_data,'banner_options'=>$this->banner_options)));
    }



}
