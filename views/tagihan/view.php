<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */

$this->title = $model->jenisPembayaran->nama_pembayaran;
$this->params['breadcrumbs'][] = ['label' => 'Tagihan Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tagihan-model-view">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a('Kembali', ['index'], ['class' => 'btn btn-primary']) ?>
            </p>
            <!-- Detail View -->
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'label' => 'Jenis Pembayaran',
                        'value' => function ($model) {
                            return $model->jenisPembayaran->nama_pembayaran ?? '-';
                        },
                    ],
                    [
                        'attribute' => 'total_tagihan',
                        'label' => 'Jumlah Tagihan',
                        'value' => function ($model) {
                            return 'Rp ' . number_format($model->total_tagihan, 0, ',', '.');
                        },
                    ],
                    [
                        'attribute' => 'tanggal_jatuh_tempo',
                        'label' => 'Tanggal Jatuh Tempo',
                        'format' => ['date', 'php:d F Y'],
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Status Pembayaran',
                        'value' => function ($model) {
                            $pembayaran = $model->pembayaran[0] ?? null;

                            if ($model->status == false) {
                                if (empty($pembayaran) || empty($pembayaran->tanggal_bayar)) {
                                    return 'Belum Dibayar';
                                } else {
                                    return 'Sudah Bayar (Belum Diverifikasi)';
                                }
                            } else {
                                return 'Sudah Dibayar (Sudah Diverifikasi)';
                            }
                        },
                    ],
                ],
            ]) ?>
            <?php 
                $bayar = 0;
                foreach ($model->pembayaran as $pembayaran) {
                    $bayar += $pembayaran->nominal_bayar ?? 0;
                }
                // return 'Rp ' . number_format($bayar, 0, ',', '.');
            ?>
            <br>
            <!-- Grid View for related payments -->
            <h4>Riwayat Pembayaran</h4>

             <?php if ($model->hasErrors()): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= Html::errorSummary($model, ['encode' => false, 'header' => '', 'class' => 'mb-0']) ?>
                </div>
            <?php endif; ?>
            <br>
            
            <div class="table-responsive">
                <div class="grid-view">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Tanggal Bayar</th>
                                <th>Metode Bayar</th>
                                <th>Bukti Bayar</th>
                                <th>Jumlah Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($model->pembayaran as $pembayaran): ?>
                                <tr>
                                    <td><?= Yii::$app->formatter->asDate($pembayaran->tanggal_bayar, 'php:d F Y') ?></td>
                                    <td><?= Html::encode($pembayaran->metode_bayar) ?></td>
                                    <td>
                                        <?php if ($pembayaran->bukti_bayar): ?>
                                        <?= Html::a(
                                            Html::img(Yii::getAlias('@web') . '/bukti/' . $pembayaran->bukti_bayar, [
                                                'alt' => 'Bukti Bayar',
                                                'style' => 'max-height: 100px; max-width: 100px; border: 1px solid #ccc;'
                                            ]),
                                            Yii::getAlias('@web') . '/bukti/' . $pembayaran->bukti_bayar,
                                            ['target' => '_blank']
                                        ) ?>
                                        <?php else: ?>
                                        -
                                        <?php endif; ?>
                                    </td>
                                    <td><?= 'Rp ' . number_format($pembayaran->nominal_bayar, 0, ',', '.') ?></td>

                                </tr>
                               
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total Pembayaran:</strong></td>
                                <td><strong><?= 'Rp ' . number_format($bayar, 0, ',', '.') ?></strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
