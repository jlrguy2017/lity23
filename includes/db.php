<?php
$conn_string = "host=app-40e4fe2d-9e67-44f6-abf6-0b906486c9d7-do-user-13312887-0.b.db.ondigitalocean.com port=25060 dbname=defaultdb user=doadmin password=AVNS_V0C0GirTQV99QSXrLsa sslmode=require";
$conn = pg_connect($conn_string);

if(!$conn){
    echo "Database connection faildiZZ";
}
