<?php

class WishlistModel extends CI_Model 
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //this verifies the submitted credentials with the ones from the database
    public function log_in_correctly() 
    {  
        $this->db->where('username', $this->input->post('username'));   
        $password = $this->input->post('password');      
        $result = $this->getUsers($password);
        if (!empty($result)) {         
            return $result;
        } else {
            return null;
        }
    }
    //give the back username for login
    public function retrieveUsername($userId)
    {
        $query = $this->db->query("SELECT username FROM wishlistUsers WHERE userId=$userId");
        $result = $query->row_array();
        return $result['username'];
    }

    //check hashing for login validation
    function getUsers($password) {
        $query = $this->db->get('wishlistUsers');
    
        if ($query->num_rows() == 1) {
            $result = $query->row_array();  
            if (password_verify($password, $result['password'])) {
                //We're good
                return $result['userId'];
            } else {
                //Wrong password
                return array();
            }   
        } else {
            return array();
        }
    }

    //checks unique username on registration
    public function usernameCheck() 
    {  
        $this->db->where('username', $this->input->post('registrationUsername')); 
	    $query = $this->db->get('wishlistUsers');
        
        if($query->num_rows() == 1 )
        { 
            return true; 
        }else 
        {
            return false; 
        }
    }

    //checks if user already has name and list description after registration
    public function checkList($userid)
    {
        $this->db->where('userid', $userid);
        $query = $this->db->get('wishlists');

        if($query->num_rows() == 1)
        { 
            return true; 
        }else 
        {
            return false; 
        }
    }

    // adds new user of db with hashing
    public function addUser($username, $password)
    {
        $newPassword = password_hash($password,PASSWORD_DEFAULT);
        $query="insert into wishlistUsers values('', '$username', '$newPassword')";
        $this->db->query($query);  
        return $this->db->insert_id();      
    }

    // add new list to db with listname and description
    public function addList($listname, $description, $userId) 
    {
        $query="insert into wishlists values('', '$listname', '$description', '$userId')";
        $this->db->query($query);  
    }
    
    // to get wishlist items assigned to an usedid
    public function getWishlistbyUserId()
    {
        $userId = $_SESSION['loginsession']['userId'];
        $res = $this->db->query("SELECT * FROM wishlistItems WHERE wishlistId IN (SELECT wishlistId FROM wishlists WHERE userId=$userId) ORDER BY FIELD(type, 'High','Medium','Low')");
		return $res->result_array();
    }
    
    //add to wishlist according to userid
	public function add($n,$i,$p,$pr,$ui)
	{   
        $this->db->query("INSERT INTO wishlistItems(name, url, price, type, wishlistId) VALUES ('$n', '$i', '$p', '$pr', (SELECT wishlistId FROM wishlists WHERE userId=$ui))");
        $id = $this->db->insert_id();
		$res = $this->db->get_where('wishlistItems',array('itemId' => $id));
		return $res->row_array();
    }
    
    //gets sharedlist of specific userid
    public function getItemsForSharedList($userId)
	{   
        $res = $this->db->query("SELECT * FROM wishlistItems WHERE wishlistId IN (SELECT wishlistId FROM wishlists WHERE userId=$userId) ORDER BY FIELD(type, 'High','Medium','Low')");
        $data = $res->result();
		return $data;
    }
    
    //gets wishlist info for shared list
    public function getListInfo($userId)
	{
        $res = $this->db->query("SELECT * FROM wishlists WHERE userId=$userId");
        $data = $res->row_array();
		return $data;
    }

    //gets owner of sharedlist
    public function getListOwner($userId)
	{
        $res = $this->db->query("SELECT username FROM wishlistUsers WHERE userId=$userId");
        $data = $res->row_array();
		return $data;
	}
    
    //deletes item by itemid
    public function deleteItem($itemId)
	{
        $this->db->query("DELETE FROM wishlistItems WHERE itemId=$itemId");
    }
    
    //updates item by save on frontend
    public function updateItem($itemId, $name, $url, $price, $type)
	{
       // $this->db->query("UPDATE wishlistItems SET name = $name, url = $url, price = $price, type = $type WHERE itemId = $itemId");
        $this->db->where('itemId', $itemId);
        $task = array('name' => $name, 'url' => $url, 'price' => $price,'type' => $type);
		$this->db->update('wishlistItems', $task);
	}


}