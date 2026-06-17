<?php defined('BASEPATH') or exit('No direct script access allowed');
require_once 'vendor/autoload.php';  // Menggunakan autoload Composer

use Dompdf\Dompdf;
use Dompdf\Options;  // Impor kelas Options dari namespace Dompdf

class Pdfgenerator
{
    public function generate($html, $filename = '', $paper = '', $orientation = '', $stream = TRUE)
    {
        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper($paper, $orientation);
        $dompdf->render();
        if ($stream) {
            $dompdf->stream($filename . ".pdf", array("Attachment" => 0));
            exit();
        } else {
            return $dompdf->output();
        }
    }
}