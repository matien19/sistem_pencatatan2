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
     <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= Html::errorSummary($model, ['encode' => false, 'header' => '', 'class' => 'mb-0']) ?>
        </div>
    <?php endif; ?>
    
    <?= $this->render('_form', [
        'model' => $model,
        // 'nama_pembayaran' => $nama_pembayaran, 
    ]) ?>


</div>
