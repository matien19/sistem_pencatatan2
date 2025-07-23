<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\TagihanModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="tagihan-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'jenis_pembayaran_id')->textInput() ?>

    <?= $form->field($model, 'tanggal_jatuh_tempo')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
