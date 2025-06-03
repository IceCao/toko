<?php

class Model_pembelian extends CI_Model
{
	public $table = 'pembelian';

  	private function query_all()
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}

		$this->db->join('users b', 'b.id_user = a.id_user', 'left', false);
		$this->db->join('barang_masuk c', 'c.id_pembelian = a.id_pembelian', 'left', false);
		$this->db->join('kategori d', 'd.id_kategori = c.id_kategori', 'left', false);
		$this->db->join('sub_kategori e', 'e.id_kategori = d.id_kategori and e.id_sub_kategori = c.id_sub_kategori', 'left', false);
		$this->db->join('gudang f', 'f.id_gudang = c.id_gudang', 'left', false);
		
		return $this->db->get($this->table . ' a');
	}

	public function count_all()
	{
		$this->db->select("COUNT(*) AS count");
		return $this->query_all()->row()->count;
	}

	public function find_all()
	{
		$this->db->select('a.id_pembelian, a.harga, a.stok, a.total_harga, d.nama_kategori, e.sub_kategori, f.nama_gudang, b.nama_user, a.tgl_beli');
		$this->db->group_by('a.id_pembelian, a.harga, a.stok, a.total_harga, d.nama_kategori, e.sub_kategori, f.nama_gudang, b.nama_user, a.tgl_beli');
		$this->db->order_by('a.id_pembelian', 'desc');
		return $this->query_all()->result();
	}

  	public function get_all()
	{
		$total = (int) $this->count_all();
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$this->db->limit($limit, $offset);
		$data = $this->find_all();

		$output['data'] = $data;
		$output['recordsTotal'] = $total;
		$output['recordsFiltered'] = $total;
		$output['draw'] = (int) $this->input->post('draw');
		return $output;
	}

	function find($id)
	{
		
		$this->db->select('a.id_pembelian, a.harga, a.stok, a.total_harga, d.id_kategori, e.id_sub_kategori, f.id_gudang, a.tgl_beli, a.desc, a.file_code');
		$this->db->join('barang_masuk c', 'c.id_pembelian = a.id_pembelian', 'left', false);
		$this->db->join('kategori d', 'd.id_kategori = c.id_kategori', 'left', false);
		$this->db->join('sub_kategori e', 'e.id_kategori = d.id_kategori and e.id_sub_kategori = c.id_sub_kategori', 'left', false);
		$this->db->join('gudang f', 'f.id_gudang = c.id_gudang', 'left', false);
		$this->db->where('a.id_pembelian', $id);
		$this->db->group_by('a.id_pembelian, a.harga, a.stok, a.total_harga, d.id_kategori, e.id_sub_kategori, f.id_gudang, a.tgl_beli, a.desc, a.file_code');
		return $this->db->get($this->table . ' a');
	}
}
