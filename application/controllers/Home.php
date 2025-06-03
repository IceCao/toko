<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
		$data['pageTitle'] = 'Home';
		$data['pageContent'] = $this->load->view('home/index', $data, TRUE);
    	$this->load->view('template/default/content', $data);
	}

	public function keranjang()
	{
		$data['pageTitle'] = 'Cart';
		$data['pageContent'] = $this->load->view('home/keranjang', $data, TRUE);
    	$this->load->view('template/default/content', $data);
	}
}
