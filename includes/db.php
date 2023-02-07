<?php
$conn = pg_connect("host=localhost port=25060 dbname=music user=music");
if (!$conn) {
    echo "Database connection nono working";
}
