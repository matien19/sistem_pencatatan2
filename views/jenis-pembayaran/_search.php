<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SearchJenisPembayaranModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jenis-pembayaran-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'jurusan_id') ?>

    <?= $form->field($model, 'kelas') ?>

    <?= $form->field($model, 'nama_pembayaran') ?>

    <?= $form->field($model, 'nominal') ?>

    <?php // echo $form->field($model, 'tahun_akademik') ?>

    <?php // echo $form->field($model, 'semester') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
