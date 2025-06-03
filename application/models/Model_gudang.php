<?php

class Model_gudang extends CI_Model
{
	public $table = 'gudang';

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
		$this->db->order_by('a.id_gudang', 'desc');
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
