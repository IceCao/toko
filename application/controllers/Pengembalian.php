<?php defined('BASEPATH') or exit('No direct script access allowed');

class Pengembalian extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->library('Blob');
		$this->load->model('model_pengembalian');
	}

	public function index()
	{
		$data['pageTitle'] = 'Pengembalian';
		
		$data['pageContent'] = $this->load->view('pengembalian/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_pengembalian();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('pengembalian');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('pengembalian/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Pengembalian';
		$data['pageContent'] = $this->load->view('pengembalian/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_pengembalian('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('pengembalian');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('pengembalian/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('pengembalian', ['id_pengembalian' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('pengembalian');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('pengembalian/edit/' . $id);
		}
		$pengembalian = $this->db->get_where('pengembalian', ['id_pengembalian' => $id])->row();
		
		$data['pageTitle'] = 'Edit Pengembalian';
		$data['pengembalian'] = $pengembalian;
		$data['attachments'] = explode(',', $pengembalian->file_code);
		$data['pageContent'] = $this->load->view('pengembalian/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_pengembalian($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$upload = $this->blob->upload_img();
		
		if($upload['status'] == 'error'){
			$this->session->set_flashdata('error', $upload['message']);
			redirect('pengembalian');
		}
		
		$file_code_lama = $this->input->post('file_code_lama');
		$file_code = !empty($upload['files']) ? $upload['files'] : $file_code_lama;
		
		$data = array(
			'desc' => $input_post['desc'],
			'id_user' => $this->session->userdata('id_user'),
			'file_code' => $file_code,
			'tgl_jual' => date("Y-m-d", strtotime($input_post['tgl_jual'])),
		);

		$return = false;
		if ($type == 'insert') {
			$this->db->insert('pengembalian', $data);
			$id = $this->db->insert_id();
			if(is_numeric($id)){
				$this->save_item($id);
			}
		} elseif ($type == 'update') {
			$this->db->update('pengembalian', $data, ['id_pengembalian' => $id]);
			if(is_numeric($id)){
				$this->save_item($id);
			}
		}
		
		return $id;
	}

	private function save_item($id){
		$post 			= $this->input->post();
		$total_stok 	= 0;
		$total_harga 	= 0;
		$barang 		= [];

		foreach($post['id_sub_kategori'] as $key => $val){
			$stok = (int) $post['stok'][$key];
	        $harga_jual = (int) $post['harga_jual'][$key];

			$total_stok += $stok;
			$total_harga += $stok * $harga_jual;
			for($i = 0; $i < $post['stok'][$key]; $i++){
				$frist_produk = $this->model_pengembalian->frist_produk($post['id_kategori'][$key], $post['id_sub_kategori'][$key], $post['id_gudang'][$key]);
				$barang[] = array(
					'id_pengembalian' => $id,
					'id_kategori' => $post['id_kategori'][$key],
					'id_sub_kategori' => $post['id_sub_kategori'][$key],
					'id_gudang' => $post['id_gudang'][$key],
					'harga_awal' => $frist_produk->harga_awal,
					'harga_jual' => $post['harga_jual'][$key],
					'status' => 'pengembalian',
				);

				$this->db->update('barang_masuk', ['status' => 'keluar', 'harga_jual' => $post['harga_jual'][$key]], ['id_barang_masuk' => $frist_produk->id_barang_masuk]);
			}
		}
		$this->db->insert_batch('barang_keluar', $barang);
		$this->db->update('pengembalian', ['total_stok' => $total_stok, 'total_harga' => $total_harga], ['id_pengembalian' => $id]);
	}

	public function get_data()
	{
		$data = $this->model_pengembalian->get_all();
		echo json_encode($data);
	}

	public function get_produk()
	{
		$return = $this->model_pengembalian->get_all_produk();
		echo json_encode($return);
	}

	public function get_produk_jual($id = 0)
	{
		$return = $this->model_pengembalian->get_all_produk_jual($id);
		echo json_encode($return);
	}
	
	public function transfer_data(){
		$input = $this->input->post();

		$total_harga = 0;
		$object_produk = array();
		foreach($input['produk'] as $val){
			$array = explode('/', $val);
			$kategori		= $array[0];
			$kategori_sub	= $array[1];
			$gudang			= $array[2];

			$this->db->select("a.id_kategori, a.id_sub_kategori, a.id_gudang, d.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang, COUNT(a.status) AS total_stok, (d.harga_jual * COUNT(a.status)) AS total_harga");
			$this->db->join('kategori b', 'a.id_kategori = b.id_kategori', 'left', false);
			$this->db->join('sub_kategori c', 'b.id_kategori = c.id_kategori AND c.id_sub_kategori = a.id_sub_kategori', 'left', false);
			$this->db->join('harga_jual d', 'd.id_kategori = a.id_kategori AND d.id_sub_kategori = a.id_sub_kategori', 'left', false);
			$this->db->join('gudang e', 'e.id_gudang = a.id_gudang', 'left', false);
			$this->db->where('a.id_kategori', $kategori);
			$this->db->where('a.id_sub_kategori', $kategori_sub);
			$this->db->where('a.id_gudang', $gudang);
			$this->db->where('a.status', 'masuk');
			$this->db->group_by('a.id_kategori, a.id_sub_kategori, a.id_gudang, d.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang');
			$this->db->order_by('b.nama_kategori', 'desc');
			$produk = $this->db->get('barang_masuk a')->row();

			$total_harga += (int)$produk->total_harga;
			$object_produk[] = $produk;
		}

		$data = [
			'produk' => $object_produk,
			'total_harga' => $total_harga,
		];
		echo json_encode($data);
	}
}