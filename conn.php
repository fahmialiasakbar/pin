<?php 
$schema      = 'public';
$table       = 'daya_tampung';
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = feeder";
$credentials = "user = postgres password=root";
$id_sp      = "8e5d195a-0035-41aa-afef-db715a37b8da";
$conn = pg_connect("$host $port $dbname $credentials");

?>