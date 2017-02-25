<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once (APPPATH . 'core/MY_main.php');
class Home extends MY_main {

	
    public function __construct() {
        parent::__construct();  
   
        
    }
    public function index(){            
        $this -> load -> view('home-view', $data);
    }
    public function csv_to_insertsql(){
    
        $filename = FCPATH.'doctors.csv';
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
    
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            $i= 1;$parent = null;
            //$this->category_model->delete_all();
            while (($row = fgetcsv($handle, 1000, "\n")) !== FALSE)
            {
                $line = $row[0];
                //echo "line".$line;
                $pos = strpos($line, ",");
                //echo "pos".$pos;
                if ($pos === false) {//not found
                    $catname = trim($line);
                    $parent = null;
                    $id = $i;
                    $prevID_1 = $id;
                    $i++;
                } else {
                    $expload = explode(",", $line);
    
                    /*
                     $ins_arr = array('id'=>$expload[0],
                     'name'=>$expload[1],
                     'name_french'=>$expload[2],
                     'name_german'=>$expload[3],
                     'name_arabic'=>$expload[4],
                     'parent_id'=>$expload[5]
                     );
    
                     echo "array<pre>";
                     print_r($ins_arr);
                     echo "</pre>";
                     $this->category_model->insert($ins_arr);
                     echo $this->db->last_query().";<br>";
                    */
                    $inssql="INSERT INTO `doctors` (`territory`, `first_name`, `last_name`, `specialty`, `workplace_type`, `potential`, `gender`, `nationality`, `mobile`, `city`) VALUES ('".$expload[0]."', '".mysql_real_escape_string($expload[1])."', '".mysql_real_escape_string($expload[2])."', '".mysql_real_escape_string($expload[3])."', '".mysql_real_escape_string($expload[4])."', '".mysql_real_escape_string($expload[5])."', '".mysql_real_escape_string($expload[6])."', '".mysql_real_escape_string($expload[7])."', '".mysql_real_escape_string($expload[8])."', '".mysql_real_escape_string($expload[9])."');";
    
                    echo $inssql."<br>";
    
    
    
                }
                	
            }
            fclose($handle);
        }
    
    }
    public function csv_to_insertsql2(){
    
        $filename = FCPATH.'doctors.csv';
        if(!file_exists($filename) || !is_readable($filename))
            return FALSE;
    
        $header = NULL;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== FALSE)
        {
            $i= 1;$parent = null;
            //$this->category_model->delete_all();
            while (($row = fgetcsv($handle, 1000, "\n")) !== FALSE)
            {
                $line = $row[0];
                //echo "line".$line;
                $pos = strpos($line, ",");
                //echo "pos".$pos;
                if ($pos === false) {//not found
                    $catname = trim($line);
                    $parent = null;
                    $id = $i;
                    $prevID_1 = $id;
                    $i++;
                } else {
                    $expload = explode(",", $line);
    
                  
                    $inssql="INSERT INTO `doctors` (`territory`, `specialty`, `first_name`, `last_name`) VALUES ('".$expload[0]."', '".mysql_real_escape_string($expload[1])."', '".mysql_real_escape_string($expload[2])."', '".mysql_real_escape_string($expload[3])."');";
    
                    echo $inssql."<br>";
    
    
    
                }
                 
            }
            fclose($handle);
        }
    
    }
}
