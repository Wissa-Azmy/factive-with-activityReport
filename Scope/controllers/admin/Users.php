<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->helper('form','cookie');
        $this->load->library('form_builder');
    }
    
    
    public function userreportform(){
        // $this->data['sections']= $this->get_sections_ac();
        $this->data['send_to_footer'] =  '<script type="text/javascript" src="'.base_url().'data/admin/js/daterangepickersingle/moment.js"></script>'
                    .'<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">'
                    .'<script type="text/javascript" src="'.base_url().'data/admin/js/daterangepickersingle/daterangepicker.js"></script>'
                    .'<link rel="stylesheet" type="text/css" href="'.base_url().'data/admin/js/daterangepickersingle/daterangepicker.css" /> '
                    . '<script src="'.base_url().'data/admin/js/select2/select2.min.js"></script>'
                    . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2-bootstrap.css">'
                    . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2.css">';
        $this->data['page'] = "/admin/users/reportform";
        $this->load->view("/admin/layout", $this->data);
    }

    public function userreport(){       
        if ($this->input->post("dateto")) {
            $to=date('Y-m-d 00:00:00', strtotime($this->input->post("dateto")));
        }else{
            $to= date("Y-m-d H:i:s");
        }
        
        if ($this->input->post("datefrom")) {
            $from=date('Y-m-d 00:00:00', strtotime($this->input->post("datefrom")));
        }else{
            $from= '00-00-00 00:00:00';
        }
        
        $where[] ='creation_date >= \''.$from.'\'';
        $where[] ='creation_date <= \''.$to.'\'';
        if ($_POST['territory']){
            $where[] =' doctors.territory='.$_POST['territory'];
        }
       
        if ($_POST['specialty']){
            $where[] =' doctors.specialty='.$_POST['specialty'];
        }
        
        
        if(!empty($where)){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
        
        
        $countarr=array();
        $file= fopen(FCPATH . "data/admin/js/reports/chart_user/Column3D.xml", "w");
        $_xml ="<chart caption='Answers Chart' xAxisName='Answers' yAxisName='Percentage of Users' showValues='1' decimals='0' formatNumberScale='0.5'>\r\n";
       
        if ($_POST['question']){
            $sqlq='SELECT * FROM questions WHERE id='.$_POST['question'];      
            $questiontext = $this->db->query($sqlq)->result();
            $this->data['questiontext'] = $questiontext[0]->question;
            
            $sqlall='SELECT COUNT(*) as allcount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND question_id='.$_POST['question'];
            $questionall = $this->db->query($sqlall)->result();
            $allanserscount=$questionall[0]->allcount;
            
            $sql2='SELECT * FROM answers WHERE question_id='.$_POST['question'];
            $searchresults2 = $this->db->query($sql2)->result();
           // while ($start_date<=$end_date) {
            foreach($searchresults2 as $k=> $answer){
                //if ($_POST['territory']){
                 $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND user_answers.answer_id='.$answer->id;
                //}else{
                //    $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id WHERE user_answers.answer_id='.$answer->id;
               // }
                //echo $sql."<br />";
                $usercount= $this->db->query($sql)->result();
                
                if ($allanserscount>0){
                    $ansvalue=($usercount[0]->mycount/$allanserscount)*100;
                }else{
                    $ansvalue=0;
                }
                $countarr[$answer->answer]=$ansvalue;                
                $_xml .=" <set label='".$answer->answer."' value='".round($ansvalue)."' />\r\n";
            }
                       
               // $start_date=strtotime("+1 day", strtotime($start_date));
               // $start_date=date('Y-m-d', $start_date);        
           // }
        }else{
            //echo "noquestion";
            $this->data['questiontext'] = "All Questions";
            $allanserscount=0;
            //Answer 1
            for ($i = 1; $i <= 10; $i++) {
                $i2=$i+10;
                $i3=$i+20;
                $sql2='SELECT * FROM answers WHERE id='.$i;
                $searchresults2 = $this->db->query($sql2)->result();
                $answer[$i]=$searchresults2[0]->answer;
                
                //$sql='SELECT COUNT(*) as mycount from ( SELECT distinct user_id FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.') ) t1';
                //$sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.') GROUP BY user_answers.user_id';
                
                $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.')';
                
                //echo $sql."<br />";
                $usercount= $this->db->query($sql)->result();
                
                //if ($usercount[0]->mycount==3){
                if ($usercount[0]->mycount){
                    $ansvalue[$i]=$usercount[0]->mycount;
                    $allanserscount+=$usercount[0]->mycount;
                }else{
                    $ansvalue[$i]=0;
                } 
            }
           
            for ($i = 1; $i <= 10; $i++) {
                $ansvalueratio=($ansvalue[$i]/$allanserscount)*100;
                $countarr[$answer[$i]]=$ansvalueratio;
                $_xml .=" <set label='".$answer[$i]."' value='".round($ansvalueratio)."' />\r\n";
            }
            
        }
        //echo " from ".$from;
        $_xml .=" </chart>";
       // echo "xml ".$_xml;
        
        fwrite($file, $_xml);
        fclose($file);
        $this->data['tableArray'] = $countarr;
        
        $this->data['question'] = $_POST['question'];
        $this->data['territory'] = $_POST['territory'];
        $this->data['specialty'] = $_POST['specialty'];
        $this->data['datefrom'] = $_POST['datefrom'];
        $this->data['dateto'] = $_POST['dateto'];
        
        $this->data['title'] = "Questions subscribed Repot";
        
       // $this->data['daterange'] = $_POST['daterange'];
        $this->data['page'] = "/admin/users/userreport";
        $this->load->view("/admin/layout", $this->data);
    }
    public function printuserreport(){
        if ($this->input->post("dateto")) {
            $to=date('Y-m-d 00:00:00', strtotime($this->input->post("dateto")));
        }else{
            $to= date("Y-m-d H:i:s");
        }
        
        if ($this->input->post("datefrom")) {
            $from=date('Y-m-d 00:00:00', strtotime($this->input->post("datefrom")));
        }else{
            $from= '00-00-00 00:00:00';
        }
        
        $where[] ='creation_date >= \''.$from.'\'';
        $where[] ='creation_date <= \''.$to.'\'';
        if ($_POST['territory']){
            $where[] =' doctors.territory='.$_POST['territory'];
        }
         
        if ($_POST['specialty']){
            $where[] =' doctors.specialty='.$_POST['specialty'];
        }
        
        
        if(!empty($where)){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
        
        
        $countarr=array();
       
        if ($_POST['question']){
            $sqlq='SELECT * FROM questions WHERE id='.$_POST['question'];
            $questiontext = $this->db->query($sqlq)->result();
            $this->data['questiontext'] = $questiontext[0]->question;
        
            $sqlall='SELECT COUNT(*) as allcount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND question_id='.$_POST['question'];
            $questionall = $this->db->query($sqlall)->result();
            $allanserscount=$questionall[0]->allcount;
        
            $sql2='SELECT * FROM answers WHERE question_id='.$_POST['question'];
            $searchresults2 = $this->db->query($sql2)->result();
            // while ($start_date<=$end_date) {
            foreach($searchresults2 as $k=> $answer){
                //if ($_POST['territory']){
                $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND user_answers.answer_id='.$answer->id;
                //}else{
                //    $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id WHERE user_answers.answer_id='.$answer->id;
                // }
                //echo $sql."<br />";
                $usercount= $this->db->query($sql)->result();
        
                if ($allanserscount>0){
                    $ansvalue=($usercount[0]->mycount/$allanserscount)*100;
                }else{
                    $ansvalue=0;
                }
                $countarr[$answer->answer]=$ansvalue;
               
            }
             
            // $start_date=strtotime("+1 day", strtotime($start_date));
            // $start_date=date('Y-m-d', $start_date);
            // }
        }else{
            //echo "noquestion";
            $this->data['questiontext'] = "All Questions";
            $allanserscount=0;
            //Answer 1
            for ($i = 1; $i <= 10; $i++) {
                $i2=$i+10;
                $i3=$i+20;
                $sql2='SELECT * FROM answers WHERE id='.$i;
                $searchresults2 = $this->db->query($sql2)->result();
                $answer[$i]=$searchresults2[0]->answer;
        
                //$sql='SELECT COUNT(*) as mycount from ( SELECT distinct user_id FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.') ) t1';
               // $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.') GROUP BY user_answers.user_id';
                $sql='SELECT COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id '.$where.' AND (user_answers.answer_id='.$i.' OR user_answers.answer_id='.$i2.' OR user_answers.answer_id='.$i3.')';
                //echo $sql."<br />";
                $usercount= $this->db->query($sql)->result();
        
                //if ($usercount[0]->mycount==3){
                if ($usercount[0]->mycount){
                    $ansvalue[$i]=$usercount[0]->mycount;
                    $allanserscount+=$usercount[0]->mycount;
                }else{
                    $ansvalue[$i]=0;
                }
        
        
            }
        
        
        
            for ($i = 1; $i <= 10; $i++) {
                $ansvalueratio=($ansvalue[$i]/$allanserscount)*100;
                $countarr[$answer[$i]]=$ansvalueratio;
               
            }
        
        }
        
       
        //$searchresults1 = $this->db->query($sql)->result();
    
        $fp = fopen(FCPATH.'uploaded/userreport.csv', 'w');
        fputs($fp,b"\xEF\xBB\xBF");//write utf-8 BOM to file
        fputcsv($fp, array("Answer","Percentage of users"));
        foreach ($countarr as $key=>$val) {  //echo $key.$val;
            fputcsv($fp, array($key,round($val)));
        }
        fclose($fp);
    
        redirect(base_url().'uploaded/userreport.csv');
    }
    public function docreportform(){
        // $this->data['sections']= $this->get_sections_ac();
        $this->data['send_to_footer'] =  '<script type="text/javascript" src="'.base_url().'data/admin/js/daterangepickersingle/moment.js"></script>'
            .'<link href="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">'
                .'<script type="text/javascript" src="'.base_url().'data/admin/js/daterangepickersingle/daterangepicker.js"></script>'
                    .'<link rel="stylesheet" type="text/css" href="'.base_url().'data/admin/js/daterangepickersingle/daterangepicker.css" /> '
                        . '<script src="'.base_url().'data/admin/js/select2/select2.min.js"></script>'
                            . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2-bootstrap.css">'
                                . '<link rel="stylesheet" href="'.base_url().'data/admin/js/select2/select2.css">';
        $this->data['page'] = "/admin/users/reportformdetail";
        $this->load->view("/admin/layout", $this->data);
    }
    public function userreportdocs(){
        if ($this->input->post("dateto")) {
            $to=date('Y-m-d 00:00:00', strtotime($this->input->post("dateto")));
        }else{
            $to= date("Y-m-d H:i:s");
        }
        
        if ($this->input->post("datefrom")) {
            $from=date('Y-m-d 00:00:00', strtotime($this->input->post("datefrom")));
        }else{
            $from= '00-00-00 00:00:00';
        }
        
        $where[] =' creation_date >= \''.$from.'\'';
        $where[] =' creation_date <= \''.$to.'\'';
        if ($_POST['territory']){
            $where[] =' doctors.territory='.$_POST['territory'];
        }
         
        if ($_POST['specialty']){
            $where[] =' doctors.specialty='.$_POST['specialty'];
        }
        
        
        if(!empty($where)){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
       
       
        if ($_POST['question']){
            $sqlq='SELECT * FROM questions WHERE id='.$_POST['question'];
            $questiontext = $this->db->query($sqlq)->result();
            $this->data['questiontext'] = $questiontext[0]->question;
            //if ($_POST['territory']){
                $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id 
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' AND user_answers.question_id='.$_POST['question'].' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
           /* }else{
                $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                    INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    WHERE user_answers.question_id='.$_POST['question'].' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
            }
            */
            //echo $sql."<br />";
            $usercount= $this->db->query($sql)->result();
            
        }else{
            $this->data['questiontext'] = "All Questions"; 
            /*
            $sql='SELECT user_answers.user_id, COUNT(*) as mycount FROM user_answers WHERE user_answers.question_id=1 OR user_answers.question_id=2 OR user_answers.question_id=3 GROUP BY user_answers.user_id';
           // echo $sql."<br />";
            $usercount1= $this->db->query($sql)->result();
            $allquesusers="";
            foreach($usercount1 as $k=> $user){
                if ($user->mycount==3){
                      $allquesusers.=$user->user_id.", ";
                }        
            }
            $allquesusers=trim($allquesusers,", ");
            $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' AND doctors.id IN ('.$allquesusers.') ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
            */           
            $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
            //echo $sql."<br />";
            $usercount= $this->db->query($sql)->result();
            //echo $allquesusers;
        }
 
        $this->data['doctors'] = $usercount;
    
       $this->data['question'] = $_POST['question'];
        $this->data['territory'] = $_POST['territory'];
        $this->data['specialty'] = $_POST['specialty'];
        $this->data['datefrom'] = $_POST['datefrom'];
        $this->data['dateto'] = $_POST['dateto'];
        
        
        $this->data['title'] = "Questions subscribed Repot";
    
        // $this->data['daterange'] = $_POST['daterange'];
        $this->data['page'] = "/admin/users/docreport";
        $this->load->view("/admin/layout", $this->data);
    }
    public function printdocreport(){
        if ($this->input->post("dateto")) {
            $to=date('Y-m-d 00:00:00', strtotime($this->input->post("dateto")));
        }else{
            $to= date("Y-m-d H:i:s");
        }
        
        if ($this->input->post("datefrom")) {
            $from=date('Y-m-d 00:00:00', strtotime($this->input->post("datefrom")));
        }else{
            $from= '00-00-00 00:00:00';
        }
        
        $where[] =' creation_date >= \''.$from.'\'';
        $where[] =' creation_date <= \''.$to.'\'';
        if ($_POST['territory']){
            $where[] =' doctors.territory='.$_POST['territory'];
        }
         
        if ($_POST['specialty']){
            $where[] =' doctors.specialty='.$_POST['specialty'];
        }
        
        
        if(!empty($where)){
            $where = ' WHERE '.implode(' AND ', $where);
        }else{
            $where = '';
        }
         
         
        if ($_POST['question']){
            $sqlq='SELECT * FROM questions WHERE id='.$_POST['question'];
            $questiontext = $this->db->query($sqlq)->result();
            $this->data['questiontext'] = $questiontext[0]->question;
            //if ($_POST['territory']){
            $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' AND user_answers.question_id='.$_POST['question'].' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
            /* }else{
             $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
             INNER JOIN territory ON territory.id=doctors.territory
             INNER JOIN specialty ON specialty.id=doctors.specialty
             WHERE user_answers.question_id='.$_POST['question'].' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
             }
             */
            //echo $sql."<br />";
            $usercount= $this->db->query($sql)->result();
        
        }else{
            $this->data['questiontext'] = "All Questions";
            /*
            $sql='SELECT user_answers.user_id, COUNT(*) as mycount FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id WHERE user_answers.question_id=1 OR user_answers.question_id=2 OR user_answers.question_id=3 GROUP BY user_answers.user_id';
            //echo $sql."<br />";
            $usercount1= $this->db->query($sql)->result();
            $allquesusers="";
            foreach($usercount1 as $k=> $user){
                if ($user->mycount==3){
                    $allquesusers.=$user->user_id.", ";
                }
            }
            $allquesusers=trim($allquesusers,", ");
            $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' AND doctors.id IN ('.$allquesusers.') ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
           */
            $sql='SELECT  DISTINCT doctors.id,doctors.first_name,doctors.last_name,territory.territory,specialty.specialty FROM user_answers INNER JOIN doctors ON user_answers.user_id=doctors.id
                     INNER JOIN territory ON territory.id=doctors.territory
                    INNER JOIN specialty ON specialty.id=doctors.specialty
                    '.$where.' ORDER BY territory.territory,specialty.specialty,doctors.first_name,doctors.last_name ';
            //echo $sql."<br />";
            $usercount= $this->db->query($sql)->result();
            //echo $allquesusers;
        }         
    
        $fp = fopen(FCPATH.'uploaded/docreport.csv', 'w');
        fputs($fp,b"\xEF\xBB\xBF");//write utf-8 BOM to file
        fputcsv($fp, array("Territory","Specialty","Name"));
        foreach ($usercount as $doctor) {  //echo $key.$val;
            fputcsv($fp, array($doctor->territory,$doctor->specialty,$doctor->first_name . ' '. $doctor->last_name));
        }
        fclose($fp);
    
        redirect(base_url().'uploaded/docreport.csv');
    }

    
}