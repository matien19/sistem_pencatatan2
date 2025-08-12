<?php
use yii\helpers\Html;

function terbilang($angka)
{
    $angka = intval(round(abs($angka))); // pastikan integer positif

    $bilangan = [
        "", "Satu", "Dua", "Tiga", "Empat", "Lima", 
        "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"
    ];

    if ($angka < 12) {
        return " " . $bilangan[$angka];
    } elseif ($angka < 20) {
        return terbilang($angka - 10) . " Belas";
    } elseif ($angka < 100) {
        return terbilang(intval($angka / 10)) . " Puluh" . terbilang($angka % 10);
    } elseif ($angka < 200) {
        return " Seratus" . terbilang($angka - 100);
    } elseif ($angka < 1000) {
        return terbilang(intval($angka / 100)) . " Ratus" . terbilang($angka % 100);
    } elseif ($angka < 2000) {
        return " Seribu" . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        return terbilang(intval($angka / 1000)) . " Ribu" . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        return terbilang(intval($angka / 1000000)) . " Juta" . terbilang($angka % 1000000);
    } elseif ($angka < 1000000000000) {
        return terbilang(intval($angka / 1000000000)) . " Miliar" . terbilang($angka % 1000000000);
    } else {
        return "Angka terlalu besar";
    }
}

?>
<style>
    .kuitansi {
        border: 2px solid #000;
        padding: 10px;
        font-family: Arial, sans-serif;
        font-size: 12px;
    }
    .side-text {
        writing-mode: vertical-rl;
        transform: rotate(180deg);
        background: #f2f2f2;
        padding: 5px;
        font-weight: bold;
    }
    .title {
        font-weight: bold;
        text-transform: uppercase;
    }
    .amount {
        font-size: 18px;
        font-weight: bold;
    }
</style>

<table class="kuitansi" width="100%">
    <tr>
        <td rowspan="6" width="50" align="center" class="side-text">KWITANSI</td>
        <td width="150">No.</td>
        <td>: <?= sprintf("%03d", $pembayaran->id) ?>/KWT/<?= date('m/Y', strtotime($pembayaran->tanggal_bayar)) ?></td>
    </tr>
    <tr>
        <td>Telah diterima dari</td>
        <td>: <?= $tagihan->siswa->nama ?? $tagihan->calonSiswa->nama ?></td>
    </tr>
    <tr>
        <td>Uang sejumlah</td>
        <td>: <i><?= strtoupper(terbilang($pembayaran->nominal_bayar)) ?> RUPIAH</i></td>
    </tr>
    <tr>
        <td>Untuk pembayaran</td>
        <td>: <?= $tagihan->jenisPembayaran->nama_pembayaran ?></td>
    </tr>
    <tr>
        <td colspan="2" align="right" style="padding-top:20px;">
            <strong>Rp <?= number_format($pembayaran->nominal_bayar, 0, ',', '.') ?></strong>
        </td>
    </tr>
    <tr>
        <td colspan="2" align="right" style="padding-top:30px;">
            <?= Yii::$app->formatter->asDate($pembayaran->tanggal_bayar, 'php:d F Y') ?><br>
            <br><br>( Staf )
        </td>
    </tr>
</table>
