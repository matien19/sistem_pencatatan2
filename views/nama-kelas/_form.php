<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\NamaKelasModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="nama-kelas-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_kelas')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
