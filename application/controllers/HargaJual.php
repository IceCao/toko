<?php defined('BASEPATH') or exit('No direct script access allowed');

class HargaJual extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_hargajual');
	}

	public function index()
	{
		$data['pageTitle'] = 'Setting harga jual';
		
		$data['pageContent'] = $this->load->view('hargajual/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_hargajual();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('hargajual');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('hargajual/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Setting harga jual';
		$data['pageContent'] = $this->load->view('hargajual/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_hargajual('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('hargajual');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('hargajual/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('hargajual', ['id_hargajual' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('hargajual');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('hargajual/edit/' . $id);
		}
		$data['pageTitle'] = 'Edit Setting harga jual';
		$data['hargajual'] = $this->db->get_where('hargajual', ['id_hargajual' => $id])->row();
		$data['pageContent'] = $this->load->view('hargajual/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_hargajual($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$data = array(
			'nama_hargajual' => $input_post['nama_hargajual'],
		);

		$return = false;
		if ($type == 'insert') {
			$id = $this->db->insert('hargajual', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('hargajual', $data, ['id_hargajual' => $id]);
		}
		
		return $id;
	}

	public function get_data()
	{
		$data = $this->model_hargajual->get_all();
		echo json_encode($data);
	}

	public function update_hargajual($kategori, $kategori_sub)
	{
		$post = $this->input->post();
		$data = [
			'harga_jual' => $post['harga'],
		];
		$cek = $this->db->get_where('harga_jual', ['id_kategori' => $kategori, 'id_sub_kategori' => $kategori_sub])->num_rows();

		if($cek == 0){
			$data['id_kategori'] = $kategori;
			$data['id_sub_kategori'] = $kategori_sub;
			$return['success'] = $this->db->insert('harga_jual', $data);
		}else{
			$return['success'] = $this->db->update('harga_jual', $data, ['id_kategori' => $kategori, 'id_sub_kategori' => $kategori_sub]);
		}
		if (!$return['success']) {
			$return['message'] = 'Terjadi kesalahan saat merubah data.';
		}

		echo json_encode($return);
	}
}