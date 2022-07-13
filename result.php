<?php 
include_once('conn.php');

$id_sms = $_POST['id_sms'];
$jenis = $_POST['jenis'];
if (!$id_sms or !$jenis) {
    header('location: index.php');
}


$tahun_ajar = '2020';
$limit = 20;


$sql = "
select id_sms, nm_lemb, nm_jenj_didik as jenjang from sms
left join ref.jenjang_pendidikan using(id_jenj_didik)
where id_sms = '$id_sms'";

$result = pg_query($conn, $sql);
$sms = pg_fetch_assoc($result);

include('header.php');
include('aturan.php');

if ($jenis == 'reservasi') {
    $a_aturan = $a_aturan_reservasi[$sms['jenjang']];
} else {
    $a_aturan = $a_aturan_pemasangan[$sms['jenjang']];
}


foreach ($a_aturan as $k => $v)
    eval('$' . $k . ' = $v;');

$sql = "
select id_sms, reg.id_reg_pd, nipd, sks_total, nm_pd, jk, nik, tgl_keluar, no_seri_ijazah, mulai_smt, sk_yudisium, ipk, nm_lemb, smt_mulai, id_stat_mhs, nm_jenj_didik from peserta_didik pd
join reg_pd reg using(id_pd)
join sms using(id_sms)
join lateral (
	select id_smt, id_reg_pd, id_stat_mhs, sks_total
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd order by id_smt desc limit 1
) k on true
left join lateral (
	select id_smt
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd and sks_smt > $sks_smt_max limit 1	
) over_sks on true
left join lateral (
	select id_smt
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd and sks_smt > $sks_smt_max_pendek and substr(id_smt,5,1) = '3' limit 1	
) over_sks_pendek on true
join ref.jenjang_pendidikan using(id_jenj_didik)
where id_stat_mhs = 'A' and id_sms = '27a1dd12-b81a-4a36-87a4-12fc8d5af19e' 
and ipk > $ipk_min
and sks_total > $sks_min
and length(nik) = 16
and ($tahun_ajar - substr(mulai_smt,1,4)::int) <= $tahun_max
and over_sks.id_smt is null
and over_sks_pendek.id_smt is null
order by tgl_keluar desc
limit $limit";

$result = pg_query($conn, $sql);
$a_eligible = pg_fetch_all($result);

$sql = "
select id_sms, reg.id_reg_pd, nipd, sks_total, nm_pd, jk, nik, tgl_keluar, no_seri_ijazah, mulai_smt, sk_yudisium, ipk, nm_lemb, smt_mulai, id_stat_mhs, nm_jenj_didik,
case when ipk < $ipk_min then 1 else 0 end as gagal_ipk,
case when sks_total < $sks_min then 1 else 0 end as gagal_sks,
case when length(nik) != 16  then 1 else 0 end as gagal_nik,
case when over_sks.id_smt is not null then 1 else 0 end as gagal_smt,
case when over_sks_pendek.id_smt is not null then 1 else 0 end as gagal_smt_pendek,
over_sks_pendek.id_smt as cekal_smt_pendek,
over_sks.id_smt as cekal_smt

from peserta_didik pd
join reg_pd reg using(id_pd)
join sms using(id_sms)
join lateral (
	select id_smt, id_reg_pd, id_stat_mhs, sks_total
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd order by id_smt desc limit 1
) k on true
left join lateral (
	select id_smt
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd and sks_smt > $sks_smt_max limit 1	
) over_sks on true
left join lateral (
	select id_smt
	from kuliah_mhs where id_reg_pd = reg.id_reg_pd and sks_smt > $sks_smt_max_pendek and substr(id_smt,5,1) = '3' limit 1	
) over_sks_pendek on true
join ref.jenjang_pendidikan using(id_jenj_didik)
where id_stat_mhs = 'A' and id_sms = '27a1dd12-b81a-4a36-87a4-12fc8d5af19e' 
and ($tahun_ajar - substr(mulai_smt,1,4)::int) <= $tahun_max
and ipk is not null
and ipk != 0
and
( 
    ipk < $ipk_min
    or sks_total < $sks_min
    or length(nik) != 16
    or over_sks.id_smt is not null
    or over_sks_pendek.id_smt is not null
)
order by mulai_smt desc
limit $limit";

$result = pg_query($conn, $sql);
$a_uneligible = pg_fetch_all($result);
?>

<body>
<br>
<div class="container">
    <h2><?= ucfirst($jenis) ?> PIN Program Studi <?= $sms['jenjang'] . ' ' . $sms['nm_lemb'] ?> </h2>
    <div class="container">
        <hr/>
        <h5>Eligible</h5>
        <table class="table">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>SKS</th>
                <th>IPK</th>
                <th>Alasan</th>
            </tr>
            <?php foreach($a_eligible as $row) : ?>            
                <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $row['nipd'] ?></td>
                    <td><?= $row['nm_pd'] ?></td>
                    <td><?= $row['sks_total'] ?></td>
                    <td><?= $row['ipk'] ?></td>
                    <td>OK</td>
                </tr>
            <?php endforeach; ?>

        </table>
        
        <h5>Non Eligible</h5>
        <table class="table">
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>Nama</th>
                <th>SKS</th>
                <th>IPK</th>
                <th>Alasan</th>
            </tr>

            <?php 
                $i = 0;
            foreach($a_uneligible as $row) : ?>            
                <tr>
                    <td><?= ++$i ?></td>
                    <td><?= $row['nipd'] ?></td>
                    <td><?= $row['nm_pd'] ?></td>
                    <td><?= $row['sks_total'] ?></td>
                    <td><?= $row['ipk'] ?></td>
                    <td><?php
                        $msg = '';
                        if ($row['gagal_ipk']) {
                            $msg = 'IPK kurang dari ' . $ipk_min;
                        } else if ($row['gagal_sks']) {
                            $msg = 'SKS Kurang dari '. $sks_min;
                        } else if ($row['gagal_nik']) {
                            $msg = 'NIK Salah (tidak sesui format 16 digit)';
                        } else if ($row['gagal_smt']) {
                            $msg = 'SKS pada periode ' . $row['cekal_smt'] . ' melebihi ' . $sks_smt_max;
                        } else if ($row['gagal_smt_pendek']) {
                            $msg = 'SKS pada periode ' . $row['cekal_smt_pendek'] . ' melebihi ' . $sks_smt_max_pendek;
                        }
                        echo $msg;
                    ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

</body>