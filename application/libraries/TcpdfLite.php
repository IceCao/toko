<?php defined('BASEPATH') || exit('No direct script access allowed');
require APPPATH . 'libraries/tcpdf/tcpdf.php';

class TcpdfLite extends TCPDF
{
	public function Header()
	{
		// $this->SetFont('Times', 'B', 15);
		// $this->setTopMargin(PDF_MARGIN_HEADER);
		// $this->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		// $this->Cell(0, 0, 'KERTAS KERJA TIM PENILAI', 0, 0, 'C');
	}

	// Page footer
	public function Footer()
	{
		// Go to 1.5 cm from bottom
		$this->SetY(-15);
		// Select Arial italic 8
		$this->SetFont('Times', 'I', 8);
		// Print centered page number
		$this->Cell(0, 10, 'Halaman ' . $this->PageNo(), 0, 0, 'C');
	}
}