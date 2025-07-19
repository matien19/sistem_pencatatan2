<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JurusanModel $model */

$this->title = 'Edit Data Jurusan: ' . $model->nama;
$this->params['breadcrumbs'][] = ['label' => 'Jurusan Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nama, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jurusan-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
