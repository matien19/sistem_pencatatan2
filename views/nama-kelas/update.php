<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NamaKelasModel $model */

$this->title = 'Edit Nama Kelas: ' . $model->nama_kelas;
$this->params['breadcrumbs'][] = ['label' => 'Nama Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama_kelas, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nama-kelas-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
