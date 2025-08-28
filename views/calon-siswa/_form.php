<?php

use app\models\JurusanModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\CalonSiswaModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="calon-siswa-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_pendaftaran', [
        'template' => '
            {label}
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">REG-</span>
                </div>
                {input}
            </div>
            {error}
        '
    ])->input('number', [
        'maxlength' => true,
        'placeholder' => '1234',
    ]) ?>

    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jurusan_id')->dropDownList(
        ArrayHelper::map(JurusanModel::find()->all(), 'id', 'nama'),
        ['prompt' => 'Pilih Jurusan']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
