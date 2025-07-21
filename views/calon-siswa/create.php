<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\CalonSiswaModel $model */

$this->title = 'Tambah Calon Siswa';
$this->params['breadcrumbs'][] = ['label' => 'Calon Siswa Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="calon-siswa-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

     <?php if ($model->hasErrors()): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= Html::errorSummary($model, ['encode' => false, 'header' => '', 'class' => 'mb-0']) ?>
        </div>
    <?php endif; ?>

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
