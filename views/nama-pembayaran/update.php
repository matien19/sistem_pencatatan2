<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NamaPembayaranModel $model */

$this->title = 'Update Nama Pembayaran Model: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Nama Pembayaran Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="nama-pembayaran-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
