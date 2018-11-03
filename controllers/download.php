<?php

$file = '../Source/SISG13_Source.zip';

if (!file_exists($file)) {
    die('File not found');
} else {
    header("Content-Description: File Transfer");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename=\"SISG13_Source.zip\";");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header('Content-Length: ' . filesize($file));
    flush(); // Flush system output buffer
    readfile($file);
    exit;
}
?>
