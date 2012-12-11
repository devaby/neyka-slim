<?php

$file = $_GET['src'];

header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-Disposition: attachment; filename=$file");
header("Content-Type: ".mime_content_type($file));
header("Content-Transfer-Encoding: binary");


?>