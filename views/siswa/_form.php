<?php

use app\models\KelasModel;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\SiswaModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="siswa-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'nisn')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'no_hp')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'kelas_id')->dropDownList(
        ArrayHelper::map(
            KelasModel::find()->with('jurusan')->all(),
            'id',
            function($kelas) {
                return $kelas->jurusan
                    ? $kelas->jurusan->nama . ' ' . $kelas->kelas . $kelas->nama
                    : null;
            }
        ),
        ['prompt' => '-- Pilih Kelas --']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
