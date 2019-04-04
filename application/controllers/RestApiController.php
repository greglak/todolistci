<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class RestApiController extends REST_Controller 
{
	function __construct() 
	{
		parent::__construct();
		// Load session library
		$this->load->library('session');
		$this->load->library('encrypt');
		// Load model used by the controller
		$this->load->model('WishlistModel');
	}

	//index load
	public function index_get()
	{	
		$celebs = $this->WishlistModel->getWishlistbyUserId();	
		$this->load->view('main', array('celebs' => $celebs));
    }
	
	//saving into celeb
	public function celeb_post()
    {
		$data = $this->decode_data($this->input->raw_input_stream);
		$name = $data['name'];
		// if (!preg_match("/^https|ftp):/", $data['url'])) {
		// 	$data['url'] = 'https://'.$data['url'];
		// }
		//$url = $_POST['url'];
		$url = $data['url'];
		$price = $data['price'];
		$priority = $data['type'];
		$userId = $_SESSION['loginsession']['userId'];
		
		$celeb = $this->WishlistModel->add($name,$url,$price,$priority,$userId);
		echo json_encode($celeb);
	}

	//update into celeb
	public function celeb_put()
    {
		$data = $this->decode_data($this->input->raw_input_stream);
		$itemId = $data['itemId'];
		$name = $data['name'];
		$url = $data['url'];
		$price = $data['price'];
		$priority = $data['type'];
		$userId = $_SESSION['loginsession']['userId'];		
		$celeb = $this->WishlistModel->updateItem($itemId,$name,$url,$price,$priority,$userId);
		echo json_encode($celeb);		
	}

	//getting the list
	public function celeb_get()
	{		
		$celebs = $this->WishlistModel->getWishlistbyUserId();
		echo json_encode($celebs);
	}

	//deleting from the list
	public function celeb_delete()
	{
		$data = $this->decode_data($this->input->raw_input_stream);
		$id = $this->uri->segment(3); 
		$result =  $this->WishlistModel->deleteItem($id);
		//echo json_encode($result);
		$this->response(array('celebs' => $id,'status' => 200));
	}

	//hotwire posting with delete
	public function dummy_post()
	{
		$data = $this->decode_data($this->input->raw_input_stream);
		$id = $data['itemId'];
		$this->WishlistModel->deleteItem($id);
		
		$this->response(array('celebs' => $id,'status' => 200));
	}

	//decoding json data
	private function decode_data($data)
	{
		$d = $this->security->xss_clean($data);
		$request = json_decode($d,true);
		return $request;
	}
		
	//create wishlist for userid with urlencode
	public function shareListModel_post()
	{
		$encodingId = $_SESSION['loginsession']['userId'];
        $encryptcode = urlencode($this->encrypt->encode($encodingId));      
		$url = "URL_SAMPLE/index.php/RestApiController/sharedlist/?share=".$encryptcode;
		$reply = "Share link has been generated mate";
		$this->response(array('url' => $url,'message' => $reply, 'status' => 200));
	}

	//get userinfo and items from list and display them in new view
	public function sharedList_get()
	{	
		$userId = $this->encrypt->decode(rawurldecode($_GET['share']));	
		$listinfo = $this->WishlistModel->getListInfo($userId);
		$username =$this->WishlistModel->getListOwner($userId);
		$listitems = $this->WishlistModel->getItemsForSharedList($userId);
		$this->load->view('sharing', array ('listname' => $listinfo['name'],'listdescription' => $listinfo['description'],'username' => $username['username'],'listitems' => $listitems));
	}
    
}
