<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admins extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('form','cookie');
        $this->load->library('form_builder');
    }
    public function index($perpage=null){
        $this->Scope->check_view_actions('3','admins', 'view','');
      
        $sql='SELECT *  
                FROM admins WHERE id!=1 ORDER BY id DESC ';
        $searchresults1 = $this->db->query($sql)->result();;
        $this -> load -> library('pagination');
        	
        if(isset($_GET['perpage']) && $_GET['perpage'] != "-1"){
        	$perpage = $_GET['perpage'];
        } else if($perpage != null){
        	$perpage = $perpage;
        } else{
        	$perpage = 20;
        }
        
         
        if(isset($_GET['perpage'])){
        	$sel = $_GET['perpage'];
        }
        else if($perpage != null){
        	$sel = $perpage;
        }
        else{
        	$sel = -1;
        }
        
        $config['base_url'] = base_url() . 'admin/admins/index/'.$perpage.'/';
        $config['total_rows'] = count($searchresults1);
       // $config['first_url'] = base_url() . 'admin/admins/index';
        $config['per_page'] = $perpage;
        $config['uri_segment'] = 5;
      
        $config['full_tag_open'] = '<div id="paging">';
        $config['full_tag_close'] = '</div>';
        $config['cur_tag_open'] = '<b>';
        $config['cur_tag_close'] = '</b>';
        $config['first_link'] =  "";
        $config['last_link'] =  "";        
        //$config['page_query_string'] = TRUE;
        //$config['use_page_numbers'] = TRUE;
        $config['reuse_query_string'] = TRUE;
        $config['suffix'] = '?'.http_build_query($_GET, '', "&");
       // $config['query_string_segment'] = 'per_page'.$perpage;
        $this -> pagination -> initialize($config);
        
        if ($this -> uri -> segment(5)) {
        	 $sql = $sql ." LIMIT ".$this -> uri -> segment(5).",".$config['per_page'] ;
        }else{
        	$sql = $sql ." LIMIT ".$config['per_page'];
        }
       
       // echo "hghgh".$this -> uri -> segment(5).$config['per_page'];
        //$this -> db -> limit($config['per_page'], $this -> uri -> segment(4));
        $query  = $this->db->query($sql)->result();
        //echo $this ->db -> last_query();
        $this->data['admins'] = $query;
        $this->data['page'] = "/admin/admins/index";
        $this->load->view("/admin/layout", $this->data);
    }    
    public function view($id=null){
        if(!isset($id) | !is_numeric($id)){
            redirect(base_url().'admin');
        }
        $query  = $this->db->query('SELECT *  
                FROM admins   where admins.id = '.$id)->result();
        if(empty($query)){
            redirect(base_url().'admin');
        }
        $this->data['admins'] = $query;
        $this->data['page'] = "/admin/admins/view";
        $this->load->view("/admin/layout", $this->data);
    }     
    
    public function edit($id=null){
        if($this->session->userdata('admin')->id != $id){
            $this->Scope->check_view_actions('3','admins', 'edit','');
        }
        if(!isset($id) | !is_numeric($id)){
        	$this->session->set_flashdata('error', 'There is some thing wrong in this link..');
        	$this->session->keep_flashdata('error');
            redirect(base_url().'admin');
        }
        $query  = $this->db->query('SELECT *   
                FROM admins where admins.id = '.$id)->result();
        if(empty($query)){
        	$this->session->set_flashdata('error', 'There is some thing wrong in this link..');
        	$this->session->keep_flashdata('error');
            redirect(base_url().'admin');
        }
        $this->data['user'] = $user = $query[0];
        
        $this->data['permissions'] =  $this->db->query('SELECT * FROM permissions')->result();
       
        $this->data['views_user'] =  $this->Scope->row_permissions_view($user->view);
     
        /////save side
        $user_new_info = $this->input->post();
        if(!empty($user_new_info)){
        	/*
            $new_permissions = array();
            $row_permissions = $this->input->post('step_flow');
            if(!empty($row_permissions)){
                foreach($row_permissions as $row_permission){
                    $row_permission = explode('|', $row_permission);
                    $new_permissions[]['table'] = $row_permission['0'];
                    foreach($new_permissions as $x => $new_permission){
                        if($new_permission['table'] == $row_permission['0']){
                            $new_permissions[$x]['actions'][]['name'] = $row_permission['1'];
                        }
                    }
                }
            }
            */
           // $user_new_info['step_flow'] = json_encode($new_permissions, TRUE);
           // unset($user_new_info['sections']);
            unset($user_new_info['permissions']);
            $new_permissions = array();
            $row_permissions = $this->input->post('permissions');
            if(!empty($row_permissions)){
                foreach($row_permissions as $row_permission){
                    $row_permission = explode('|', $row_permission);
                    $new_permissions[]['table'] = $row_permission['0'];
                    foreach($new_permissions as $x => $new_permission){
                        if($new_permission['table'] == $row_permission['0']){
                            $new_permissions[$x]['actions'][]['name'] = $row_permission['1'];
                        }
                    }
                }
            }
            /*
            $row_sections = $this->input->post('sections');
            $new_sections  = array();
            if(!empty($row_sections)){
                foreach($row_sections as $row_section){
                    $row_section = explode('|', $row_section);
                    $new_sections[$row_section['0']]['main'] = $row_section['0'];
                    $new_sections[$row_section['0']]['subs'][$row_section['1']] = $row_section['1'];
                }
            }
            */
            $user_new_info['view'] = json_encode($new_permissions, TRUE);
           // $user_new_info['sections'] = json_encode($new_sections, TRUE);
           
            if(isset($user_new_info['active']) && $user_new_info['active'] == 'on'){$user_new_info['active'] = '1';}else{$user_new_info['active'] = '0';}
            $user_new_info['last_update'] = date("Y-m-d H:i:s");
            $pass = $this->input->post("password");
            if(!empty($pass)){
                $user_new_info['password'] = md5(md5(sha1(md5(md5($pass)))));
            }else{
                unset($user_new_info['password']);
            }
            
            $this->Scope->update('admins',$user_new_info,array('id'=>$user->id));
            redirect(base_url().'admin/admins');
        }
        $this->data['send_to_footer'] =  '<script src="'.base_url().'data/admin/js/wysihtml5/bootstrap-wysihtml5.js"></script>'
                . '<script src="'.base_url().'data/admin/js/ckeditor/ckeditor.js"></script>'
                . '<script src="'.base_url().'data/admin/js/ckeditor/adapters/jquery.js"></script>'
                . '<script src="'.base_url().'data/admin/js/fileinput.js"></script>'
                . '<script src="'.base_url().'data/admin/js/bootstrap-switch.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/bootstrap-tagsinput.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/jquery.validate.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/select2/select2.min.js"></script>'
                . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2-bootstrap.css">'
                . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2.css">'
                . '<script src="'.base_url().'data/admin/js/fileinput.js"></script>';
        $this->data['page'] = "/admin/admins/edit";
        $this->load->view("/admin/layout", $this->data);
    }    
    public function load_more_admins(){
        $this->data['page'] = "/admin/admins";
        $this->load->view("/admin/layout", $this->data);
    }    
    public function login(){
        $post_data_full = $this->input->post();
        if(!empty($post_data_full)){
            $resp = array();
            $username =  $this->input->post("username");
            $password = $password = md5(md5(sha1(md5(md5($this->input->post("password"))))));
			//echo $password;
            $resp['submitted_data'] = $this->input->post();
            $login_status = 'invalid';
            $condition = array('username' => $username, 'password' => $password,'active'=>'1');
           
            $login = $this->Scope->getrow("admins", $condition);
        // echo   $this->db-> last_query();
            $allow_login_ip = '0';
          
            if(!empty($login) && $login->active == 1){
				/*
            	$group = $this->Scope->getrow("groups", array('id'=>$login->group_id));
                $view_group = json_decode($group->view, TRUE);
                $step_group = json_decode($group->step_flow, TRUE);
                $sections_group = json_decode($group->sections, TRUE);
				*/
                $view_user = json_decode($login->view, TRUE);
               
                $view =$view_user;
               
                $login->view = $view;
               // $login->step = $step_flow;
                //print_r($login);
                $this->session->set_userdata(array("admin" => $login));
                $cookie = array(
                    'name'   => 'admin_id',
                    'value'  => $login->id,
                    'expire' => '7500',
                    'secure' => FALSE
                );
                $this->input->set_cookie($cookie);
                $this->input->set_cookie($login->id);
                $login_status = 'success';
            }
            $resp['login_status'] = $login_status;
            if($login_status == 'success'){
                $resp['redirect_url'] = base_url(). 'admin';///news/step/1
                $this->session->set_flashdata('just_login', 'value');
                $this->session->keep_flashdata('just_login');
            }
            echo json_encode($resp);
            exit;
        }
        $this->data['page'] = "/admin/login";
        $this->load->view("/admin/login", $this->data);
    }
    public function logout(){
       $this->session->sess_destroy();
       redirect(base_url(). 'admin');
    }
    public function add() {
        $this->Scope->check_view_actions('3','admins', 'add','');
      
        
        $this->data['permissions'] =  $this->db->query('SELECT * FROM permissions')->result();
        //$this->data['groups'] = $this->db->query('SELECT * FROM groups  where active=1 ')->result();
        $user_new_info = $this->input->post();
        $errors = array();
        
        
        if(!empty($user_new_info)){
            if(!empty($user_new_info['email'])){
                $ver_email = $this->db->query('SELECT * FROM admins  where email="'.$user_new_info['email'].'"')->result();
                if(!empty($ver_email)){
                    $errors[] = 'The email has been used before..';
                }
            }
            if(!empty($user_new_info['username'])){
                $ver_username = $this->db->query('SELECT * FROM admins  where username="'.$user_new_info['username'].'"')->result();
                if(!empty($ver_username)){
                    $errors[] = 'Username has been used before…';
                }
            }
           
            unset($user_new_info['permissions']);
            $new_permissions = array();
            $row_permissions = $this->input->post('permissions');
            if(!empty($row_permissions)){
                foreach($row_permissions as $row_permission){
                    $row_permission = explode('|', $row_permission);
                    $new_permissions[]['table'] = $row_permission['0'];
                    foreach($new_permissions as $x => $new_permission){
                        if($new_permission['table'] == $row_permission['0']){
                            $new_permissions[$x]['actions'][]['name'] = $row_permission['1'];
                        }
                    }
                }
            }
          
            $user_new_info['view'] = json_encode($new_permissions, TRUE);
            //$user_new_info['sections'] = json_encode($new_sections, TRUE);
        
            if(isset($user_new_info['active']) && $user_new_info['active'] == 'on'){$user_new_info['active'] = '1';}else{$user_new_info['active'] = '0';}
            $user_new_info['password'] = md5(md5(sha1(md5(md5($user_new_info['password'])))));
            $this->data['errors'] = $errors;
            $user_new_info['created'] = date("Y-m-d H:i:s");
            $this->db->insert('admins',$user_new_info);
            redirect(base_url().'admin/admins');
        }
        $this->data['send_to_footer'] =  '<script src="'.base_url().'data/admin/js/wysihtml5/bootstrap-wysihtml5.js"></script>'
                . '<script src="'.base_url().'data/admin/js/ckeditor/ckeditor.js"></script>'
                . '<script src="'.base_url().'data/admin/js/ckeditor/adapters/jquery.js"></script>'
                . '<script src="'.base_url().'data/admin/js/fileinput.js"></script>'
                . '<script src="'.base_url().'data/admin/js/bootstrap-switch.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/bootstrap-tagsinput.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/jquery.validate.min.js"></script>'
                . '<script src="'.base_url().'data/admin/js/select2/select2.min.js"></script>'
                . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2-bootstrap.css">'
                . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2.css">';
        $this->data['page'] = "/admin/admins/add";
        $this->load->view("/admin/layout", $this->data);
    }
    
    
    public function staticpages() {
        $this->data['page'] = "/admin/staticpages";
        $this->load->view("/admin/layout", $this->data);
    }
    public function delete($id){
        if(!is_numeric($id)){
            $this->session->set_flashdata('error', 'There is some thing wrong in this link..');
            $this->session->keep_flashdata('error');
            redirect(base_url().'admin/admins');
        }
        $user1 = $this->data['user'] = $this->db->query('SELECT * FROM admins where id = ' . $id .'')->result();$user = $user1[0];
        if(empty($user)){
            $this->session->set_flashdata('error', 'There is some thing wrong in this link..');
            $this->session->keep_flashdata('error');
            redirect(base_url().'admin/admins');
        }
        if($this->Scope->check_view_actions('2','admins','delete','') == 1){
            $this->Scope->delete('admins', $id);
            $this->session->set_flashdata('good', 'Delete Done');
            $this->session->keep_flashdata('good');
            redirect(base_url().'admin/admins');
        }else{
            $this->session->set_flashdata('error', 'Error in deleting');
            $this->session->keep_flashdata('error');
            redirect(base_url().'admin/admins');
        }
    }    
}