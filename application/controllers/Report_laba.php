<?php defined('BASEPATH') or exit('No direct script access allowed');

class Report_laba extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->cekLogin();
		$this->load->model('model_laba');
	}

	public function index()
	{
		$data['pageTitle'] = 'Report laba';
	
		$data['kategori'] = $this->db->order_by('id_kategori', 'asc')->get('kategori')->result();
		$data['pageContent'] = $this->load->view('report_laba/list', $data, TRUE);
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
		$result = $this->db->get('barang_keluar a')->result();

		$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$sheet->mergeCells('A1:G1');
		$sheet->setCellValue('A1', 'LAPORAN LABA PENJUALAN');
		$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
		$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->mergeCells('A2:G2');
		$sheet->setCellValue('A2', 'PERIODE: ' . date('d-m-Y', strtotime($tanggal)) . ' s/d ' . date('d-m-Y', strtotime($tanggal_ke)));
		$sheet->getStyle('A2')->getFont()->setItalic(true);
		$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

		$sheet->fromArray([
			['NO', 'TANGGAL TRANSAKSI', 'KATEGORI', 'SUB KATEGORI', 'HARGA BELI', 'HARGA JUAL', 'LABA']
		], NULL, 'A4');
		$sheet->getStyle('A4:G4')->getFont()->setBold(true);

		$total = 0;
		$row = 5;

		foreach ($result as $index => $value) {
			$sheet->fromArray([
				$index + 1,
				$value->tgl_jual,
				$value->nama_kategori,
				$value->sub_kategori,
				'Rp ' . $value->harga_awal,
				'Rp ' . $value->harga_jual,
				'Rp ' . $value->laba,
			], NULL, 'A' . $row);
			$total += $value->laba;
			$row++;
		}

		$sheet->mergeCells("A$row:F$row");
		$sheet->setCellValue("A$row", 'TOTAL');
		$sheet->getStyle("A$row")->getFont()->setBold(true);
		$sheet->getStyle("A$row")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
		$sheet->setCellValue("G$row", 'Rp ' . $total);
		$sheet->getStyle("G$row")->getFont()->setBold(true);

		$borderStyle = [
			'borders' => [
				'allBorders' => [
					'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					'color' => ['argb' => 'FF000000'],
				],
			],
		];

		$lastRow = $row;
		$sheet->getStyle("A4:G$lastRow")->applyFromArray($borderStyle);

		foreach (range('A', 'G') as $col) {
			$sheet->getColumnDimension($col)->setAutoSize(true);
		}

		$filename = 'Laporan_Laba_' . date('Ymd_His') . '.xlsx';

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
		$result = $this->db->get('barang_keluar a')->result();

		$this->load->library('TcpdfLite');
		$pdf = new TcpdfLite('L', 'mm', 'A4');
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Sistem');
		$pdf->SetTitle('Laporan Laba');
		$pdf->SetMargins(10, 10, 10);
		$pdf->SetAutoPageBreak(TRUE, 10);
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(true);

		$pdf->AddPage();

		$pdf->SetFont('Times', 'B', 14);
		$pdf->Cell(0, 10, 'Laporan Laba Penjualan', 0, 1, 'C');
		$pdf->SetFont('Times', '', 10);
		$pdf->Cell(0, 6, 'Periode: ' . date('d-m-Y', strtotime($tanggal)) . ' s/d ' . date('d-m-Y', strtotime($tanggal_ke)), 0, 1, 'C');
		$pdf->Ln(5);

		$pdf->SetFont('Times', 'B', 10);
		$w = [10, 30, 58, 58, 40, 40, 40];

		$pdf->Cell($w[0], 7, 'No', 1, 0, 'C');
		$pdf->Cell($w[1], 7, 'Tgl Jual', 1, 0, 'C');
		$pdf->Cell($w[2], 7, 'Kategori', 1, 0, 'C');
		$pdf->Cell($w[3], 7, 'Sub Kategori', 1, 0, 'C');
		$pdf->Cell($w[4], 7, 'Harga Awal', 1, 0, 'R');
		$pdf->Cell($w[5], 7, 'Harga Jual', 1, 0, 'R');
		$pdf->Cell($w[6], 7, 'Laba', 1, 1, 'R');

		$pdf->SetFont('Times', '', 10);
		$no = 1;
		$total_laba = 0;
		foreach ($result as $row) {
			$pdf->Cell($w[0], 7, $no++, 1, 0, 'C');
			$pdf->Cell($w[1], 7, date('d-m-Y', strtotime($row->tgl_jual)), 1, 0, 'C');
			$pdf->Cell($w[2], 7, $row->nama_kategori, 1, 0, 'L');
			$pdf->Cell($w[3], 7, $row->sub_kategori, 1, 0, 'L');
			$pdf->Cell($w[4], 7, 'Rp ' . number_format($row->harga_awal, 0, ',', '.'), 1, 0, 'R');
			$pdf->Cell($w[5], 7, 'Rp ' . number_format($row->harga_jual, 0, ',', '.'), 1, 0, 'R');
			$pdf->Cell($w[6], 7, 'Rp ' . number_format($row->laba, 0, ',', '.'), 1, 1, 'R');
			$total_laba += $row->laba;
		}

		$pdf->SetFont('Times', 'B', 10);
		$pdf->Cell(array_sum($w) - $w[5], 7, 'Total Laba', 1, 0, 'R');
		$pdf->Cell($w[5], 7, 'Rp ' . number_format($total_laba, 0, ',', '.'), 1, 1, 'R');

		$filename = 'laporan_laba_' . date('YmdHis') . '.pdf';
		$pdf->Output($filename, 'I');
	}
}