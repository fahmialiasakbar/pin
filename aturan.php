<?php

$sks_max = 24;
$sks_max_pendek = 9;
$ipk = 2;
$ipk_pasca = 3;
$a_aturan_reservasi = [
    'D3' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 5,
        'sks_min' => 96,
        'ipk_min' => $ipk
    ],
    'S1' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 7,
        'sks_min' => 120,
        'ipk_min' => $ipk
    ],
    'S2' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 4,
        'sks_min' => 18,
        'ipk_min' => $ipk_pasca
    ],
    'S3' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 7,
        'sks_min' => 24,
        'ipk_min' => $ipk_pasca
    ],
];


$a_aturan_pemasangan = [
    'D3' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 5,
        'sks_min' => 108,
        'ipk_min' => $ipk
    ],
    'S1' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 7,
        'sks_min' => 144,
        'ipk_min' => $ipk
    ],
    'S2' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 4,
        'sks_min' => 36,
        'ipk_min' => $ipk_pasca
    ],
    'S3' => [
        'sks_smt_max' => $sks_max,
        'sks_smt_max_pendek' => $sks_max_pendek,
        'tahun_max' => 7,
        'sks_min' => 42,
        'ipk_min' => $ipk_pasca
    ],
]

?>