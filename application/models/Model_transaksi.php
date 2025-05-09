<?php

class Model_transaksi extends CI_Model
{
	public $table = 'transaksi';

  	private function query_all()
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}
		$this->db->join('produk b', 'a.id_produk = b.id_produk', 'left', false);
		$this->db->join('kategori c', 'c.id_kategori = b.id_kategori', 'left', false);
		$this->db->join('users d', 'd.id_user = a.id_user', 'left', false);
		
		return $this->db->get($this->table . ' a');
	}

	public function count_all()
	{
		$this->db->select("COUNT(*) AS count");
		return $this->query_all()->row()->count;
	}

	public function find_all()
	{
		$this->db->select('a.*, b.nama_produk, c.nama_kategori, d.nama_user');
		$this->db->order_by('a.id_transaksi', 'desc');
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
		$this->db->select('a.*, b.nama_produk, c.nama_kategori, d.nama_user');
		$this->db->join('produk b', 'a.id_produk = b.id_produk', 'left', false);
		$this->db->join('kategori c', 'c.id_kategori = b.id_kategori', 'left', false);
		$this->db->join('users d', 'd.id_user = a.id_user', 'left', false);
		$this->db->where('a.id_transaksi', $id);
		return $this->db->get($this->table . ' a');
	}
}
