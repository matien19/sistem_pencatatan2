<?php

use app\models\JurusanModel;
use app\models\NamaKelasModel;
use Faker\Guesser\Name;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\KelasModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kelas-model-form">
    <?php
    $currentYear = date('Y');
    $startYear = $currentYear - 3;
    // $endYear = $currentYear + 2;

    $tahunOptions = ['' => 'Pilih Tahun'];
    for ($year = $startYear; $year <= $currentYear; $year++) {
        $tahunOptions[$year] = $year;
    }
    ?>

    <?php $form = ActiveForm::begin(); ?>

   <?= $form->field($model, 'nama')->dropDownList(
       ArrayHelper::map(NamaKelasModel::find()->all(), 'nama_kelas', 'nama_kelas'),
       ['prompt' => 'Pilih Nama Kelas', 'class' => 'form-control']
   ) ?>

    <?= $form->field($model, 'tahun_masuk')->dropDownList(
        $tahunOptions,
        ['class' => 'form-control']
    ) ?>

    <?= $form->field($model, 'jurusan_id')->dropDownList(
        ArrayHelper::map(JurusanModel::find()->all(), 'id', 'nama'),
        ['prompt' => 'Pilih Jurusan']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
