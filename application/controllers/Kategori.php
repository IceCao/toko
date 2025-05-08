<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kategori extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_kategori');
	}

	public function index()
	{
		$data['pageTitle'] = 'Kategori';
		
		$data['pageContent'] = $this->load->view('kategori/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_kategori();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('kategori');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('kategori/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Kategori';
		$data['pageContent'] = $this->load->view('kategori/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_kategori('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('kategori');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('kategori/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('kategori', ['id_kategori' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('kategori');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('kategori/edit/' . $id);
		}
		$data['pageTitle'] = 'Edit Kategori';
		$data['kategori'] = $this->db->get_where('kategori', ['id_kategori' => $id])->row();
		$data['pageContent'] = $this->load->view('kategori/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_kategori($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$data = array(
			'nama_kategori' => $input_post['nama_kategori'],
		);

		$return = false;
		if ($type == 'insert') {
			$id = $this->db->insert('kategori', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('kategori', $data, ['id_kategori' => $id]);
		}
		
		return $id;
	}

	public function get_data()
	{
		$data = $this->model_kategori->get_all();
		echo json_encode($data);
	}
}