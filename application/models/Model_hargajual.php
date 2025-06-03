<?php

class Model_hargajual extends CI_Model
{
	public $table = 'harga_jual';

  	private function query_all()
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}

		$this->db->join('kategori b', 'a.id_kategori = b.id_kategori', 'left', false);
		$this->db->join('sub_kategori c', 'a.id_kategori = c.id_kategori and a.id_sub_kategori = c.id_sub_kategori', 'left', false);
		$this->db->join($this->table . ' d', 'a.id_kategori = d.id_kategori and a.id_sub_kategori = d.id_sub_kategori', 'left', false);
		// $this->db->join('gudang e', 'a.id_gudang = e.id_gudang', 'left', false);

		return $this->db->get('barang_masuk a');
	}

	public function count_all()
	{
		$this->db->select("COUNT(*) AS count");
		return $this->query_all()->row()->count;
	}

	public function find_all()
	{
		$this->db->select("a.id_kategori, a.id_sub_kategori, b.nama_kategori, c.sub_kategori, d.harga_jual");
		$this->db->distinct();
		$this->db->order_by('b.nama_kategori', 'desc');
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
}
