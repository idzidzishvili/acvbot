<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller {
	public $data = array();

	public function __construct() {
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper("security");
		$this->load->model('user');
	}

	public function login() {
		if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'required');
         
			if ($this->form_validation->run()) {
				$userdata = $this->user->getUserByUsername($this->input->post('username'));
            
				if (!$userdata) {
					//username does not exist
					$this->session->set_flashdata('loginResult', array('status' => false, 'message' => 'Invalid username/password'));
					return redirect('auth/login');
				}
            
				if ($userdata && password_verify($this->input->post('password'), $userdata->password)) {
					$sessiondata = array(
						'userId' => $userdata->id,
						'username' => $userdata->username,
						'loggedin' => TRUE,
					);
					$this->session->set_userdata($sessiondata);
				} else {
					$this->session->set_flashdata('loginResult', array('status' => false, 'message' => 'Invalid username/password'));
					return redirect('/auth/login');
				}
			} else {
				//validation not passed
				// $this->session->set_flashdata('loginResult', array('status' => false, 'message' => 'Invalid username/password'));
				// return redirect('/auth/login');
            echo validation_errors();exit;
			}
		}
		if ($this->session->userdata('loggedin')) {
			redirect('/home/index');
		}

		$this->load->view('login', $this->data);
	}

   
}
