<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\JenisPembayaranModel $model */

$this->title = 'Ubah Jenis Pembayaran: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Jenis Pembayaran Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="jenis-pembayaran-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
