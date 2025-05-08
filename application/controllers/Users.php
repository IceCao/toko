<?php defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_users');
	}

	public function index()
	{
		$data['pageTitle'] = 'Users';
		
		$data['pageContent'] = $this->load->view('users/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_users();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('users');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('users/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Users';
		$data['pageContent'] = $this->load->view('users/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_users('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('users');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('users/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('users', ['id_user' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('users');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('users/edit/' . $id);
		}
		$data['pageTitle'] = 'Edit Users';
		$data['users'] = $this->db->get_where('users', ['id_user' => $id])->row();
		$data['pageContent'] = $this->load->view('users/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_users($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$data = array(
			'nama_user' => $input_post['nama_user'],
			'username' => $input_post['username'],
			'role' => $input_post['role'],
		);
		if(!empty($input_post['password']) && !empty($input_post['password_confirm'])) {
			if ($input_post['password'] == $input_post['password_confirm']) {
				$data['password'] = password_hash($input_post['password'], PASSWORD_BCRYPT);
			} else {
				$this->session->set_flashdata('error', 'Password tidak sama');
				redirect($this->uri->uri_string());
			}
		}

		$return = false;
		if ($type == 'insert') {
			$id = $this->db->insert('users', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('users', $data, ['id_user' => $id]);
		}
		
		return $id;
	}

	public function get_data()
	{
		$data = $this->model_users->get_all();
		echo json_encode($data);
	}
}