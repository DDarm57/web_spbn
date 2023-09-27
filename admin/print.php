<?php
include "../db/koneksi.php";
require_once '../vendor/autoload.php'; // Sesuaikan dengan path ke autoload.inc.php

use Dompdf\Dompdf;
use Dompdf\Options;

function print_pemasukan()
{
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);

    $dompdf = new Dompdf();

    $html = file_get_contents('path_to_your_html_file.html'); // Ganti dengan path ke file HTML Anda

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait'); // Atur ukuran kertas dan orientasi (portrait/landscape)
    $dompdf->render();

    $dompdf->stream('laporan.pdf'); // Menampilkan PDF dalam browser untuk diunduh

}
