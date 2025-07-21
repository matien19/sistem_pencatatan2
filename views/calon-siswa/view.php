<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\CalonSiswaModel $model */

$this->title = $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Data Calon Siswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="calon-siswa-model-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            // 'id',
            'nama',
            'no_pendaftaran',
            'no_hp',
            // 'user_id',
            [
                'attribute' => 'jurusan_id',
                'value' => function ($model) {
                    return $model->jurusan ? $model->jurusan->nama : null;
                },
            ],
            // 'created_at',
            // 'updated_at',
        ],
    ]) ?>

</div>
