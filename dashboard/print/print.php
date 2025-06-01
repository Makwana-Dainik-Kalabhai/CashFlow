<?php
require_once "vendor/autoload.php";

use Dompdf\Dompdf;

$pdf = new Dompdf();

include("C:/xampp/htdocs/php/CashFlow/dashboard/print/expenses-list.php");

$pdf->load_html($html);
$pdf->set_option("isRemoteEnabled", true);
$pdf->setPaper("A4", "portrait");
$pdf->render();
ob_end_clean();
$pdf->stream("Expenses.pdf", array("Attachment" => false));
