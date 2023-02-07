<?php
$conn = pg_connect("host=localhost port=5432 dbname=music user=music");
if (!$conn) {
    echo "Database connection nono working";
}
