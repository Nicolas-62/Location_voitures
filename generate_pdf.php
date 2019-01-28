<?php    
    session_start();
    require('tfpdf/tfpdf.php');
    $pdf = unserialize($_SESSION['pdf']);
    $pdf->Output();

