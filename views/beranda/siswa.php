<?php

use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

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

<?php
if (!empty($notifikasiBelum)) {
    Modal::begin([
        'id' => 'notifikasiModal',
        'title' => '<i class="fas fa-bell"></i> Notifikasi Terbaru',
        'titleOptions' => ['class' => 'px-3 py-2'],
        'size' => Modal::SIZE_LARGE,
        'closeButton' => [
            'label' => '×',
            'class' => 'fas fa-times',
            'data-bs-dismiss' => 'modal'
        ],
    ]);
    ?>

    <?php foreach ($notifikasiBelum as $notif): ?>
        <div class="alert alert-light border-start border-4 border-primary mb-3">
            <?= Html::encode($notif->pesan) ?>
            <br>
            <small class="text-muted"><?= Yii::$app->formatter->asDatetime($notif->tgl_kirim) ?></small>
            <a href="<?= Url::to(['/tagihan-siswa/view', 'id' => $notif->id_tagihan]) ?>" class="btn btn-info btn-xs"> <i class="fas fa-eye"></i> Lihat</a>
        </div>
    <?php endforeach; ?>
    <div class="text-end">
        <?= Html::a('Tandai Semua Dibaca', ['beranda/tandai-notifikasi-read'], [
            'class' => 'btn btn-primary',
            'data-method' => 'post',
            'data-confirm' => 'Apakah Anda yakin ingin menandai semua notifikasi sebagai sudah dibaca?',
        ]) ?>
    </div>
    <div class="text-center mt-3">
        <p class="text-muted">Anda memiliki <?= count($notifikasiBelum) ?> notifikasi belum dibaca.</p>
    </div>
    
    <?php
    Modal::end();

    $this->registerJs(new JsExpression("
        $(document).ready(function() {
            $('#notifikasiModal').modal('show');
            // $.post('" . Url::to(['beranda/tandai-notifikasi-read']) . "');
        });
    "));
}
?>