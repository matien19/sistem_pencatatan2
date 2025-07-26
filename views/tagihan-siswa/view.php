<?php

use app\models\PembayaranModel;
use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Modal;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */

$this->title = 'Detail Tagihan: ' . $model->jenisPembayaran->nama_pembayaran;
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

            <?php 
            if ($bayar < $model->total_tagihan) {
                Html::button('Tambah Pembayaran', [
                'class' => 'btn btn-success',
                'data-toggle' => 'modal',
                'data-target' => '#modal-pembayaran'
            ]);
            } else {
                if ($model->status == false) {
                    echo '<p class="text-warning">Pembayaran sudah dilakukan, namun belum diverifikasi.</p>';
                } else {
                    echo '<p class="text-success">Pembayaran sudah Lunas.</p>';
                }
            }
            ?>
            

            <?php Modal::begin([
                'title' => 'Form Pembayaran',
                'id' => 'modal-pembayaran',
                'size' => Modal::SIZE_LARGE,
            ]); ?>

           
            <?php $form = ActiveForm::begin([
                'id' => 'form-tambah-pembayaran',
                'action' => ['tagihan-siswa/create'], // Ganti dengan action yang sesuai
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <?= $form->field($pembayaranBaru, 'tagihan_id')->hiddenInput(['value' => $model->id])->label(false) ?>

            <?= $form->field($pembayaranBaru, 'tanggal_bayar')->input('date') ?>

            <?= $form->field($pembayaranBaru, 'nominal_bayar')->textInput(['type' => 'number']) ?>

            <?= $form->field($pembayaranBaru, 'metode_bayar')->dropDownList([
                'transfer' => 'Transfer',
                'cash' => 'Cash',
            ], ['prompt' => 'Pilih Metode Pembayaran']) ?>

            <?= $form->field($pembayaranBaru, 'bukti_bayar')->fileInput() ?>

            <div class="form-group">
                <?= Html::submitButton('Simpan Pembayaran', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <?php Modal::end(); ?>
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
 <script>
    document.getElementById('btn-tambah-pembayaran').addEventListener('click', function() {
        var form = document.getElementById('form-tambah-pembayaran');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>

