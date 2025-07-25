<?php

use app\models\JenisPembayaranModel;
use app\models\JurusanModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchJenisPembayaranModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Jenis Pembayaran Models';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jenis-pembayaran-model-index">
     <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <p>
                <?= Html::a('Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
            </p>

            <?php Pjax::begin(); ?>
            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'nama_pembayaran',
                        'label' => 'Nama',
                    ],
                    [
                        'attribute' => 'kepada',
                        'label' => 'Kepada',
                    ],
                    [
                        'attribute' => 'nominal',
                        'label' => 'Nominal',
                        'value' => function ($model) {
                            return 'Rp ' . number_format($model->nominal, 0, ',', '.');
                        }
                    ],
                    [
                        'attribute' => 'tahun_akademik',
                        'label' => 'Tahun Ajaran',
                    ],
                    [
                        'attribute' => 'semester',
                        'label' => 'Semester',
                    ],
                    [
                        'label' => 'Jurusan',
                        'format' => 'raw',
                        'value' => function ($model) {
                            // Ambil daftar nama jurusan dari relasi
                            $decoded = json_decode($model->jurusan_id, true);

                            if (is_array($decoded)) {
                                if (count($decoded) === 1 && $decoded[0] === '-') {
                                    return '-';
                                }
                                
                                $jurusanList = JurusanModel::find()
                                    ->where(['id' => $decoded])
                                    ->select('nama') // atau 'nama_jurusan', sesuaikan nama kolomnya
                                    ->column(); // ambil hasil sebagai array nilai

                                return implode(', ', $jurusanList);
                            }

                            return $model->jurusan_id;
                        }
                    ],
                    [
                        'label' => 'Kelas',
                        'value' => function ($model) {
                            // Ubah JSON string menjadi array, lalu gabungkan dengan koma
                            $kelas = json_decode($model->kelas, true);
                            return is_array($kelas) ? implode(', ', $kelas) : $model->kelas;
                        }
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
