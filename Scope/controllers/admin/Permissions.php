<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Permissions extends CI_Controller {
    
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function index(){
        $this->Smartget->check_view_actions('3','permissions', 'view','');
        $this->data['permissions'] = $this->Smartget->query('SELECT * FROM permissions');
        $this->data['page'] = "/admin/permissions/index";
        $this->load->view("/admin/layout", $this->data);
    }
    
    
    
    public function add(){
        $this->Smartget->check_view_actions('3','permissions', 'add','');
        $post = $this->input->post();
        if(!empty($post)){
            $this->db->insert('permissions',$post);
        }
        
        $this->data['page'] = "/admin/permissions/add";
        $this->load->view("/admin/layout", $this->data);
    }
    
    
    public function edit($id){
        $this->Smartget->check_view_actions('3','permissions', 'edit','');
        if(!is_numeric($id)){
            $this->session->set_flashdata('error', 'Ù�ÙŠ Ø­Ø§Ø¬Ù‡ ØºÙ„Ø·, Ø§Ù†Øª Ø¬Ø¨Øª Ø§Ù„Ù„ÙŠÙ†Ùƒ Ø¯Ù‡ Ù…Ù†ÙŠÙ† ØŸ');
            $this->session->keep_flashdata('error');
            redirect(base_url().'/admin');
        }
        $permission1 = $this->db->query('SELECT * FROM permissions where id=' . $id .'')->result();$permission = $this->data['permission'] = $permission1[0];
        if(empty($permission)){
            $this->session->set_flashdata('error', 'Ù�ÙŠ Ø­Ø§Ø¬Ù‡ ØºÙ„Ø·, Ø§Ù†Øª Ø¬Ø¨Øª Ø§Ù„Ù„ÙŠÙ†Ùƒ Ø¯Ù‡ Ù…Ù†ÙŠÙ† ØŸ');
            $this->session->keep_flashdata('error');
            redirect(base_url().'/admin');
        }
        $post = $this->input->post();
        if(!empty($post)){
            $this->Smartget->update('permissions',$post,array('id'=>$id));
        }
        $this->data['page'] = "/admin/permissions/edit";
        $this->load->view("/admin/layout", $this->data);
    }
    
    
    
}