<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->library('Blob');
		$this->load->model('model_pembelian');
	}

	public function index()
	{
		$data['pageTitle'] = 'Pembelian';
		
		$data['pageContent'] = $this->load->view('pembelian/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_pembelian();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('pembelian');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('pembelian/edit/' . $id);
			}
		}

		$gudang = $this->db->get('gudang')->result();
		$kategori = $this->db->get('kategori')->result();
		$sub_kategori = $this->db->get_where('sub_kategori', ['id_kategori' => $kategori[0]->id_kategori])->result();

		$data['pageTitle'] = 'Tambah Pembelian';
		$data['gudang'] = $gudang;
		$data['kategori'] = $kategori;
		$data['sub_kategori'] = $sub_kategori;
		$data['pageContent'] = $this->load->view('pembelian/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_pembelian('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('pembelian');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('pembelian/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('pembelian', ['id_pembelian' => $id])) {
				$this->db->delete('barang_masuk', ['id_pembelian' => $id]);
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('pembelian');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('pembelian/edit/' . $id);
		}

		$pembelian = $this->model_pembelian->find($id)->row();
		$gudang = $this->db->get('gudang')->result();
		$kategori = $this->db->get('kategori')->result();
		$sub_kategori = $this->db->get_where('sub_kategori', ['id_kategori' => $pembelian->id_kategori])->result();

		$data['pageTitle'] = 'Edit Pembelian';
		$data['pembelian'] = $pembelian;
		$data['gudang'] = $gudang;
		$data['kategori'] = $kategori;
		$data['sub_kategori'] = $sub_kategori;
		$data['attachments'] = explode(',', $pembelian->file_code);
		$data['pageContent'] = $this->load->view('pembelian/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_pembelian($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$upload = $this->blob->upload_img();
		
		if($upload['status'] == 'error'){
			$this->session->set_flashdata('error', $upload['message']);
			redirect('pembelian');
		}
		
		$file_code_lama = '';
		if(!empty($this->input->post('file_code_lama'))){
			$file_code_lama = $this->input->post('file_code_lama');
		}
		$file_code = !empty($upload['files']) ? $upload['files'] : $file_code_lama;

		$data = array(
			'desc' => $input_post['desc'],
			'harga' => $input_post['harga'],
			'stok' => $input_post['stok'],
			'id_user' => $this->session->userdata('id_user'),
			'file_code' => $file_code,
			'tgl_buat' => date('Y-m-d H:i:s'),
			'tgl_beli' => date("Y-m-d", strtotime($input_post['tgl_awal'])),
			'total_harga' => ($input_post['harga'] * $input_post['stok']),
		);

		$return = false;
		if ($type == 'insert') {
			$this->db->insert('pembelian', $data);
			$id = $this->db->insert_id();
			if(is_numeric($id)){
				$this->save_item($id);
			}
		} elseif ($type == 'update') {
			$this->db->update('pembelian', $data, ['id_pembelian' => $id]);
			if(is_numeric($id)){
				$this->save_item($id);
			}
		}
		
		return $id;
	}

	private function save_item($id){
		$this->db->delete('barang_masuk', ['id_pembelian' => $id]);
		$input_post = $this->input->post();
		
		$barang = array();
		for($i = 1; $i <= $input_post['stok']; $i++){
			$barang[] = array(
				'id_pembelian' => $id,
				'id_kategori' => $input_post['id_kategori'],
				'id_sub_kategori' => $input_post['id_sub_kategori'],
				'id_gudang' => $input_post['id_gudang'],
				'harga_awal' => $input_post['harga'],
			);
		}
		if($input_post['stok'] > 0){
			$this->db->insert_batch('barang_masuk', $barang);
		}
	}

	public function get_data()
	{
		$data = $this->model_pembelian->get_all();
		echo json_encode($data);
	}

	function get_subkategori($id){
		$this->db->select('id_sub_kategori, sub_kategori');
		$this->db->order_by('sub_kategori');
		$this->db->where('id_kategori', $id);
		$kategori = $this->db->get('sub_kategori')->result();
		
		echo json_encode($kategori);
	}
}