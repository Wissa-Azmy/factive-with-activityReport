<?php

class Astragram_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }


    public function getTrends() {

       $q = $this -> db -> query("SELECT `hashtag` FROM `trends` where inhome=1 order by trend_id asc limit 5");
     
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	public function getcomp() {

       $q = $this -> db -> query("SELECT `hashtag`,`end_date` FROM `trends` where comp=1 order by trend_id desc limit 1");     
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }
	
	
	
	public function getcompresult($do) {	  
	//$getcomp = $this -> getcomp(); 
    //$rowm -> getcomp = $getcomp;	
	
	 $q = $this -> db -> query("SELECT posts.post_id,posts.user_id,posts.details,posts.image, COUNT(likes.likes_id) AS Field1 FROM posts 
	                               INNER JOIN likes
		                           WHERE posts.post_id=likes.post_id and posts.hashtag LIKE '%$do%'
                                   GROUP BY likes.post_id
		                           order by Field1 DESC limit 1");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
			    $personInf = $this -> getPersonPost($row -> post_id);
                $row -> persons = $personInf;			
				//$this -> insertnewcoins($row -> user_id,$do);
                
				$data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }

      
    }
	/*
	public function insertnewcoins($id,$do) {
	     
		$h="#".$do;
	    $qsm = $this -> db -> query("SELECT `hashtag`,`end_date` FROM `trends` where hashtag LIKE '%$h%'and comp=1 order by trend_id desc limit 1");
	    
		foreach ($qsm->result() as $rowmn) { 
		$endd=$rowmn->end_date;
		}
		
		$start = date('Y-m-d',strtotime("now"));
        $end = date('Y-m-d',$endd);
        $diff = (strtotime($end)- strtotime($start))/24/3600; 
		
		
        
		if ($diff == 0){
		$this -> db -> where("id", $id);
        $data = array('coins' => '+20');
        $this -> db -> update('users', $data);
            return true;
		}
		else { return false; }
        		
    }
*/
    public function insertAstra($astrawhat, $astraWho, $astraWhere) {
	  //Match the hashtags
  preg_match_all('/(^|[^a-z0-9_])#([a-z0-9_]+)/i', $astrawhat, $matchedHashtags);
  $hashtag = '';
  // For each hashtag, strip all characters but alpha numeric
  if(!empty($matchedHashtags[0])) {
	  foreach($matchedHashtags[0] as $match) {
		  $hashtag .= preg_replace("/[^a-z0-9]+/i", "", $match).',';
	  }
  }
   
        $hash= rtrim($hashtag, ',');
        $data = array('hashtag' => $hash, 'details' => $astrawhat, 'who' => $astraWho, 'where' => $astraWhere, 'user_id' => $this -> session -> userdata('userid'));
        $this -> db -> insert('posts', $data);
        return $this -> db -> insert_id();
    }

    public function deleteAstragram($id) {
        // DELETE the post
        $this -> db -> where("post_id", $id);
        return $this -> db -> delete('posts');
    }

    public function saveImageByID($id, $filename) {
        $this -> db -> where("post_id", $id);
        $data = array('image' => $filename);
        if ($this -> db -> update('posts', $data))
            return true;
    }

    /////////////////////////////////////////////////
    //Insert Comments///////////////////////////////
    public function insertComments($postId, $comment, $userid) {
        $data = array("text" => $comment, 'post_id' => $postId, 'user_id' => $this -> session -> userdata('userid'));
        $this -> db -> query("INSERT INTO comments(text, post_id, user_id) VALUES(
		                   '$comment', $postId, $userid
		                    )");
    }


    ///////////////////////////////////////////////
    //Get container data//////////////////////////

 public function getPosts($start = 0) {

        $this->db->order_by('post_id', 'desc');
        $q = $this->db->get('posts', 3, $start * 3);

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $comments = $this -> getComments($row -> post_id);
                $row -> comments = $comments;

                $personInf = $this -> getPersonPost($row -> post_id);
                $row -> persons = $personInf;
				
                //echo "<br>".$row -> post_id."<br>";
				$personInf2 = $this -> getPersonPost2($row -> post_id,$row -> who);
                $row -> persons2 = $personInf2;

                $likes = $this -> getLikes($row -> post_id);
                $row -> likes = $likes;
                $current_user_id = $this -> session -> userdata('userid');
                $row -> like_status = FALSE;
                if (!empty($likes)) {
                    foreach ($likes as $like) {
                        if ($current_user_id == $like -> user_id) {
                            $row -> like_status = TRUE;
                            break;
                        }
                    }
                }
                //$likes->uids
                //row->like_status = in_array($current->uid  , likes->uids);

                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }


    public function getPostsbyhash($hashstr,$start = 0) {

      $start=$start*3;

     if($start == 0)$limitstr="limit 3";
        else $limitstr="limit ".$start.",3";
      
      $q = $this -> db -> query("SELECT * FROM posts WHERE hashtag LIKE '%$hashstr%'   order by post_id desc ".$limitstr);
      
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $comments = $this -> getComments($row -> post_id);
                $row -> comments = $comments;

                $personInf = $this -> getPersonPost($row -> post_id);
                $row -> persons = $personInf;
				
				
				$personInf2 = $this -> getPersonPost2($row -> post_id,$row -> who);
                $row -> persons2 = $personInf2;

                $likes = $this -> getLikes($row -> post_id);
                $row -> likes = $likes;
                $current_user_id = $this -> session -> userdata('userid');
                $row -> like_status = FALSE;
                if (!empty($likes)) {
                    foreach ($likes as $like) {
                        if ($current_user_id == $like -> user_id) {
                            $row -> like_status = TRUE;
                            break;
                        }
                    }
                }
                //$likes->uids
                //row->like_status = in_array($current->uid  , likes->uids);

                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    ///////////////////////////////////////////////
    //getPostModel/////////////////////////////////
    public function getPostModel($postId) {
        $q = $this -> db -> query("SELECT * FROM posts WHERE post_id='" . $postId . "'");
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $comments = $this -> getCommentsModel($row -> post_id);
                $row -> comments = $comments;

                $likes = $this -> getLikesModel($row -> post_id);
                $row -> likes = $likes;
                $current_user_id = $this -> session -> userdata('userid');
                $row -> like_status = FALSE;
                if (!empty($likes)) {
                    foreach ($likes as $like) {
                        if ($current_user_id == $like -> user_id) {
                            $row -> like_status = TRUE;
                            break;
                        }
                    }
                }
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    ///////////////////////////////////////////////
    //Get comments////////////////////////////////
    public function getComments($post_id) {
        $q = $this -> db -> query("SELECT * FROM comments INNER JOIN users
		                           WHERE comments.post_id='" . $post_id . "'
		                           AND users.id = comments.user_id
		                           order by comments.comment_id DESC limit 0,3");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    /////////////////////////////////////
    //getCommentsModel////////////////////////////////
    public function getCommentsModel($post_id,$start = 0) {


      if($start == 0)$limitstr="limit 10";
      else $limitstr="limit ".$start.",10 ";

      $querystr="SELECT * FROM comments INNER JOIN users
                                   WHERE comments.post_id='" . $post_id . "'
                                   AND users.id = comments.user_id
                                   order by comments.comment_id DESC ".$limitstr;

        $q = $this -> db -> query($querystr);

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    //////////////////////////////////////////////////
    //getLikes///////////////////////////////////////
    public function getLikes($likes_id) {
        $q = $this -> db -> query("SELECT *,(
                                SELECT count( `likes_id` )
                                FROM likes
                                WHERE likes.post_id = '" . $likes_id . "'
                                ) AS count FROM likes INNER JOIN users
		                           WHERE likes.post_id='" . $likes_id . "'
		                           AND users.id = likes.user_id
		                           order by likes.likes_id DESC limit 0,3");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }


    ///////////////////////////////////////////////////
    //Get Liked IN Model////////////////////////////////
    public function getLikesModel($likes_id) {
        $q = $this -> db -> query("SELECT *,(

SELECT count( `likes_id` )
FROM likes
WHERE likes.post_id = '" . $likes_id . "'
) AS count FROM likes INNER JOIN users
		                           WHERE likes.post_id='" . $likes_id . "'
		                           AND users.id = likes.user_id
		                           order by likes.likes_id DESC limit 0,7");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    ////////////////////////////////////////////
    //insertLikes//////////////////////////////
    public function insertLike($postId, $userId) {
        $data = array("post_id" => $postId, 'user_id' => $this -> session -> userdata('$userid'));
        $this -> db -> query("INSERT INTO likes(post_id, user_id) VALUES(
		                      $postId, $userId
		                    )");
    }

    /////////////////////////////////////////////
    //dislikes/////////////////////////////////
    public function dislike($postId, $userId) {
        $data = array("post_id" => $postId, 'user_id' => $this -> session -> userdata('$userid'));
        $this -> db -> query("DELETE FROM likes WHERE post_id='" . $postId . "' AND user_id='" . $userId . "'");
    }


    ///////////////////////////////////////////
    //get_likes_tip///////////////////////////
    public function get_likes_tip($likes_id) {

        $q = $this -> db -> query("SELECT * FROM likes INNER JOIN users
		 WHERE likes.post_id='".$likes_id."' AND users.id = likes.user_id
		 ORDER BY likes.likes_id DESC ");
	
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            //$data = array_slice($data, 3);
            return $data;
        } else {
            return FALSE;
        }

    }

    ////////////////////////////////////////////////
    ///getPersonPost///////////////////////////////
    public function getPersonPost($post_id) {
        $q = $this -> db -> query("SELECT * FROM posts 
                                   INNER JOIN users
		                           WHERE posts.post_id = '" . $post_id . "'
		                           AND posts.user_id = users.id
		                           ");
        //print $q;
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }
	
	
	public function getPersonPost2($post_id,$who) {
    $mn=trim($who, ","); 
	$ds = explode(',', $mn);
	
	foreach ($ds as $d) {
			 $q = $this->db->query("SELECT * FROM posts 
			                       INNER JOIN users
		                           WHERE posts.post_id = '" . $post_id . "'
		                           AND users.id = '".$d."'");
       
        // echo $this->db->last_query();
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            $s=$data;
        } else {
            $s= FALSE;
        }
		}
		return $s;
		
    }

    /////////////////////////////////////////////////
    ///getUserProfile////////////////////////////////
    public function getUserProfile($userId) {
        $q = $this -> db -> query("SELECT * FROM posts INNER JOIN users
    	                            WHERE posts.user_id = '" . $userId . "'
    	                            AND posts.user_id = users.id
    	                            ORDER BY posts.post_id DESC");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                //$userImage = $this -> getUserProfileImage($row -> user_id);
                //$row -> userImage = $userImage;
                $personInf2 = $this -> getPersonPost2($row->post_id,$row->who);
                $row -> persons2 = $personInf2;
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    public function getUserpdf($userId) {
        $q = $this -> db -> query("SELECT * FROM posts INNER JOIN users
    	                            WHERE posts.user_id = '".$userId."'
    	                            AND posts.user_id = users.id AND filetype = 2
    	                            ORDER BY posts.post_id DESC");
    //echo $this->db->last_query();
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                //$userImage = $this -> getUserProfileImage($row -> user_id);
                //$row -> userImage = $userImage;
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }
    
    public function getUserphoto($userId) {
        $q = $this -> db -> query("SELECT * FROM posts INNER JOIN users
    	                            WHERE posts.user_id = '".$userId."'
    	                            AND posts.user_id = users.id AND filetype = 1
    	                            ORDER BY posts.post_id DESC");
        //echo $this->db->last_query();
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                //$userImage = $this -> getUserProfileImage($row -> user_id);
                //$row -> userImage = $userImage;
                $personInf2 = $this -> getPersonPost2($row -> post_id,$row -> who);
                $row -> persons2 = $personInf2;
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }
    
   /* public function getUserProfileImage($userId) {
        $q = $this -> db -> query("SELECT avatar FROM users where id='" . $userId . "'");
        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }*/

    ////////////////////////////////////////////////////
    ///old Search for posts////////////////////////////////////////////
    /*public function search($keyword) {
        $q = $this -> db -> query("SELECT * FROM posts
		                           WHERE posts.hashtag LIKE '%{$keyword}%'
		                          ");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            /*
             $row = new stdClass;
             $row->hashtag = "SELECT * FROM posts
             WHERE posts.hashtag LIKE '%{$keyword}%'
             ";
             $data[] = $row;
             return $data;*/
           /* return FALSE;
        }
    }*/
    
    public function search($keyword) {
        $q = $this -> db -> query("SELECT * FROM users
		                           WHERE users.fname LIKE '%{$keyword}%'
		                           OR users.lname LIKE '%{$keyword}%'
		                           AND users.active = 1
		                          ");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            /*
             $row = new stdClass;
             $row->hashtag = "SELECT * FROM posts
             WHERE posts.hashtag LIKE '%{$keyword}%'
             ";
             $data[] = $row;
             return $data;*/
            return FALSE;
        }
    }
	
	
	
	
	
	
	

    public function getSearchResult($postId) {
        $q = $this -> db -> query("SELECT * FROM posts WHERE post_id= '" . $postId . "'");

        if ($q -> num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        } else {
            return FALSE;
        }
    }
	
	public function delete_trend($id){
	    $this -> db -> where("comment_id", $id);
        return $this -> db -> delete('comments');
	}

}
?>
