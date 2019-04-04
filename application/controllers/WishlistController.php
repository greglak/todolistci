<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WishlistController extends CI_Controller 
{
	function __construct() 
	{
		parent::__construct();
		// Load session library and encryption for sharing list
		$this->load->library('session');
		$this->load->library('encrypt');
		// Load model used by the controller
		$this->load->model('WishlistModel');
	}

	public function index()
	{
        //main view on load for controller
        $this->load->view('view'); 
    }
    
    //function loads view for adminlogin
	public function login()  
    {  
        $this->load->view('view'); 
    }

    //test view for view only to display lists
    public function reverse()
    {
        $this->load->view('reverse');
    }

	//function checks whether the user has been authenticated and either logs you in if session "currently_logged_in" matches it loads the index view of main  page
	//otherwise the user is redirected to the function invalid
    public function mainpage()  
    {  
        //$userlogcheck = $_SESSION['loginsession']['currently_logged_in'];
        if ($this->session->userdata('loginsession'))   
        {  
            $celebs = $this->WishlistModel->getWishlistbyUserId();	
            $this->load->view('main', array('celebs' => $celebs));                       
        } else {  
            redirect('WishlistController/invalid');  
        }  
    }  

	//Function displays invalid attempt to use the system, only allow users to attempt a new login
    public function invalid()  
    {  
        $this->load->view('invalid');  
    }  

	//With the help of the codeigniter helper and form validation library, the are rules for validating the use
    public function login_action()  
    {  
        $this->load->helper('security');  
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('username', 'Username:', 'required|trim|xss_clean|callback_validation');  
        $this->form_validation->set_rules('password', 'Password:', 'required|trim');  
		
		//logical block check if validation form has been checked, and if true, allocates  it a session according to the username,
        //redirects to the main admin page
		if ($this->form_validation->run())   
        {  
            $this->session->unset_userdata('registrationsession');
            $id = $_SESSION['userId'];

            if($this->WishlistModel->checkList($id))
            {
                $data = array('userId' => $id, 'username' => $this->input->post('username'), 'currently_logged_in' => 1);    	
                $this->session->set_userdata('loginsession', $data);
                $this->session->unset_userdata('userId');
                redirect('WishlistController/mainpage');
            }
            else
            {
                $message['errors'] = "Let's first add a list Simon:)";
                $check['listcheck'] = "true";
                $this->load->view('view', $message + $check);
            }

		}
		//if the statement is false the user is redirected to the login page again
        else {  
            $data['form1_errors'] = validation_errors();
            $this->load->view('view', $data);  
        }  
	}  

	public function registration_action()  
    {  
        $this->load->helper('security');  
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('registrationUsername', 'Username:', 'required|trim|min_length[5]|max_length[12]|xss_clean|callback_registrationValidation');  
        $this->form_validation->set_rules('password', 'Password:', 'required|trim');
		//logical block check if validation form has been checked, and if true, allocates  it a session according to the username,
		//redirects to the main admin page
		if ($this->form_validation->run() == FALSE)   
        {   
            $data['form2_errors'] = validation_errors();
            $this->load->view('view', $data);
		}
		//if the statement is false the user is redirected to the login page again
        else 
        {
            $username = $this->input->post('registrationUsername');
            $password = $this->input->post('password');
            $insertUserData = $this->WishlistModel->addUser($username, $password);
            $success = array('userId' => $insertUserData, 'username' => $username, 'successreg' => 1);    	
			$this->session->set_userdata('registrationsession', $success); 
            $message['form2_errors'] = "Successful Registration mate!";
            $check['success_msg'] = "Success";
            $this->load->view('view', $message + $check);          
        }  
	} 

	//function designate to talk with the database to verify user credentials
	//if the user matches it becomes true, otherwise it will display a warning message.
    public function validation()  
    {  
        $userId = $this->WishlistModel->log_in_correctly();
        if (!empty($userId)) 
        {  
            $_SESSION['userId'] = $userId;
            return true;
            // return $userId;  
        } else {  
            $data['form1_errors'] = $this->form_validation->set_message('validation', 'Incorrect username/password');  
            return false;  
        }  
	}  

    //validation callback on registration to check unique usernames
	public function registrationValidation()  
    {  
        if ($this->WishlistModel->usernameCheck())  
        {  
			$this->form_validation->set_message('registrationValidation', 'Username is already in use'); 
            return false;  
        } else {    
            return true;  
        }  
    } 
    
    //addlist action from adding list after successful registration
    public function addList()
    {
        $this->load->helper('security');  
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('listname', 'Listname:', 'required|trim|xss_clean');  
        $this->form_validation->set_rules('description', 'Description:', 'required|trim');
		//logical block check if validation form has been checked, and if true, allocates  it a session according to the username,
		//redirects to the main admin page
		if ($this->form_validation->run() == FALSE)   
        {   
            $data['form2_errors'] = validation_errors();
            
		}
        else { 
            $listname = $this->input->post('listname');
            $description = $this->input->post('description');
            $userId = $_SESSION['registrationsession']['userId'];        
            $addsomething = $this->WishlistModel->addList($listname, $description, $userId);
            $this->load->view('view');
        }  
    }
    //addlist action from adding list if user does not add it after registration so upon login if user has not list assigned
    public function addListById()
    {
        $this->load->helper('security');  
        $this->load->library('form_validation');  
        $this->form_validation->set_rules('listname', 'Listname:', 'required|trim|xss_clean');  
        $this->form_validation->set_rules('description', 'Description:', 'required|trim');
		//logical block check if validation form has been checked, and if true, allocates  it a session according to the username,
		//redirects to the main admin page
		if ($this->form_validation->run() == FALSE)   
        {   
            $data['form2_errors'] = validation_errors();           
		}
		//if the statement is false the user is redirected to the login page again
        else { 
            $listname = $this->input->post('listname');
            $description = $this->input->post('description');
            $userId = $_SESSION['userId'];     
            $addsomething = $this->WishlistModel->addList($listname, $description, $userId);
            $username = $this->WishlistModel->retrieveUsername($userId);
            $data = array('userId' => $userId, 'username' => $username, 'currently_logged_in' => 1);    	
            $this->session->set_userdata('loginsession', $data);
            $this->session->unset_userdata('userId');
            redirect('WishlistController/mainpage');
        }  
    }

	//The function usets the session that has the login information
    public function logout()  
    {  
        $this->session->unset_userdata('loginsession');     
        redirect('WishlistController/login');  
    }  
    
}
