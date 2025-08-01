<?php
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Beranda';
$this->params['breadcrumbs'] = [['label' => $this->title]];
?>
<div class="container-fluid">
    <div class="card bg-gradient-primary text-white mb-4">
        <div class="card-body">
            <h4>Selamat datang, <?= Html::encode($siswa->nama ?? 'Siswa') ?>!</h4>
            <p class="mb-0">Berikut ringkasan informasi keuangan Anda:</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card text-white bg-info mb-3">
                <div class="card-header">Total Tagihan</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $jumlahTagihan ?> Tagihan</h5>
                    <p class="card-text">Jumlah total tagihan yang tercatat di sistem.</p>
                    <a href="<?= Url::to(['tagihan-siswa/index']) ?>" class="btn btn-light btn-sm">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-header">Tagihan Lunas</div>
                <div class="card-body">
                    <h5 class="card-title"><?= $jumlahLunas ?> Lunas</h5>
                    <p class="card-text">Tagihan yang sudah berhasil dibayarkan.</p>
                    <a href="<?= Url::to(['tagihan-siswa/index']) ?>" class="btn btn-light btn-sm">Lihat Riwayat</a>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-warning mt-3">
        <strong>Perhatian:</strong> Mohon periksa status pembayaran Anda secara berkala dan pastikan tidak ada keterlambatan.
    </div>
</div>