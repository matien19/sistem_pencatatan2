<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */

$this->title = 'Update Tagihan Model: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Tagihan Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tagihan-model-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'jenisPembayaranList' => $jenisPembayaranList,
    ]) ?>

</div>
