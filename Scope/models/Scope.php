<?php

class Scope extends CI_Model{
    public function __construct() {
        parent::__construct();
        
    }
        public function admin_id(){return 8;}   

    public function check_view_step_actions($id , $action) {
        if($this->session->userdata('admin')->group_id == $this->admin_id()){
            return $this->get_view_step($id);
        }
        $steps = ($this->session->userdata('admin')->step);
        $actions = array();
        foreach($steps as $step){
            if($step['table'] == $action){
                foreach($step['actions'] as $acts){
                    if($acts['name'] == 'step_'.$id){
                        return $this->get_view_step($id);
                        break;
                    }
                    if($acts['name'] === $id){
                       return $this->get_view_step($id);
                       break;
                    }
                }
            }
        }
    }

    
    public function get_user_info($id){
        $data = $this->db->query('SELECT id,first_name,last_name FROM admins where id = ' . $id .'')->result();
        if(empty($data[0])){
            
        }else{
            $data = $data[0];
        }
        return $data;
    }    
    public function check_permission_section($kind , $id , $action){
        $sections = $this->session->userdata('admin')->sections;
        //just get the ids 
        if($kind == 1){
            $data = array();
            $sess = $this->session->userdata('admin')->group_id;
            if($sess == $this->admin_id()){
                return 99999999;
            }
            if(empty($sections)){
                $this->session->set_flashdata('error', 'You don\'t have permissions to add, edit , or view any page');
                redirect(base_url().'admin');
            }
            foreach($sections as $section){
                $data['mains'][] = $section['main'];
                $subs = $section['subs'];
                foreach($subs as $sub){
                    $data['subs'][] = $sub;
                }
            }
            return $data;
        }
    }    
     public function check_view_actions_na($kind , $table_name , $action , $id ){
         
        $views = $this->session->userdata('admin')->view;//print_r($views);
        $data = array();
        if($this->session->userdata('admin')->group_id == $this->admin_id()){
            return 1;
        }
        if($kind == 2){
            if($this->session->userdata('admin')->group_id == $this->admin_id()){
                return 1;
            }
            if(!empty($views)){
                foreach($views as $view){
                    if($view['table'] == $table_name){
                        foreach($view['actions'] as $action1){
                            if($action1['name'] == $action){
                                return 1;
                            }
                        }
                    }
                }
            }
        }
            
     }
    public function check_view_actions($kind , $table_name , $action , $id ){
        $sess = $this->session->userdata("admin");
        if(empty($sess)){
            redirect(base_url().'admin/login');exit;
        }
        $views = $this->session->userdata('admin')->view;
        //just get the ids 
            $data = array();
            //print_r($this->session->userdata('admin'));
            if($this->session->userdata('admin')->group_id == $this->admin_id()){
                return 1;
            }
            if(empty($views)){
                $this->session->set_flashdata('error', 'You don\'t have permissions  !');
                redirect(base_url().'admin');
            }
            if($kind == 1){
                foreach($views as $view){
                    if($view['table'] == $table_name){
                        foreach($view['actions'] as $action1){
                            if($action1['name'] == $action){
                                $sections = $this->check_permission_section('1' , '' , '');
                                if($sections == 0){
                                    return 1;
                                }
                                if(in_array($id, $sections['mains'])){
                                    return 1; 
                                }else{
                                    
                                }
                                if(in_array($id, $sections['subs'])){
                                    return 1; 
                                }else{
                                    return 0; 
                                }
                            }
                        }
                    }

                }
            }
            if($kind == 2){
                if($this->session->userdata('admin')->group_id == $this->admin_id()){
                    return 1;
                }
                foreach($views as $view){
                    if($view['table'] == $table_name){
                        foreach($view['actions'] as $action1){
                            if($action1['name'] == $action){
                                return 1;
                            }
                        }
                    }
                }
            }
            if($kind == 3){
                if($this->session->userdata('admin')->group_id == $this->admin_id()){
                    return 1;
                }
                foreach($views as $view){
                    if($view['table'] == $table_name){
                        foreach($view['actions'] as $action1){
                            if($action1['name'] == $action){
                                return 1;
                            }
                        }
                    }
                }
                $this->session->set_flashdata('error', 'You don\'t have permission');
                $this->session->keep_flashdata('error');
                redirect(base_url().'admin');
            }
    }    
     
    public function query($query){
        $data = $this->db->query($query)->result();
        return $data;
    }    
    
    
    public function row_permissions_sec($permissions){
        $permissions = json_decode($permissions, TRUE);
        $new = array();
        if(!empty($permissions)){
            foreach($permissions as $x=> $permission){
                $prifx = $permission['main'];
                foreach($permission['subs'] as $action){
                    $new[] =  $prifx . '|'.$action;
                }
            }
        }
        return $new;        
    }
    
    public function row_steps_sec($permissions){
        $permissions = json_decode($permissions, TRUE);
        $new = array();
        if(!empty($permissions)){
            $new = array();
            foreach($permissions as $x=> $permission){
                $prifx = $permission['table'];
                foreach($permission['actions'] as $action){
                    $new[] =  $prifx . '|'.$action['name'];
                }
            }
        }
        return $new;        
    }
    public function row_permissions_view($permissions){
        $permissions = json_decode($permissions, TRUE);
        $new = array();
        if(!empty($permissions)){
            $new = array();
            foreach($permissions as $x=> $permission){
                $prifx = $permission['table'];
                foreach($permission['actions'] as $action){
                    $new[] =  $prifx . '|'.$action['name'];
                }
            }
        }
        return $new;
    }
    public function check_session(){
        $sess = $this->session->userdata("admin");
        if(empty($sess)){
            redirect(base_url().'admin/login');
        }
    }    
    public function delete($table, $id = 0){
        $this->table = $table;
        return $this->db->where('id', $id)->delete($this->table);
    }
    
     public function delete_cond($table, $condition)
    {
        $this->table = $table;
        return $this->db->where($condition)->delete($this->table);
        
    }
    
     public function select_row($table, $condition_array, $limit = null, $offset = null, $order = 'id', $order_type = null) {
        $this->db->order_by($order, $order_type);
        $read_data = $this->db->get_where($table, $condition_array, $limit, $offset);
        return $read_data->row();
    }
  // genreat query  
    
      
    public function getrow($table,$condition_array,$limit = null, $offset = null,$order='id',$order_type=null){
    	
        $this->db->order_by($order,$order_type);
         $read_data=$this->db->get_where($table,$condition_array,$limit,$offset);
        // echo   $this->db-> last_query();
         return $read_data->row();
    }
    
    public function insert($data_array,$table){
        $data =$data_array;
        $insert_data=$this->db->insert($table,$data);
        return $insert_data;
    }
    
    public function update($table,$data_array,$condition_array){
        $data =$data_array;
        $this->db->where($condition_array);
        $update_adata=$this->db->update($table,$data);
       //echo  $this->db->last_query();
        return $update_adata;
    }
    
    public function clean_url($url){
         $search = array(' ','"',"'",'(',')','!','<','>',',','%','=','+');
         $replace_with = array('-','','','','','','','','','','','');
         $final_url = str_replace($search, $replace_with, $url);
         $final_url = trim(trim(trim($final_url,"-"),"."));
         return $final_url;
                                               
    }
    
public function translate($key){
    $row = $this->main_model->read_row("translate",array('key_word'=>$key));
    return $row;
}

function remEntities($str) {
   if(substr_count($str, '&') && substr_count($str, ';')) {
       $amp_pos = strpos($str, '&');
       $semi_pos = strpos($str, ';');
       if($semi_pos > $amp_pos) {
           $tmp = substr($str, 0, $amp_pos);
           $tmp = $tmp. substr($str, $semi_pos + 1, strlen($str));
           $str = $tmp;
           if(substr_count($str, '&') && substr_count($str, ';')){
               $str = $this->remEntities($tmp);
           }
       }
   }
   return $str;
}
function more_than($original_string,$num_words){
	//$num_words = 7;
	$words = array();
	$words = explode(" ", $original_string, $num_words);
	$shown_string = "";

	if(count($words) == $num_words){
	   $words[$num_words-1] = " ";
	}

	return $shown_string = implode(" ", $words);
}

function set_ad($place_id,$page){
    $return = '';
    $sel_ad_page_query =  $this->db->query('
        SELECT *
        FROM ads 
        where active=1 AND start_date >= '.date("Y-m-d").' AND end_date >= '.date("Y-m-d").' AND pages = "'.$page.'" AND ads_place_id = '.$place_id.'
        ORDER BY id DESC LIMIT 1 
        ')->result();
    if(empty($sel_ad_page_query)){
        $sel_ad_page_query =  $this->db->query('
            SELECT *
            FROM ads 
            where active=1 AND start_date >= '.date("Y-m-d").' AND end_date >= '.date("Y-m-d").' AND pages = "999999999999" AND ads_place_id = '.$place_id.'
            ORDER BY id DESC LIMIT 1 
            ')->result();
    }
    if(!empty($sel_ad_page_query)){
        $sel_ad_page_query = $sel_ad_page_query[0];
        if($sel_ad_page_query->type == 1){
            $return = '<a href="'.$sel_ad_page_query->code.'" target="_blank"><!---'.$sel_ad_page_query->id.'---->'
                    . '<img class="img-responsive center-block" src="'.base_url().$sel_ad_page_query->img_url.'" alt="" />'
                    . '</a>';
        }
        if($sel_ad_page_query->type == 2){
            $return = '<div class=""><!---'.$sel_ad_page_query->id.'---->
                        '.$sel_ad_page_query->code.'
                      </div>';
            
        }
        if($sel_ad_page_query->type == 3){
            $return = '<div class=""><!---'.$sel_ad_page_query->id.'---->
                        '.$sel_ad_page_query->code.'
                      </div>';
        }
    }
    
    
    
    
    
    return $return ;
}



}


?>
