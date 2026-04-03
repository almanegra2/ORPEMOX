<?php
$lines = file(__DIR__.'/../storage/logs/laravel.log');
$start_line = 0;
for ($i = count($lines)-1; $i >= 0; $i--) {
    if (strpos($lines[$i], 'Trying to access array offset on null') !== false && strpos($lines[$i], 'local.ERROR') !== false) {
        $start_line = $i;
        break;
    }
}
$out = "";
if ($start_line > 0) {
    for ($i = $start_line; $i < min(count($lines), $start_line + 40); $i++) {
        $out .= $lines[$i];
    }
}
file_put_contents(__DIR__.'/trace_out.txt', $out);
