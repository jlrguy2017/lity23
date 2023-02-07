<?php
$conn = pg_connect("host=127.0.0.1 port=25060 dbname=music user=music");
if (!$conn) {
    echo "Database connection nono working";
}
