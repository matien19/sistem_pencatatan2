<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */

$this->title = 'Create Tagihan Model';
$this->params['breadcrumbs'][] = ['label' => 'Tagihan Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'jenisPembayaranList' => $jenisPembayaranList,
    ]) ?>

</div>
