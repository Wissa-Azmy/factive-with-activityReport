<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/Rest_controller.php';

class Factiveserv extends Rest_controller {

     function __construct() {
        parent::__construct();
       // $this->load->model('api/general_model');
        $this->load->helper('form');       
    }	
   
    /*
     * Get All territory 
     * {id: "1",name: "",startdate: ""}
     * http://localhost/factive/factiveserv/territory
     *
     */
    
    function  territory_post() {
        header("Access-Control-Allow-Origin: *");
                
        $sql="SELECT * FROM territory";
       // echo $sql;
        $searchresults1 = $this->db->query($sql)->result();
        //echo $this->db->last_query();
        $value = ' <option selected="" disabled=""></option>';
        foreach($searchresults1 as $territory){
            $value .= ' <option value="'.$territory->id.'">'.$territory->territory.'</option>';
        }
        echo $value;
        /*
       $searchresults1['res']='done';
        // Retrieve events .
        $this->response($searchresults1, 200);
         */
     } 
     function  specialty_post() {
         header("Access-Control-Allow-Origin: *");
     
         $sql="SELECT * FROM specialty";
         // echo $sql;
         $searchresults1 = $this->db->query($sql)->result();
         //echo $this->db->last_query();
         $value = ' <option selected="" disabled=""></option>';
         foreach($searchresults1 as $specialty){
             $value .= ' <option value="'.$specialty->id.'">'.$specialty->specialty.'</option>';
         }
         echo $value;
     
         ///$searchresults1['res']='done';
         // Retrieve events .
         //$this->response($searchresults1, 200);
     }
     function  doctors_post() {
         header("Access-Control-Allow-Origin: *");
         $key = $this->post();
         $sql="SELECT * FROM doctors WHERE territory=".$key['territory']." AND specialty=".$key['specialty']." ORDER BY first_name,last_name ASC";
         // echo $sql;
         $searchresults1 = $this->db->query($sql)->result();
         //echo $this->db->last_query();
         if (!empty($searchresults1)) {             
             $value = ' <option selected="" disabled=""></option>';
             foreach($searchresults1 as $doctors){
                 $value .= ' <option value="'.$doctors->id.'">'.$doctors->first_name." ".$doctors->last_name.'</option>';
             }
         }else{
             $value = ' <option selected="" disabled="">No Data Found</option>';
         }
         echo $value;
          
         ///$searchresults1['res']='done';
         // Retrieve events .
         //$this->response($searchresults1, 200);
     }
     function  addanswer_post() {
         header("Access-Control-Allow-Origin: *");
         $key = $this->post();
         //$key = $this->input->post();
         //print_r($key);
     
         if(!empty($key )){
              
             $resp = array();
             $question =  $key['question'];
             $doctor =  $key['doctor'];
     
             if (empty($question) OR empty($doctor)) {
                 $resp['error_code'] = 15;
             }else{
                 $resp['error_code'] = 10;
                 //echo $user_id." ".$branch_id."<pre>";
                 // print_r($key['questions']);
     
                 $sql='DELETE FROM user_answers WHERE user_id='.$doctor.' AND question_id='.$question;
                 $searchresults1 = $this->db->query($sql);
                 foreach($key['answers'] as $k=> $ans){
                     $sql2='SELECT * FROM user_answers WHERE user_id='.$doctor.' AND question_id='.$question.' AND answer_id='.$ans;
                     $searchresults2 = $this->db->query($sql2)->result();
                     if(empty($searchresults2) ){
                         $insarr['user_id']=$doctor;
                         $insarr['question_id']=$question;
                         $insarr['answer_id']=$ans;
                         $insarr['creation_date'] = date("Y-m-d H:i:s");
                         $this->db->insert('user_answers',$insarr);
                     }
                 }
             }
             // print_r($items);
             //echo json_encode($resp);
             $this->response($resp, 200);
              
             exit;
         }
         ///$searchresults1['res']='done';
         // Retrieve events .
         //$this->response($searchresults1, 200);
     }
     function  addoffanswers_post() {
         header("Access-Control-Allow-Origin: *");
         $key = $this->post();
         //$key = $this->input->post();
        
          
         if(!empty($key )){
     
             $resp = array();
             $answers = json_decode($key['answers']) ;
             //$doctor =  $key['doctor'];         
                 $resp['error_code'] = 10;
                 //echo $user_id." ".$branch_id."<pre>";
                 // print_r($key['questions']);
                 
                 //$sql='DELETE FROM user_answers WHERE user_id='.$ans->doctor.' AND question_id='.$ans->question;
                 //$searchresults1 = $this->db->query($sql);
                 foreach($answers as $k=> $ans){
                     /*
                     echo "<pre>";
                     print_r($ans);
                     echo "</pre>";
                     */            
                 
                     $sql2='SELECT * FROM user_answers WHERE user_id='.$ans->doctor.' AND question_id='.$ans->question.' AND answer_id='.$ans->answer;
                     $searchresults2 = $this->db->query($sql2)->result();
                     if(empty($searchresults2) ){
                         $insarr['user_id']=$ans->doctor;
                         $insarr['question_id']=$ans->question;
                         $insarr['answer_id']=$ans->answer;
                         $insarr['creation_date'] = date("Y-m-d H:i:s");
                         $this->db->insert('user_answers',$insarr);
                         //echo $this->db->last_query();
                     }
                 }            
             // print_r($items);
             //echo json_encode($resp);
             $this->response($resp, 200);     
             exit;
         }
         ///$searchresults1['res']='done';
         // Retrieve events .
         //$this->response($searchresults1, 200);
     }
     function  getquestion_post() {
         header("Access-Control-Allow-Origin: *");
         $key = $this->post();
         //$key = $this->input->post();
         //print_r($key);
          
         if(!empty($key )){
     
             $resp = array();
             $specialty =  $key['specialty'];
             $doctor =  $key['doctor'];
              
             $numofquestion=0;
                        
                     $sql2='SELECT MAX(question_id) as maxquest FROM user_answers WHERE user_id='.$doctor;
                     $searchresults2 = $this->db->query($sql2)->result();
                     $maxqesion=$searchresults2[0]->maxquest;
                     //echo $maxqesion;
                          
                     
                     if (($key['specialty']==2) OR ($key['specialty']==4)) {
                         //$numofquestion=3;
                         if (empty($maxqesion)) {
                             $resp['page']="page6.html";
                         }elseif ($maxqesion==1){
                             $resp['page']="page7.html";
                         }elseif ($maxqesion==2){
                             $resp['page']="page8.html";
                         }elseif ($maxqesion==3){
                             $resp['page']="page9.html";
                         }
                     }elseif (($key['specialty']==1) OR ($key['specialty']==5)) {
                         //$numofquestion=2;
                         if (empty($maxqesion)) {
                             $resp['page']="page6.html";
                         }elseif ($maxqesion==1){
                             $resp['page']="page7.html";
                        }elseif ($maxqesion==2){
                             $resp['page']="page9.html";
                         }
                     }if ($key['specialty']==3) {
                         //$numofquestion=2;
                         if (empty($maxqesion)) {
                             $resp['page']="page8.html";
                         }elseif ($maxqesion==1){
                             $resp['page']="page9.html";
                         }
                     }
                                         
             
             // print_r($items);
             //echo json_encode($resp);
             $this->response($resp, 200);
     
             exit;
         }
         ///$searchresults1['res']='done';
         // Retrieve events .
         //$this->response($searchresults1, 200);
     }
     function  doctorsoff_post() {
         header("Access-Control-Allow-Origin: *");
         $key = $this->post();
         $sql="SELECT doctors.id,doctors.territory,doctors.specialty,doctors.first_name,doctors.last_name FROM doctors ORDER BY first_name,last_name ASC";
         // echo $sql;
         $searchresults1 = $this->db->query($sql)->result();
         
         foreach($searchresults1 as $k=> $doctor){
             $searchresults1[$k]->maxquest='';
             $sql2='SELECT MAX(question_id) as maxquest FROM user_answers WHERE user_id='.$doctor->id;
             $searchresults2 = $this->db->query($sql2)->result();
             $searchresults1[$k]->maxquest=$searchresults2[0]->maxquest;
         }
         
         $resp=$searchresults1;
         
         
         ///$searchresults1['res']='done';
         // Retrieve events .
         $this->response($resp, 200);
     }
     
}
