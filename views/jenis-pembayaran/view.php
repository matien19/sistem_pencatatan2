<?php

use app\models\JurusanModel;
use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\JenisPembayaranModel $model */

$this->title = $model->nama_pembayaran;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pembayaran Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="jenis-pembayaran-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah kamu yakin ingin menghapus item ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

   <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nama_pembayaran',

            [
                'label' => 'Jurusan',
                'format' => 'raw',
                'value' => function ($model) {
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
                'format' => 'raw',
                'value' => function ($model) {
                    if (is_array($model->kelas)) {
                        return implode(', ', $model->kelas);
                    }
                    // jika tersimpan dalam format string JSON
                    $decoded = json_decode($model->kelas, true);
                    return is_array($decoded) ? implode(', ', $decoded) : $model->kelas;
                }
            ],
            [
                'attribute' => 'nominal',
                'value' => function ($model) {
                    return 'Rp ' . number_format($model->nominal, 0, ',', '.');
                }
            ],
            'tahun_akademik',
            'semester',
            'keterangan',
            'kepada',
            'created_at',
            'updated_at',
        ],
    ]) ?>


</div>
