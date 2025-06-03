<?php

class Model_laba extends CI_Model
{
	public $table = 'barang_keluar';

  	private function query_all($tanggal, $tanggal_ke, $kategori, $kategorisub)
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category)) {
			// Lindungi dari SQL injection dengan binding atau escape
			$this->db->like($category, $keyword);
		}

		$this->db->join('kategori b', 'b.id_kategori = a.id_kategori', 'left');
		$this->db->join('sub_kategori c', 'b.id_kategori = c.id_kategori AND c.id_sub_kategori = a.id_sub_kategori', 'left');
		$this->db->join('penjualan d', 'd.id_penjualan = a.id_penjualan', 'left');

		$this->db->where("DATE(d.tgl_jual) >=", $tanggal);
		$this->db->where("DATE(d.tgl_jual) <=", $tanggal_ke);
		$this->db->where('a.status', 'penjualan');

		if ($kategori != '000') {
			$this->db->where('a.id_kategori', $kategori);
		}

		if ($kategorisub != '000') {
			$this->db->where('a.id_sub_kategori', $kategorisub);
		}

		return $this->db->get($this->table . ' a');
	}

	public function find_all($tanggal, $tanggal_ke, $kategori, $kategorisub)
	{
		$this->db->select("d.tgl_jual, c.sub_kategori, b.nama_kategori, a.harga_awal, a.harga_jual, (a.harga_jual - a.harga_awal) as laba");
		$this->db->order_by('b.nama_kategori, c.sub_kategori', 'asc');
		return $this->query_all($tanggal, $tanggal_ke, $kategori, $kategorisub)->result();
	}

  	public function get_all($tanggal, $tanggal_ke, $kategori, $kategorisub)
	{
		$total = 0;
		$data = $this->find_all($tanggal, $tanggal_ke, $kategori, $kategorisub);
		foreach($data as $val){
			$total += $val->laba;
		}

		$output['total'] = $total;
		$output['data'] = $data;
		return $output;
	}
}
