<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SearchTagihanModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-model-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'siswa_id') ?>

    <?= $form->field($model, 'calon_siswa_id') ?>

    <?= $form->field($model, 'jenis_pembayaran_id') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'tanggal_jatuh_tempo') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
