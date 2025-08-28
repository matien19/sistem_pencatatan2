<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CalonSiswaModel $model */

$this->title = 'Edit Data Siswa Baru : ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Calon Siswa Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="calon-siswa-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
