<?php
// echo "<pre>";
include_once('conn.php');
if (!$conn) {
    echo "Error : Server Down\n";
    exit;
}

$sql = "
select id_sms, nm_lemb, nm_jenj_didik as jenjang from sms
left join ref.jenjang_pendidikan using(id_jenj_didik)
where id_sp = '$id_sp' and id_jns_sms = 3 
order by id_jenj_didik
";

$result = pg_query($conn, $sql);
// if (!$result) {
//     echo "An error occurred.\n";
//     exit;
// }

$sms = pg_fetch_all($result);
// echo "<pre>";
// var_dump($sms);
// print_r($sms);
// die;
include('header.php');

?><body>
    <div class="container mt-5">
        <form action="result.php" method="post">
        <h3>Sistem PIN PIN PIN</h3> <br/> <br/>
        <label>Pilih Prodi</label>
        <select class="form-control" name="id_sms" id="id_sms">
            <?php foreach($sms as $prodi) : ?>
                <option value="<?= $prodi['id_sms'] ?>"><?= $prodi['jenjang'] . ' - ' . $prodi['nm_lemb'] ?></option>
            <?php endforeach; ?>
        </select>
        <br/>
        <label>Jenis</label>
        <select class="form-control" name="jenis" id="jenis">
            <option value="reservasi">Reservasi</option>
            <option value="pemasangan">Pemasangan</option>
        </select>
        <br/>
        <button class="btn btn-primary" type="submit">Submit</button>
    </form>
    </div>
</body>
</html>