<?php

$mp3_file = $_GET['filename']; 

HttpResponse::setCache(true);
HttpResponse::setContentType("audio/mpeg3");
HttpResponse::setContentDisposition("$mp3_file.mp3", false);
HttpResponse::setFile('../image/blue005.jpg');
HttpResponse::send();
?>
