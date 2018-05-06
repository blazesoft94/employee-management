<?php
ob_start();
session_start();
include_once("../../includes/config.php");
include_once("../../includes/function.php");
if(isset($_POST['q'])) {
// Include the main TCPDF library (search for installation path).
require_once('tcpdf_include.php');
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Ravinthranath');
$pdf->SetTitle('Techware Solution');
$pdf->SetSubject('Techware Solution Bank Slip');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING."(".date("M-Y").")");
// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}
// ---------------------------------------------------------
// set font
$pdf->SetFont('courier', '', 10);
// add a page
$pdf->AddPage();
// create some HTML content
$html = '<h1>Techware Solution</h1>
<strong>Date :</strong>'.$_POST['info'].'<br/>
<strong>Phone:</strong> + 91 484 319 8381<br/>
<strong>Place:</strong> Heavenly Plaza,ES&FS 7th Floor,Civil Line Road, Vazhakkala, Ernakulam,Kakkanad, Cochin, Kerala 682021, India
<br/><br/>
<table border="1" cellspacing="1" cellpadding="6" class="pfd_printer">'.$_POST['q'].'</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
// reset pointer to the last page
$pdf->lastPage();
// ---------------------------------------------------------
//Close and output PDF document
//$pdf->Output('example_fnbs.pdf', 'I');
// local
//$location = $_SERVER['DOCUMENT_ROOT']."Ravi/eoffice/techware_new_eoffice/develop/bank_slip/pdf/bank_slip_".date('Y_m_d_H_i_s').".pdf";
// Online
$location = $_SERVER['DOCUMENT_ROOT']."bank_slip/pdf/bank_slip_".date('Y_m_d_H_i_s').".pdf";
$location_upadte = "bank_slip/pdf/bank_slip_".date('Y_m_d_H_i_s').".pdf";
$pdf->Output($location, 'F');

// CSV FILE CREATION PART
$csv = "TITLE: TECHWARE SOLUTION\n
		Date : ".$_POST['info']."\n
		Phone : + 91 484 319 8381\n
		Place : Heavenly Plaza - Kakkanad - Cochin - Kerala 682021 - India\n";
$csv .= "Sl_NO,Name,Bank Name, Branch, Account No, IFSC Code, Salary \n";//Column headers
foreach ($_SESSION['information'] as $record){
    $csv.= $record['number'].','.$record['fname'].','.$record['bank_name'].','.$record['branch'].','.$record['acc_num'].','.$record['ifsc_code'].','.$record['amount']."\n"; //Append data to csv
    }
// ONLINE
$csv_location = $_SERVER['DOCUMENT_ROOT']."bank_slip/csv/csv_".date('Y_m_d_H_i_s').".csv";
$csv_update = "bank_slip/csv/csv_".date('Y_m_d_H_i_s').".csv";
// LOCAL
//$csv_location = $_SERVER['DOCUMENT_ROOT']."Ravi/eoffice/techware_new_eoffice/develop/bank_slip/csv/csv_".date('Y_m_d_H_i_s').".csv";
$csv_handler = fopen ($csv_location,'w');
fwrite ($csv_handler,$csv);
fclose ($csv_handler);

// CSV FILE CREATION PART OVER



// details are insert into databse
$insert = mysql_query("INSERT INTO bank_slip_info (`month_year`,`total_amt`,`pdf_path`,`csv_path`,`created_date`,`created_person`) VALUES ('".$_POST['info']."','".$_POST['amount']."','".$location_upadte."','".$csv_update."','".date('Y-m-d H:i:s')."','".$_SESSION['username']."')");
	if($insert) {
		echo "success";
	} else {
		echo "Error";
	}
}

