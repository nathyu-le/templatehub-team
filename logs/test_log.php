<?php
file_put_contents(
  __DIR__ . '/logs/error.log',
  date('Y-m-d H:i:s') . " | TEST FROM PHP\n",
  FILE_APPEND
);
echo "OK";