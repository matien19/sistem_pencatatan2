<?php

use app\models\TagihanModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchTagihanModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Tagihan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-model-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a('Tambah Tagihan', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <!-- Nav Tabs -->
            <ul class="nav nav-tabs" id="tagihanTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="siswa-tab" data-toggle="tab" href="#siswa" role="tab">Siswa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="calon-tab" data-toggle="tab" href="#calon" role="tab">Calon Siswa</a>
                </li>
            </ul>

            <!-- Tab Contents -->
            <div class="tab-content mt-3">
                <!-- Tab Siswa -->
                <div class="tab-pane fade show active" id="siswa" role="tabpanel">
                    <?php Pjax::begin(['id' => 'pjax-siswa']); ?>
                        <?= GridView::widget([
                            'dataProvider' => $dataProviderSiswa, // pastikan variabel ini dikirim dari controller
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                // 'id',
                                [
                                    'label' => 'Nama Siswa',
                                    'value' => function ($model) {
                                        return $model->siswa->nama ?? '-';
                                    },
                                ],
                                [
                                    'label' => 'Jenis Pembayaran',
                                    'value' => function ($model) {
                                        return $model->jenisPembayaran->nama_pembayaran ?? '-';
                                    },
                                ],
                                 [
                                    'attribute' => 'jumlah_tagihan',
                                    'label' => 'Jumlah Tagihan',
                                    'format' => ['currency'],
                                ],
                                [
                                    'attribute' => 'tanggal_jatuh_tempo',
                                    'label' => 'Tanggal Jatuh Tempo',
                                    'format' => ['date', 'php:d-m-Y'],
                                ],
                                [
                                    'attribute' => 'status',
                                    'label' => 'Status Pembayaran',
                                    'value' => function ($model) {
                                        return $model->status ? 'Lunas' : 'Belum Lunas';
                                    },
                                    'contentOptions' => function ($model) {
                                        return ['class' => $model->status ? 'text-success' : 'text-danger'];
                                    }
                                ],
                                [
                                    'attribute' => 'bukti_bayar',
                                    'label' => 'Bukti Bayar',
                                    'format' => 'raw',
                                    'value' => function ($model) {
                                        if ($model->bukti_bayar) {
                                            return Html::a('Lihat', ['/bukti/' . $model->bukti_bayar], ['target' => '_blank']);
                                        }
                                        return '-';
                                    },
                                ],
                                [
                                    'class' => ActionColumn::className(),
                                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                                        return Url::toRoute([$action, 'id' => $model->id]);
                                    }
                                ],
                            ],
                        ]); ?>

                    <?php Pjax::end(); ?>
                </div>

                <!-- Tab Calon Siswa -->
                <div class="tab-pane fade" id="calon" role="tabpanel">
                    <?php Pjax::begin(['id' => 'pjax-calon']); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProviderCalonSiswa, // pastikan variabel ini juga dikirim dari controller
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            // 'id',
                            [
                                'label' => 'Nama Siswa',
                                'value' => function ($model) {
                                    return $model->siswa->nama ?? '-';
                                },
                            ],
                            [
                                'label' => 'Jenis Pembayaran',
                                'value' => function ($model) {
                                    return $model->jenisPembayaran->nama_pembayaran ?? '-';
                                },
                            ],
                                [
                                'attribute' => 'jumlah_tagihan',
                                'label' => 'Jumlah Tagihan',
                                'format' => ['currency'],
                            ],
                            [
                                'attribute' => 'tanggal_jatuh_tempo',
                                'label' => 'Tanggal Jatuh Tempo',
                                'format' => ['date', 'php:d-m-Y'],
                            ],
                            [
                                'attribute' => 'status',
                                'label' => 'Status Pembayaran',
                                'value' => function ($model) {
                                    return $model->status ? 'Lunas' : 'Belum Lunas';
                                },
                                'contentOptions' => function ($model) {
                                    return ['class' => $model->status ? 'text-success' : 'text-danger'];
                                }
                            ],
                            [
                                'attribute' => 'bukti_bayar',
                                'label' => 'Bukti Bayar',
                                'format' => 'raw',
                                'value' => function ($model) {
                                    if ($model->bukti_bayar) {
                                        return Html::a('Lihat', ['/bukti/' . $model->bukti_bayar], ['target' => '_blank']);
                                    }
                                    return '-';
                                },
                            ],
                            [
                                'class' => ActionColumn::className(),
                                'urlCreator' => function ($action, $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                }
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
   