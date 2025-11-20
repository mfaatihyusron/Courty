<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class praktek extends CI_Controller {
	public function index()
	{
		$data['content'] = "index"; 
		$this->load->view('template', $data);
	}

	public function formvalidasi()
	{
		$data['content'] = "formvalidasi"; 
		$this->load->view('template', $data);
	}
	
} 