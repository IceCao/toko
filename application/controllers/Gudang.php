<?php defined('BASEPATH') or exit('No direct script access allowed');

class Gudang extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_gudang');
	}

	public function index()
	{
		$data['pageTitle'] = 'Gudang';
		
		$data['pageContent'] = $this->load->view('gudang/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function create()
	{
		if (isset($_POST['save'])) {
			$id = $this->save_gudang();
			if ($id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('gudang');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('gudang/edit/' . $id);
			}
		}

		$data['pageTitle'] = 'Tambah Gudang';
		$data['pageContent'] = $this->load->view('gudang/create', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	public function edit($id = 0)
	{
		if (isset($_POST['save'])) {
			$update_id = $this->save_gudang('update', $id);
			if ($update_id) {
				$this->session->set_flashdata('success', 'Data berhasil disimpan');
				redirect('gudang');
			} else {
				$this->session->set_flashdata('error', 'Data gagal disimpan');
				redirect('gudang/edit/' . $id);
			}
		} elseif (isset($_POST['delete'])) {
			if ($this->db->delete('gudang', ['id_gudang' => $id])) {
				$this->session->set_flashdata('success', 'Data berhasil dihapus');
				redirect('gudang');
			}

			$this->session->set_flashdata('error', 'Data gagal dihapus');
			redirect('gudang/edit/' . $id);
		}
		$data['pageTitle'] = 'Edit Gudang';
		$data['gudang'] = $this->db->get_where('gudang', ['id_gudang' => $id])->row();
		$data['pageContent'] = $this->load->view('gudang/edit', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}

	private function save_gudang($type = 'insert', $id = 0)
	{
		$input_post = $this->input->post();
		$data = array(
			'nama_gudang' => $input_post['nama_gudang'],
		);

		$return = false;
		if ($type == 'insert') {
			$id = $this->db->insert('gudang', $data);
		} elseif ($type == 'update') {
			$return = $this->db->update('gudang', $data, ['id_gudang' => $id]);
		}
		
		return $id;
	}

	public function get_data()
	{
		$data = $this->model_gudang->get_all();
		echo json_encode($data);
	}
}