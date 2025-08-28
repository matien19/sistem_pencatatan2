<?php
use yii\helpers\Html;

function formatRupiah($value) {
    return 'Rp ' . number_format($value, 0, ',', '.');
}

$bulanNama = $bulan ? date('F', mktime(0, 0, 0, $bulan, 10)) : '-';
?>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px;
    }
    th, td {
        padding: 8px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #f8f9fa;
    }
    .text-center {
        text-align: center;
    }

    .signature-container {
        width: 100%;
        margin-top: 50px;
        display: flex;
        justify-content: flex-end;
    }
    .signature-content {
        text-align: right;
    }
    .signature-authority {
        font-weight: bold;
        margin-top: 60px;
    }
    .signature-date {
        margin-bottom: 0;
    }
</style>

<!-- Kop Surat -->
<table style="border: none; margin-bottom: 10px;">
    <tr>
        <td style="width: 15%; border: none;">
            <img src="<?= Yii::getAlias('@webroot') ?>/img/logo_Poncol_New.png" style="max-height: 80px;">
        </td>
        <td style="border: none; text-align: center;">
            <h3 style="margin: 0;">LEMBAGA PENDIDIKAN MA'ARIF NU CABANG BREBES</h3>
            <h3 style="margin: 0;">SMKS MA'ARIF NU 01 BANTARKAWUNG</h3>
            <h5>NPSN : 20338407     NSS : 402032902031</h5>
            <p style="margin: 0; font-size: 11px;">
                Alamat: Jl. Kyai Mukmin No.1 Bangbayang-Bantarkawung, 52274 <br>
                Email: smk_maarif_bby@yahoo.co.id | Telp: 0828-2999-247
            </p>
        </td>
    </tr>
</table>

<hr style="border-top: 2px solid #000; margin-top: 0;">

<!-- Judul Laporan -->
<h4 class="text-center">Laporan Pembayaran <?= ucfirst($tipe) ?></h4>
<p class="text-center">Periode: <?= $bulanNama . ' ' . $tahun ?></p>

<!-- Tabel -->
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama <?= $tipe === 'siswa' ? 'Siswa' : 'Siswa Baru' ?></th>
            <th>Jenis Pembayaran</th>
            <th>Jumlah Tagihan</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($models)): ?>
            <tr>
                <td colspan="5" class="text-center">Data tidak ditemukan.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($models as $i => $model): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?= $tipe === 'siswa'
                            ? ($model->siswa->nama ?? '-') . ' [' . ($model->siswa->nisn ?? '-') . ']'
                            : ($model->calonSiswa->nama ?? '-') . ' [' . ($model->calonSiswa->no_pendaftaran ?? '-') . ']'
                        ?>
                    </td>
                    <td><?= $model->jenisPembayaran->nama_pembayaran ?? '-' ?></td>
                    <td><?= formatRupiah($model->total_tagihan) ?></td>
                    <td>
                        <?= $model->status
                            ? 'Lunas'
                            : (empty($model->pembayaran) ? 'Belum Bayar' : 'Sudah Bayar (Belum Verifikasi)') ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<!-- Tanda Tangan -->
<?php
function tanggalIndonesia($tanggal) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
             'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $tgl = date('j', $tanggal);
    $bln = $bulan[(int)date('n', $tanggal)];
    $thn = date('Y', $tanggal);
    return "$tgl $bln $thn";
}
?>

<div class="signature-container">
    <div class="signature-content">
        <p class="signature-date">
            Bantarkawung, <?= tanggalIndonesia(time()) ?>
        </p>
        <p class="signature-label">Mengetahui,</p>
        <p class="signature-authority">Pimpinan Pondok Pesantren</p>
    </div>
</div>
