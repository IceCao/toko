<?php defined('BASEPATH') or exit('No direct script access allowed');

class Subkategori extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->library('Blob');
		$this->load->model('model_subkategori');
	}

	public function index()
	{
		$data['pageTitle'] = 'Kategori';
		
		$data['pageContent'] = $this->load->view('subkategori/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_subkategori();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('subkategori');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('subkategori/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Kategori';
		$data['kategori'] = $this->db->get('kategori')->result();
		$data['pageContent'] = $this->load->view('subkategori/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_subkategori('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('subkategori');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('subkategori/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('sub_kategori', ['id_sub_kategori' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('subkategori');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('subkategori/edit/' . $id);
		}
		
		$data['pageTitle'] = 'Edit Kategori';
		$data['subkategori'] = $this->db->get_where('sub_kategori', ['id_sub_kategori' => $id])->row();
		$data['kategori'] = $this->db->get('kategori')->result();
		$data['pageContent'] = $this->load->view('subkategori/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_subkategori($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		// $upload = $this->blob->upload_img();

		$data = array(
			'id_kategori' => $input_post['id_kategori'],
			'sub_kategori' => $input_post['sub_kategori'],
		);

		// if ($type == 'update') {
		// 	$subkategori_lama = $this->db->get_where('subkategori', ['id_sub_kategori' => $id])->row_array();
		// 	$gambar_lama = $subkategori_lama['gambar'] ?? '';
		// }

		// if (!empty($upload) && !empty($upload['nama_file'])) {
		// 	$data['gambar'] = $upload['nama_file'];
		// } else {
		// 	if ($type == 'update') {
		// 		$data['gambar'] = $gambar_lama;
		// 	}
		// }

		$return = false;
		if ($type == 'insert') {
			$return = $this->db->insert('sub_kategori', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('sub_kategori', $data, ['id_sub_kategori' => $id]);
		}

		return $return;
	}

	public function get_data()
	{
		$data = $this->model_subkategori->get_all();
		echo json_encode($data);
	}
}