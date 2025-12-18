<?php
$raw = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) exit;

$line = date('c') . " | " .
  ($data['message'] ?? '-') . " | " .
  ($data['source'] ?? '-') . ":" .
  ($data['lineno'] ?? '-') . PHP_EOL;

file_put_contents(__DIR__ . '/logs/js-errors.log', $line, FILE_APPEND);
