<?php defined('BASEPATH') or exit('No direct script access allowed');

class Produk extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->library('Blob');
		$this->load->model('model_produk');
	}

	public function index()
	{
		$data['pageTitle'] = 'Kategori';
		
		$data['pageContent'] = $this->load->view('produk/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_produk();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('produk');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('produk/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Kategori';
		$data['kategori'] = $this->db->get('kategori')->result();
		$data['pageContent'] = $this->load->view('produk/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_produk('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('produk');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('produk/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('produk', ['id_produk' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('produk');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('produk/edit/' . $id);
		}
		
		$data['pageTitle'] = 'Edit Kategori';
		$data['produk'] = $this->db->get_where('produk', ['id_produk' => $id])->row();
		$data['kategori'] = $this->db->get('kategori')->result();
		$data['pageContent'] = $this->load->view('produk/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_produk($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$upload = $this->blob->upload_img();

		$data = array(
			'id_kategori' => $input_post['id_kategori'],
			'nama_produk' => $input_post['nama_produk'],
			'qty'         => $input_post['qty'],
			'satuan'      => $input_post['satuan'],
		);

		if ($type == 'update') {
			$produk_lama = $this->db->get_where('produk', ['id_produk' => $id])->row_array();
			$gambar_lama = $produk_lama['gambar'] ?? '';
		}

		if (!empty($upload) && !empty($upload['nama_file'])) {
			$data['gambar'] = $upload['nama_file'];
		} else {
			if ($type == 'update') {
				$data['gambar'] = $gambar_lama;
			}
		}

		$return = false;
		if ($type == 'insert') {
			$return = $this->db->insert('produk', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('produk', $data, ['id_produk' => $id]);
		}

		return $return;
	}

	public function get_data()
	{
		$data = $this->model_produk->get_all();
		echo json_encode($data);
	}
}