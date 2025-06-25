<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report_barang extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_barang');
	}

	public function index()
	{
		$data['pageTitle'] = 'Report barang';
	
		$data['gudang'] = $this->db->order_by('id_gudang', 'asc')->get('gudang')->result();
		$data['kategori'] = $this->db->order_by('id_kategori', 'asc')->get('kategori')->result();
		$data['pageContent'] = $this->load->view('report_barang/list', $data, TRUE);
		$this->load->view('template/adminlte/layout', $data);
	}
	
	function get_subkategori($id){
		$this->db->select('id_sub_kategori, sub_kategori');
		$this->db->order_by('sub_kategori');
		$this->db->where('id_kategori', $id);
		$kategori = $this->db->get('sub_kategori')->result();
		
		echo json_encode($kategori);
	}

	public function get_data($gudang, $kategori, $kategorisub)
	{
		$return = $this->model_barang->get_all($gudang, $kategori, $kategorisub);
		echo json_encode($return);
	}

	public function print_exc($filter = '')
	{
		$array = explode('/', base64_decode($filter));
		$gudang = $array[0];
		$kategori = $array[1];
		$kategorisub = $array[2];

		$this->db->select("b.nama_gudang, c.nama_kategori, d.sub_kategori, COUNT(a.id_barang_masuk) as total_stok");
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

		$this->db->group_by('b.nama_gudang, c.nama_kategori, d.sub_kategori');
		$this->db->order_by('b.nama_gudang', 'asc');
		$result = $this->db->get('barang_masuk a')->result();

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:E1');
		$sheet->setCellValue('A1', 'LAPORAN STOK GUDANG');
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->mergeCells('A2:E2');
		$sheet->setCellValue('A2', 'GUDANG: ' . ($gudang === '000' ? 'SEMUA' : $result[0]->nama_gudang));
		$sheet->getStyle('A2')->getFont()->setItalic(true);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->fromArray([['NO', 'GUDANG', 'KATEGORI', 'SUB KATEGORI', 'TOTAL STOK']], NULL, 'A4');
		$sheet->getStyle('A4:E4')->getFont()->setBold(true);

		$row = 5;
		foreach ($result as $index => $value) {
			$sheet->fromArray([
				$index + 1,
				$value->nama_gudang,
				$value->nama_kategori,
				$value->sub_kategori,
				$value->total_stok,
			], NULL, 'A' . $row);
			$row++;
		}

		$lastRow = $row - 1;

		$borderStyle = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
		];
		$sheet->getStyle("A4:E$lastRow")->applyFromArray($borderStyle);

		foreach (range('A', 'E') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$filename = 'Laporan_gudang_' . date('Ymd_His') . '.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment; filename=\"$filename\"");
		header('Cache-Control: max-age=0');

		$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		$writer->save('php://output');
		exit;
	}



	public function print_doc($filter = '')
	{
		$array = explode('/', base64_decode($filter));
		$gudang = $array[0];
		$kategori = $array[1];
		$kategorisub = $array[2];

		$this->db->select("b.nama_gudang, c.nama_kategori, d.sub_kategori, COUNT(a.id_barang_masuk) as total_stok");
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

		$this->db->group_by('b.nama_gudang, c.nama_kategori, d.sub_kategori');
		$this->db->order_by('b.nama_gudang', 'asc');
		$result = $this->db->get('barang_masuk a')->result();

		$this->load->library('TcpdfLite');
		$pdf = new TcpdfLite('L', 'mm', 'A4');
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Sistem');
		$pdf->SetTitle('LAPORAN STOK GUDANG');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);

		$pdf->AddPage();

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(0, 10, 'LAPORAN STOK GUDANG', 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0, 6, 'GUDANG: ' . ($gudang === '000' ? 'SEMUA' : $result[0]->nama_gudang), 0, 1, 'C');
		$pdf->Ln(5);

		$pdf->SetFont('Times', 'B', 10);
		$w = [10, 65, 65, 65, 65];

		$pdf->Cell($w[0], 7, 'NO', 1, 0, 'C');
		$pdf->Cell($w[1], 7, 'GUDANG', 1, 0, 'C');
		$pdf->Cell($w[2], 7, 'KATEGORI', 1, 0, 'C');
		$pdf->Cell($w[3], 7, 'SUB KATEGORI', 1, 0, 'C');
		$pdf->Cell($w[4], 7, 'TOTAL STOK', 1, 1, 'R');

		$pdf->SetFont('Times', '', 10);
		$no = 1;

		foreach ($result as $row) {
			$pdf->Cell($w[0], 7, $no++, 1, 0, 'C');
			$pdf->Cell($w[1], 7, $row->nama_gudang, 1, 0, 'C');
			$pdf->Cell($w[2], 7, $row->nama_kategori, 1, 0, 'L');
			$pdf->Cell($w[3], 7, $row->sub_kategori, 1, 0, 'L');
			$pdf->Cell($w[4], 7, $row->total_stok, 1, 1, 'R');
		}

		$filename = 'laporan_gudang_' . date('YmdHis') . '.pdf';
		$pdf->Output($filename, 'I');
	}
}