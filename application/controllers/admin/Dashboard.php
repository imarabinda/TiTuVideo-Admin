<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller{

     function __construct(){

        parent::__construct();
        $this->load->database();
        // $this->load->model('admin/Login_model','Alogin');
        $this->load->model('Common');
        $this->load->model('Coin_model');
        $this->load->model('Hash_model');
        $this->load->model('Post_model');
        $this->load->model('Verification_model');
    }
 


    public function removeverify(){
        if(intval($this->input->post('verification_request_id'))){    
        $user_id = $this->Verification_model->get_user_id($this->input->post('verification_request_id'));
            $user_data = $this->Common->get_data_row('users', array('user_id'=>$user_id['user_id']), $field = 'platform,device_token', 'user_id');
            
            
        $noti_user_id = intval($user_id['user_id']);
        $platform = $user_data['platform'];
        $device_token = $user_data['device_token'];
        $message = $_POST['message_text'];

        $notificationdata = array(
        'sender_user_id'=> 0,
        'received_user_id'=> $noti_user_id,
        'notification_type'=> 'verification_removed',
        'message'=> $message,
        'created_date'=>date('Y-m-d H:i:s')
        );

        $insert = $this->Common->insert('notification', $notificationdata);
        send_push($device_token,$message,$platform);
        
        echo $this->Common->deletedata('verification_request',array('id'=>$this->input->post('verification_request_id')));
        }
    }

    public function deletedata(){
        if(intval($this->input->post('id'))){
            if($this->input->post('action_type')){
                switch($this->input->post('action_type')){
                    case 'remove_hash_tags' :
                        echo $this->Hash_model->toggle_explore_hash_tags($_POST['id'],0);
                        break;
                    case 'hash_tags':
                        echo $this->Hash_model->toggle_explore_hash_tags($_POST['id'],1);
                        break;
                    case 'move_to_trending':
                        echo $this->Post_model->toggle_post_data($_POST['id'],array('is_trending'=>1));
                        break;
                    case 'remove_from_trending':
                        echo $this->Post_model->toggle_post_data($_POST['id'],array('is_trending'=>0));
                        break;
                    case 'post':
                        echo $this->Common->deletedata('post',array('post_id'=>$_POST['id']));
                        break;
                    case 'post_ban':
                        echo $this->Post_model->toggle_post_data($_POST['id'],array('status'=>0));
                        break;
                    case 'post_allow':
                        echo $this->Post_model->toggle_post_data($_POST['id'],array('status'=>1));
                        break;
                    case 'sound':
                        echo $this->Common->deletedata('sound',array('sound_id'=>$this->input->post('id')));
                        break;
                    case 'sound_category':
                        echo $this->Common->deletedata('sound_category',array('sound_category_id'=>$this->input->post('id')));
                        break;
                    case 'verification_request':
                        echo $this->Common->update('verification_request',array('id'=>$this->input->post('id')),array('status'=>1));
                        break;
                    case 'verification_request_deny':
                        echo $this->Common->update('verification_request',array('id'=>$this->input->post('id')),array('status'=>0));
                        break;
                    case 'report_delete':
                        echo $this->Common->deletedata('report',array('report_id'=>$this->input->post('id')));
                        break;
                    case 'report_confirm':
                        echo $this->Common->update('report',array('report_id'=>$this->input->post('id')),array('status'=>1));
                        break;
                    case 'report_deny':
                        echo $this->Common->update('report',array('report_id'=>$this->input->post('id')),array('status'=>2));
                        break;
                    case 'redeem_request':
                        echo $this->Common->update('redeem_request',array('redeem_request_id'=>$this->input->post('id')),array('status'=>1));
                        break; 
                    case 'coin_plan':
                        echo $this->Common->deletedata('coin_plan',array('coin_plan_id'=>$this->input->post('id')));
                        break; 
                    case 'profile_category':
                        echo $this->Common->deletedata('profile_category',array('profile_category_id'=>$this->input->post('id')));
                        break; 
                    case 'profile_category_de':
                        echo $this->db->where('profile_category_id',$_POST['id'])->update('profile_category',array('status'=>0));
                        break;
                    case 'profile_category_act':
                        echo $this->db->where('profile_category_id',$_POST['id'])->update('profile_category',array('status'=>1));
                        break;
                    case 'banner':
                        echo $this->Common->deletedata('banners',array('banner_id'=>$this->input->post('id')));
                        break; 
                    case 'banner_de':
                        echo $this->db->where('banner_id',$_POST['id'])->update('banners',array('status'=>0));
                       break;
                    case 'banner_act':
                        echo $this->db->where('banner_id',$_POST['id'])->update('banners',array('status'=>1));
                      break;
                    default:
                        echo false;
                        break;
                }
            }
        }
    }
    public function index()
    {
        $data['today_reg'] = $this->Common->get_total_rows('users', ['created_date >'=>date('Y-m-d 00:00:00')]);
        $data['total_user'] = $this->Common->get_total_rows('users', ['status'=> 1]);
        $data['total_post'] = $this->Common->get_total_rows('post', ['status'=> 1]);
        $data['total_music_cat'] = $this->Common->get_total_rows('sound_category', ['status'=> 1]);
        $data['total_music'] = $this->Common->get_total_rows('sound', ['status'=> 1]);
        $data['total_tag'] = $this->Common->get_total_rows('hash_tags', ['move_explore'=> 1]);
        $data['total_verif_request'] = $this->Common->get_total_rows('verification_request', ['status'=>0]);
        $data['total_reports'] = $this->Common->get_total_rows('report', ['status'=>0]);
        $data['total_verified_user'] = $this->Common->get_total_rows('users', ['is_verify'=>1]);
        $data['redeem_request'] = $this->Common->get_total_rows('redeem_request', ['status'=> 0]);

        $coin_rate = $this->Coin_model->get_coin_rate();
        $data['coin_rate'] = $coin_rate->usd_rate;
        
        $data['total_wallet'] = $this->Coin_model->get_total_coin();
        
        $this->load->view('admin/include/header');
    	$this->load->view('admin/dashboard/dashboard', $data);
    	$this->load->view('admin/include/footer');
    }
}