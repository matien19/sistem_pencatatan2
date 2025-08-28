<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\SiswaModel $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Siswa Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="siswa-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Apakah kamu ingin menghapus item ini?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nama',
            'nisn',
            'no_hp',
            // 'user_id',
            [
              'attribute' => 'kelas_id',
              'label' => 'Kelas & Jurusan',
              'value' => function ($model) {
              // Pastikan relasi 'kelas' dan 'jurusan' sudah didefinisikan di SiswaModel
              return $model->kelas && $model->kelas->jurusan
                ? $model->kelas->jurusan->nama . ' ' . $model->kelas->kelas . $model->kelas->nama
                : null;
              },
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
