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
                                        return $model->siswa->nama . ' [' . ($model->siswa->nisn ?? '-') . ']' ?? '-' ;
                                    },
                                ],
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
                                    'label' => 'Jumlah Dibayar',
                                    'value' => function ($model) {
                                        $bayar = 0;
                                        foreach ($model->pembayaran as $pembayaran) {
                                            $bayar += $pembayaran->nominal_bayar ?? 0;
                                        }
                                        return 'Rp ' . number_format($bayar, 0, ',', '.');
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
                                                return $status = 'Belum Dibayar';
                                            } else {
                                                return $status = 'Sudah Bayar (Belum Diverifikasi)';
                                            }
                                        } else {
                                            return $status = 'Sudah Dibayar (Sudah Diverifikasi)';
                                        }
                                    },
                                ],
                                // [
                                //     'attribute' => 'bukti_bayar',
                                //     'label' => 'Bukti Bayar',
                                //     'format' => 'raw',
                                //     'value' => function ($model) {
                                //         if ($model->bukti_bayar) {
                                //             return Html::a('Lihat', ['/bukti/' . $model->bukti_bayar], ['target' => '_blank']);
                                //         }
                                //         return '-';
                                //     },
                                // ],
                               [
                                    'class' => ActionColumn::className(),
                                    'template' => '{view} {verifikasi} {delete}', // tambahkan tombol verifikasi
                                    'urlCreator' => function ($action, $model, $key, $index, $column) {
                                        return Url::toRoute([$action, 'id' => $model->id]);
                                    },
                                    'visibleButtons' => [
                                        'verifikasi' => function ($model) {
                                            $totalBayar = 0;
                                            foreach ($model->pembayaran as $pembayaran) {
                                                $totalBayar += $pembayaran->nominal_bayar ?? 0;
                                            }

                                            return $model->status == false &&
                                                !empty($model->pembayaran) &&
                                                !empty($model->pembayaran[0]->tanggal_bayar) &&
                                                $totalBayar >= $model->total_tagihan;
                                        },
                                    ],
                                    'buttons' => [
                                        'verifikasi' => function ($url, $model, $key) {
                                           return Html::a(
                                                '<span class="fas fa-check"></span>',
                                                ['verifikasi', 'id' => $model->id],
                                                [
                                                    // 'class' => 'btn btn-xs btn-success',
                                                    'data-confirm' => 'Apakah Anda yakin ingin memverifikasi pembayaran ini?',
                                                    'data-method' => 'post',
                                                    'title' => 'Verifikasi Pembayaran',
                                                ]
                                            );
                                        },
                                    ],
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
                                    return $model->calonSiswa->nama . ' [' . ($model->calonSiswa->no_pendaftaran) . ']' ?? '-';
                                },
                            ],
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
                            // [
                            //     'attribute' => 'bukti_bayar',
                            //     'label' => 'Bukti Bayar',
                            //     'format' => 'raw',
                            //     'value' => function ($model) {
                            //         if ($model->bukti_bayar) {
                            //             return Html::a('Lihat', ['/bukti/' . $model->bukti_bayar], ['target' => '_blank']);
                            //         }
                            //         return '-';
                            //     },
                            // ],
                            [
                                'class' => ActionColumn::className(),
                                'template' => '{view} {delete}', // hanya tampilkan view dan delete
                                'urlCreator' => function ($action, $model, $key, $index, $column) {
                                    return Url::toRoute([$action, 'id' => $model->id]);
                                },
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
   