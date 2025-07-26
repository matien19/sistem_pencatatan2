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
           <?= GridView::widget([
               'dataProvider' => $dataProvider,
            //    'filterModel' => $searchModel,
               'columns' => [
                //    'id',
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

                            if ($model->status == 0) {
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
                    [
                        'class' => ActionColumn::className(),
                        'template' => '{view}', // hanya tampilkan view
                        'urlCreator' => function ($action, $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        },
                    ],

               ],
                'pager' => [
                    'firstPageLabel' => 'Pertama',
                    'lastPageLabel' => 'Terakhir',
                    'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
                    'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
                    'maxButtonCount' => 5,
                    'options' => ['class' => 'pagination justify-content-center'],
                    'activePageCssClass' => 'active bg-success text-white',
                    'disabledPageCssClass' => 'disabled',
                ],
           ]); ?>
        </div>
    </div>
</div>
   