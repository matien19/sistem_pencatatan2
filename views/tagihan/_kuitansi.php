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
        padding: 20px;
        font-family: "Segoe UI", Arial, sans-serif;
        font-size: 13px;
        line-height: 1.6;
        background: #fff;
    }
    .kuitansi-header {
        text-align: center;
        margin-bottom: 15px;
    }
    .kuitansi-header h2 {
        margin: 0;
        font-size: 20px;
        font-weight: bold;
        letter-spacing: 2px;
        text-transform: uppercase;
        border-bottom: 2px solid #000;
        display: inline-block;
        padding-bottom: 5px;
    }
    .kuitansi table {
        width: 100%;
        border-collapse: collapse;
    }
    .kuitansi td {
        padding: 5px;
        vertical-align: top;
    }
    .amount {
        font-size: 18px;
        font-weight: bold;
        color: #000;
    }
    .terbilang {
        font-style: italic;
        color: #444;
    }
    .signature {
        text-align: right;
        padding-top: 40px;
    }
    .signature span {
        display: block;
        margin-top: 60px;
        font-weight: bold;
        border-top: 1px solid #000;
        width: 150px;
        text-align: center;
        margin-left: auto;
    }
</style>

<div class="kuitansi">
    <div class="kuitansi-header">
        <h2>KWITANSI</h2>
    </div>

    <table>
        <tr>
            <td width="180">No.</td>
            <td>: <?= sprintf("%03d", $pembayaran->id) ?>/KWT/<?= date('m/Y', strtotime($pembayaran->tanggal_bayar)) ?></td>
        </tr>
        <tr>
            <td>Telah diterima dari</td>
            <td>: <?= $tagihan->siswa->nama ?? $tagihan->calonSiswa->nama ?></td>
        </tr>
        <tr>
            <td>Uang sejumlah</td>
            <td class="terbilang">: <?= strtoupper(terbilang($pembayaran->nominal_bayar)) ?> RUPIAH</td>
        </tr>
        <tr>
            <td>Untuk pembayaran</td>
            <td>: <?= $tagihan->jenisPembayaran->nama_pembayaran ?></td>
        </tr>
        <tr>
            <td colspan="2" align="right" style="padding-top:20px;">
                <div class="amount">Rp <?= number_format($pembayaran->nominal_bayar, 0, ',', '.') ?></div>
            </td>
        </tr>
    </table>

    <div class="signature">
        Bantarkawung, <?= Yii::$app->formatter->asDate($pembayaran->tanggal_bayar, 'php:d F Y') ?><br><br>
        <span>Staf</span>
    </div>
</div>
