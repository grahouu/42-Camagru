<?php

$files = array();

$files = array_merge($files, glob('bin/[!app]*.php'));
$files = array_merge($files, glob("controller/*.php"));

foreach ($files as $file) {
    include $file;
}


?>
