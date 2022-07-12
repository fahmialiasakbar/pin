<?php
// echo "<pre>";
$schema      = 'public';
$table       = 'daya_tampung';
$host        = "host = localhost";
$port        = "port = 5432";
$dbname      = "dbname = feeder";
$credentials = "user = postgres password=root";

$conn = pg_connect("$host $port $dbname $credentials");
if (!$conn) {
    echo "Error : Server Down\n";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h2>Reservasi </h2>
        <div class="container">
            <hr/>
            <h5>Eligible</h5>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>SKS</th>
                    <th>IPK</th>
                    <th>Alasan</th>
                </tr>
            </table>
            
            <h5>Non Eligible</h5>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>SKS</th>
                    <th>IPK</th>
                    <th>Alasan</th>
                </tr>
            </table>
        </div>

        <h2>Pemasangan</h2>
        <div class="container">
            <hr/>
            <h5>Eligible</h5>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>SKS</th>
                    <th>IPK</th>
                    <th>Alasan</th>
                </tr>
            </table>
            
            <h5>Non Eligible</h5>
            <table class="table">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIM</th>
                    <th>SKS</th>
                    <th>IPK</th>
                    <th>Alasan</th>
                </tr>
            </table>
        </div>
    </div>

</body>
</html>