<?php defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_transaksi');
	}

	public function index()
	{
		$data['pageTitle'] = 'Transaksi';
		
		$data['pageContent'] = $this->load->view('transaksi/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_transaksi();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('transaksi');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('transaksi/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Transaksi';
		$data['pageContent'] = $this->load->view('transaksi/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_transaksi('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('transaksi');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('transaksi/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('transaksi', ['id_transaksi' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('transaksi');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('transaksi/edit/' . $id);
		}

		$data['pageTitle'] = 'Edit Transaksi';
		$data['transaksi'] = $this->model_transaksi->find($id)->row();
		$data['pageContent'] = $this->load->view('transaksi/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_transaksi($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$data = array(
			'nama_transaksi' => $input_post['nama_transaksi'],
		);

		$return = false;
		if ($type == 'insert') {
			$id = $this->db->insert('transaksi', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('transaksi', $data, ['id_transaksi' => $id]);
		}
		
		return $id;
	}

	public function get_data()
	{
		$data = $this->model_transaksi->get_all();
		echo json_encode($data);
	}
}