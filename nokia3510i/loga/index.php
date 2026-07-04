<?php
header("Content-Type: text/vnd.wap.wml; charset=utf-8");

$template = file_get_contents(__DIR__ . "/index.wml");
echo $template;
