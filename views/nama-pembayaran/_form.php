<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\NamaPembayaranModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="nama-pembayaran-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_pembayaran')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
