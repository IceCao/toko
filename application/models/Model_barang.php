<?php

class Model_barang extends CI_Model
{
	public $table = 'barang_masuk';

  	private function query_all($gudang, $kategori, $kategorisub)
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category)) {
			$this->db->like($category, $keyword);
		}

		$this->db->join('gudang b', 'b.id_gudang = a.id_gudang', 'left');
		$this->db->join('kategori c', 'c.id_kategori = a.id_kategori', 'left');
		$this->db->join('sub_kategori d', 'd.id_kategori = c.id_kategori AND d.id_sub_kategori = a.id_sub_kategori', 'left');

		$this->db->where('a.status', 'masuk');
		if ($gudang != '000') {
			$this->db->where('a.id_gudang', $gudang);
		}

		if ($kategori != '000') {
			$this->db->where('a.id_kategori', $kategori);
		}

		if ($kategorisub != '000') {
			$this->db->where('a.id_sub_kategori', $kategorisub);
		}

		return $this->db->get($this->table . ' a');
	}

	public function find_all($gudang, $kategori, $kategorisub)
	{
		$this->db->select("b.nama_gudang, c.nama_kategori, d.sub_kategori, COUNT(a.id_barang_masuk) as total_stok");
		$this->db->group_by('b.nama_gudang, c.nama_kategori, d.sub_kategori');
		$this->db->order_by('b.nama_gudang', 'asc');
		return $this->query_all($gudang, $kategori, $kategorisub)->result();
	}

  	public function get_all($gudang, $kategori, $kategorisub)
	{
		$data = $this->find_all($gudang, $kategori, $kategorisub);
		$output['data'] = $data;
		return $output;
	}
}
