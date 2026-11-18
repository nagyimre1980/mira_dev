<?php
global $l;
$l = Array();
$l['a_meta_charset'] = 'UTF-8';
$l['a_meta_dir'] = 'ltr';
$l['a_meta_language'] = 'hu';
$l['w_page'] = 'oldal';
//require_once('pdf17/tcpdf.php');
//require_once('pdf17/tcpdf_min.php');
//require_once('pdf19/tcpdf.php');
//require_once('pdf21/tcpdf.php');
//require_once('pdf22/tcpdf.php');
//require_once('pdf24/tcpdf.php');
//require_once('pdf25/tcpdf.php');
//require_once('pdf26/tcpdf.php');

//$pdf_mappa_ver="pdf27";
//$pdf_mappa_ver_file="tcpdf.php";

$pdf_mappa_ver="pdf28";
$pdf_mappa_ver_file="autoload.php";

include_once('sablon_pdf_function_tcpdf.php');

//require_once('pdf27/tcpdf.php');
//require_once('pdf28/autoload.php');
require_once($pdf_mappa_ver.'/'.$pdf_mappa_ver_file);


class MYPDF extends TCPDF {

	//Page header
	public function Header() {//20 volt, az nagy lett
	//	 $this->Image(K_PATH_IMAGES.'image/logok2021_kont.png',0, 8, 0,10, 'PNG', '', '', false, 300, 'L', false, false, 0, false, false, false);
	fejlec_str($this);
	}

	// Page footer
	public function Footer() {
		//$this->Image(K_PATH_IMAGES.'image/kont_lablec2021_kont.png',12,278, 0,15, 'PNG', '', '', false, 300, '', false, false, 0, false, false, false);
		
		$this->SetY(-10);
		$this->SetFont('freeserif', 'I', 10);
		// Page number	
		//$this->Cell(0,0,"                          ".$this->getAliasNumPage().'/'.$this->getAliasNbPages().' oldal', 0, false, 'C', 0, '', 0, false, 'T', 'M');			
		$szokoz = tcpdf_v7() ? '' : '                          ';
		$this->Cell(0, 0, $szokoz.$this->getAliasNumPage().'/'.$this->getAliasNbPages().' oldal', 0, false, 'C', 0, '', 0, false, 'T', 'M');

		$this->SetY(-17);
		// Set font
		$this->SetFont('freeserif', 'I', 8);
		$this->Cell(0, 0,$GLOBALS['rend_nev'].$GLOBALS['rend_str'].' V'.$GLOBALS['prog_ver_fo'].'.'.$GLOBALS['prog_ver'], 0, false, 'C', 0, '', 0, false, 'T', 'M');

		$this->SetY(-13);
		// Set font
		$this->SetFont('freeserif', 'I', 6);//helvetica
		$mostd=date("Y.m.d H:i:s",time());
		$this->Cell(0, 0,'PDF generálás: '.$mostd, 0, false, 'C', 0, '', 0, false, 'T', 'M');
		
	}
}

// create new PDF document
$pdf = new MYPDF("P", PDF_UNIT,"A4", true, 'utf-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false, 3);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins("15", "32","15");
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetHeaderMargin("20");
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE,45);//volt PDF_MARGIN_BOTTOM

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings

$pdf->setLanguageArray($l);
//$pdf->SetCompression(true);

// Set document information dictionary in unicode mode
//$pdf->SetDocInfoUnicode(true);

//include_once("pdf2/header.php");
//header beépítve - eleje
$pdf->SetCreator("MVM Services Zrt. 2021-2026 Copyright ©  Minden jog fenntartva.");
$pdf->setLanguageArray($l);
$cim="Jogosultsági adatlap";
$pdf->SetAuthor('MVM Services Zrt.',"Ture");
$kesz="\nGenerálás ideje: ".$date=date("Y.m.d. H:i:s", time());
$hely="\nGenerálás helye: ".$_SERVER['REMOTE_ADDR'];
//$pdf->SetKeywords($cim.$kesz.$hely,"Ture");
//$pdf->SetTitle("https://kontoline.mvmh.hu - ".$cim);
$pdf->SetTitle("Tevékenység rögzítés: ".$GLOBALS['mira']['pdf_login_nev']);
//$pdf->SetSubject($cim);
//$preferences = array('HideToolbar' => false,'HideMenubar' => false,'HideWindowUI' => false,'FitWindow' => false,'CenterWindow' => false,'DisplayDocTitle' => true,'NonFullScreenPageMode' => 'UseNone','ViewArea' => 'UseNone','ViewClip' => 'UseNone','PrintArea' => 'CropBox','PrintClip' => 'CropBox','PrintScaling' => 'None','PickTrayByPDFSize' => true,'NumCopies' => 1);

$preferences = array(
    'PrintScaling' => 'None', // None, AppDefault
    'Duplex' => 'Simplex', // Simplex, DuplexFlipShortEdge, DuplexFlipLongEdge
    'PickTrayByPDFSize' => false,
    'NumCopies' => 1
);

$pdf->setViewerPreferences($preferences);

//$pdf->SetDisplayMode('default','OneColumn');
//$pdf->SetDisplayMode($zoom='real', $layout='OneColumn', $mode='UseNone');//fullwidth real fullpage
$pdf->SetDisplayMode($zoom='fullpage', $layout='OneColumn', $mode='UseOutlines');

$pdf->setFontSubsetting(true);
//header beépítve - vége


// set font
$pdf->SetFont('freeserif', '',10);

//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->AddPage('P', 'A4');

function pdf_elonezet_vizjel($pdf){
$pdf->SetFont('freeserif','',11);
//$pdf->SetFont('helvetica','',11);
//$pdf->SetFont('times','',11);
//$watermark = 'T  E  R  V  E  Z  E  T';
$watermark = 'E L Ő N É Z E T';
$num_pages = $pdf->getNumPages();
for($i=1; $i<=$num_pages;$i++){
$pdf->setPage($i);
// Get the page width/height
$myPageWidth = $pdf->getPageWidth();
$myPageHeight = $pdf->getPageHeight();

// Find the middle of the page and adjust.
//$myY = ( $myPageHeight / 2 ) + 45;
$myX = ( $myPageWidth / 2 ) - 40;
$myY = ( $myPageHeight / 2 )+55;

$myX = ( $myPageWidth / 2 ) - 46;
$myY = ( $myPageHeight / 2 )+53;

// Set the transparency of the text to really light
$pdf->SetAlpha(0.25);
//$pdf->SetAlpha(1.00);

// Rotate 45 degrees and write the watermarking text
$pdf->StartTransform();
$pdf->Rotate(60, $myX+50, $myY+90);
$pdf->SetFontSize(110);
$pdf->Text($myX+40, $myY, $watermark);
$pdf->StopTransform();

$pdf->SetAlpha(1);
$pdf->setPageMark();
}
}
?>