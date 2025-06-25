<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function login()
	{
		$data['pageTitle'] = 'Login';
		$data['pageContent'] = $this->load->view('auth/login', $data, TRUE);
    	$this->load->view('template/default/content', $data);
	}
	
	public function cekLogin()
	{
		if ($this->session->userdata('logged_in')) redirect('Dashboard');
		if ($this->input->post('login')) {
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required|callback_cekAkun');
			$this->form_validation->set_message('required', '%s tidak boleh kosong!');
			if ($this->form_validation->run() === TRUE) {
				$message = array('status' => true, 'message' => 'SELAMAT DATANG DI APLIKASI ....');
				$this->session->set_flashdata('message', $message);
				// if($this->session->userdata('role') == 'admin'){
					redirect('dashboard', 'refresh');
				// }else{
				// 	redirect('home', 'refresh');
				// }
			}
		}

	}

	public function cekAkun()
	{
		$this->load->model('model_users');
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$query = $this->model_users->cekAkun($username, $password);
		if (!$query) {
			$message = 'Username atau Password yang Anda masukkan salah!';
			$this->session->set_flashdata('error', $message);
			redirect('auth/login');
			return FALSE;
		} else {
			$userData = array(
				'id_user' => $query->id_user,
				'nama' => $query->nama_user,
				'username' => $query->username,
				'role' => $query->role,
				'logged_in' => TRUE
			);
			$this->session->set_userdata($userData);

			return TRUE;
		}
	}

	public function daftar()
	{
		$data['pageTitle'] = 'Daftar Akun';
		$data['pageContent'] = $this->load->view('auth/daftar', $data, TRUE);
    	$this->load->view('template/default/content', $data);
	}
	
	public function create()
	{
		if (isset($_POST['save'])) {
			$insert_id = $this->save_daftar();
			if ($insert_id) {
				if ($insert_id) {
					$this->session->set_flashdata('success', 'Akun berhasil dibuat.');
					redirect('auth/daftar');
				} else {
					$this->session->set_flashdata('error', 'Terjadi kesalahan saat membuat akun.');
					redirect('auth/daftar');
				}
			}
		}
	}

	private function save_daftar()
	{
		$post = $this->input->post();
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('password_confirm', 'Konfirmasi Password', 'required|matches[password]');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect('auth/daftar');
		}
		$post['password'] = password_hash($post['password'], PASSWORD_BCRYPT);
		$post['role'] = 'user';
		unset($post['password_confirm'], $post['save']);
		return $this->db->insert('users', $post);
	}

	public function logout()
	{
	  $this->session->sess_destroy();
  
	  redirect('auth/login');
	}
}
