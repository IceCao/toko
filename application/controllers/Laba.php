<?php defined('BASEPATH') or exit('No direct script access allowed');

class Laba extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_laba');
	}

	public function index()
	{
		$data['pageTitle'] = 'Laba';
	
		$data['kategori'] = $this->db->order_by('id_kategori', 'asc')->get('kategori')->result();
		$data['pageContent'] = $this->load->view('laba/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}
	
	function get_subkategori($id){
		$this->db->select('id_sub_kategori, sub_kategori');
		$this->db->order_by('sub_kategori');
		$this->db->where('id_kategori', $id);
		$kategori = $this->db->get('sub_kategori')->result();
		
		echo json_encode($kategori);
	}

	public function get_data($tanggal, $tanggal_ke, $kategori, $kategorisub)
	{
		$return = $this->model_laba->get_all($tanggal, $tanggal_ke, $kategori, $kategorisub);
		echo json_encode($return);
	}
	public function print_exc($filter = '')
	{
		$array = explode('/', base64_decode($filter));
		$tanggal = $array[0];
		$tanggal_ke = $array[1];
		$kategori = $array[2];
		$kategorisub = $array[3];

		$this->db->select("d.tgl_jual, c.sub_kategori, b.nama_kategori, a.harga_awal, a.harga_jual, (a.harga_jual - a.harga_awal) as laba");
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
		
		$this->db->order_by('b.nama_kategori, c.sub_kategori', 'asc');
		$result =  $this->db->get('barang_keluar a')->result();

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		// Header
		$sheet->fromArray([
			['NO', 'TANGGAL TRANSAKSI', 'SUB KATEGORI', 'KATEGORI', 'HARGA BELI', 'HARGA JUAL', 'LABA']
		], NULL, 'A1');

		$total = 0;
		$row = 2;

		foreach ($result as $index => $value) {
			$sheet->fromArray([
				$index + 1,
				$value->tgl_jual,
				$value->sub_kategori,
				$value->nama_kategori,
				$value->harga_awal,
				$value->harga_jual,
				$value->laba,
			], NULL, 'A' . $row);

			$total += $value->laba;
			$row++;
		}

		// Footer total
		$sheet->setCellValue('A' . $row, 'TOTAL');
		$sheet->mergeCells("A$row:F$row");
		$sheet->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle("A$row:F$row")->getFont()->setBold(true);
		$sheet->setCellValue('G' . $row, $total);

		$filename = 'Laporan laba ' . date('Ymd_His') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}

}