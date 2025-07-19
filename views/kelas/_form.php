<?php

use app\models\JurusanModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KelasModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kelas-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'kelas')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tahun_masuk')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'jurusan_id')->dropDownList(
        ArrayHelper::map(JurusanModel::find()->all(), 'id', 'nama'),
        ['prompt' => 'Pilih Jurusan']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
