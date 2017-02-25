<?php

class Users_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /* loginEmail
     * email, password
     * checking to login using email and password */
    function loginEmail($email, $password) {
        $this -> db -> where("email", strtolower($email));
        $this -> db -> where("password", md5($password));
        $this -> db -> where("active", '1');
        // 1:Approved - 0:Pending
        $query = $this -> db -> get("users");
        return $query -> result_array();
    }
	function updatecoins($id) {
        $data = array('forcoins' => '0');
        $this -> db -> where("id", $id);
        return $this -> db -> update('users', $data);
        //return $this -> db -> insert_id();
    }

    function getUserProfile($userid) {
        $this -> db -> where("id", $userid);
        $query = $this -> db -> get("users");
        return $query -> result_array();
    }

    /*
     * checkEmail
     * email
     * cheching the email exist of not and change password
     */
    function checkEmail($email) {
        $this -> db -> where("email", strtolower($email));
		//$this -> db -> where("active", '1');		
        $query = $this -> db -> get("users"); 
        $userdata=$query -> result_array();
       
        if ($query -> num_rows() > 0) { 
            if ($userdata[0]['active']==0) {
              return 'notactive';
            }else{        
                $this -> db -> where("email", strtolower($email));
                $pass = substr(md5(uniqid(mt_rand(), true)), 0, 12);
                $data = array('password' => md5($pass));
                $this -> db -> update('users', $data);
                return $pass;
            }
        } else {
            return false;
        }        
    }

    function checkEmailExistInUser($email) {
        $this -> db -> where("email", strtolower($email));
        $query = $this -> db -> get("users");
        if ($query -> num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    
    function checkEmailExistInStoredMails($email) {
        $this -> db -> where("email", strtolower($email));
        $query = $this -> db -> get("stored_mails");
        if ($query -> num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }
    /*
    function getsaveddomains() {
        $this->db->select('domain');
        $query = $this -> db -> get("saved_domain");
        return $query -> result_array();
    
    }
    */
    /**
     * registerNew
     * $fname, $lname, $email, $password, $dob_m, $dob_d, $dob_y, $gender, $country
     */
    function registerNew($fname, $lname, $email, $password, $dob_m, $dob_d, $dob_y, $gender, $country, $active) {
        $data = array('fname' => $fname, 'lname' => $lname, 'email' => strtolower($email), 'password' => md5($password), 'dob_d' => $dob_d, 'dob_m' => $dob_m, 'dob_year' => $dob_y, 'gender' => $gender, 'country_id' => $country, 'active' => $active);
        $this -> db -> insert('users', $data);
        return $this -> db -> insert_id();
    }

    function updateProfile($id, $fname, $lname, $dob_m, $dob_d, $dob_y, $gender) {
        $data = array('fname' => $fname, 'lname' => $lname, 'dob_d' => $dob_d, 'dob_m' => $dob_m, 'dob_year' => $dob_y, 'gender' => $gender);
        $this -> db -> where("id", $id);
        return $this -> db -> update('users', $data);
        //return $this -> db -> insert_id();
    }

    function deleteProfile($id) {
        // DELETE the user
        $this -> db -> where("id", $id);
        return $this -> db -> delete('users');
    }

    function changePassword($id, $newPassword) {
        $data = array('password' => md5($newPassword));
        $this -> db -> where("id", $id);
        return $this -> db -> update('users', $data);
    }

    /**
     * saveAvatarByID
     * $id , $filename
     */
    function saveAvatarByID($id, $filename) {
        $this -> db -> where("id", $id);
        $data = array('avatar' => $filename);
        if ($this -> db -> update('users', $data))
            return true;

    }
    function last_login($id) {
        $this -> db -> where("id", $id);
        $data = array('login_date' => date("Y-m-d H:i:s"));
        if ($this -> db -> update('users', $data))
            return true;
    
    }

function saveCoverByID($id, $filename) {
        $this -> db -> where("id", $id);
        $data = array('cover' => $filename);
        if ($this -> db -> update('users', $data))
            return true;
    }
function getcountryList() {
        $query = $this -> db -> get("countries");
        return $query -> result_array();
        
    }
    
function getcountryDetail($id) {
        $this -> db -> where("id", $id);
        $query = $this -> db -> get("countries");
        return $query -> result_array();
    }

}
