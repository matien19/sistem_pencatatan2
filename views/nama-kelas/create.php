<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\NamaKelasModel $model */

$this->title = 'Tambah Nama Kelas';
$this->params['breadcrumbs'][] = ['label' => 'Nama Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="nama-kelas-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
