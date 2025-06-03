<?php

class Model_penjualan extends CI_Model
{
	public $table = 'penjualan';

  	private function query_all()
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}

		return $this->db->get($this->table . ' a');
	}

	public function count_all()
	{
		$this->db->select("COUNT(*) AS count");
		return $this->query_all()->row()->count;
	}

	public function find_all()
	{
		$this->db->select('a.*');
		$this->db->order_by('a.id_penjualan', 'desc');
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

	public function query_all_produk()
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}
		
		$this->db->join('kategori b', 'a.id_kategori = b.id_kategori', 'left', false);
		$this->db->join('sub_kategori c', 'b.id_kategori = c.id_kategori AND c.id_sub_kategori = a.id_sub_kategori', 'left', false);
		$this->db->join('harga_jual d', 'd.id_kategori = a.id_kategori AND d.id_sub_kategori = a.id_sub_kategori', 'left', false);
		$this->db->join('gudang e', 'e.id_gudang = a.id_gudang', 'left', false);
		$this->db->where('a.status', 'masuk');
		return $this->db->get('barang_masuk a');
	}

	public function find_all_produk()
	{
		$this->db->select("a.id_kategori, a.id_sub_kategori, a.id_gudang, d.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang, COUNT(a.status) AS total_stok, (d.harga_jual * COUNT(a.status)) AS total_harga");
		$this->db->group_by('a.id_kategori, a.id_sub_kategori, a.id_gudang, d.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang');
		$this->db->order_by('b.nama_kategori', 'desc');
		return $this->query_all_produk();
	}

	public function get_all_produk()
	{
		$total = (int) $this->find_all_produk()->num_rows();
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$this->db->limit($limit, $offset);
		$data = $this->find_all_produk()->result();

		$output['recordsTotal'] = $total;
		$output['data'] = $data;
		$output['draw'] = (int) $this->input->post('draw');
		$output['recordsFiltered'] = $total;
		return $output;
	}

	function frist_produk($kategori, $kategori_sub, $gudang){
		$this->db->select('id_barang_masuk, harga_awal');
		$this->db->where('id_kategori', $kategori);
		$this->db->where('id_sub_kategori', $kategori_sub);
		$this->db->where('id_gudang', $gudang);
		$this->db->where('status', 'masuk');
		$this->db->order_by('id_barang_masuk', 'asc');
		$produk_item = $this->db->get('barang_masuk')->row();

		return $produk_item;
	}

	public function query_all_produk_jual($id = 0)
	{
		$category = @$this->input->post('search')['column'];
		$keyword = @$this->input->post('search')['value'];

		if (!empty($keyword) && !empty($category) ) {
			$this->db->where("($category)::TEXT ILIKE '%$keyword%'");
		}
		
		$this->db->join('kategori b', 'a.id_kategori = b.id_kategori', 'left', false);
		$this->db->join('sub_kategori c', 'b.id_kategori = c.id_kategori AND c.id_sub_kategori = a.id_sub_kategori', 'left', false);
		$this->db->join('gudang e', 'e.id_gudang = a.id_gudang', 'left', false);
		$this->db->where('a.status', 'penjualan');
		$this->db->where('a.id_penjualan', $id);
		return $this->db->get('barang_keluar a');
	}

	public function find_all_produk_jual($id = 0)
	{
		$this->db->select("a.id_kategori, a.id_sub_kategori, a.id_gudang, a.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang, COUNT(a.status) AS total_stok, (a.harga_jual * COUNT(a.status)) AS total_harga");
		$this->db->group_by('a.id_kategori, a.id_sub_kategori, a.id_gudang, a.harga_jual, b.nama_kategori, c.sub_kategori, e.nama_gudang');
		$this->db->order_by('b.nama_kategori', 'desc');
		return $this->query_all_produk_jual($id);
	}

	public function get_all_produk_jual($id = 0)
	{
		$total = (int) $this->find_all_produk_jual($id)->num_rows();
		$limit = $this->input->post('length');
		$offset = $this->input->post('start');
		$this->db->limit($limit, $offset);
		$data = $this->find_all_produk_jual($id)->result();

		$output['recordsTotal'] = $total;
		$output['data'] = $data;
		$output['draw'] = (int) $this->input->post('draw');
		$output['recordsFiltered'] = $total;
		return $output;
	}
}
