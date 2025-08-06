<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NamaPembayaranModel $model */

$this->title = 'Create Nama Pembayaran Model';
$this->params['breadcrumbs'][] = ['label' => 'Nama Pembayaran Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nama-pembayaran-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
