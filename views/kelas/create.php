<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\KelasModel $model */

$this->title = 'Tambah Data Kelas';
$this->params['breadcrumbs'][] = ['label' => 'Kelas Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kelas-model-create">

    <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= Html::errorSummary($model, ['encode' => false, 'header' => '', 'class' => 'mb-0']) ?>
        </div>
    <?php endif; ?>
    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
