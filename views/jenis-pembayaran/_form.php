<?php

use app\models\JurusanModel;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\JenisPembayaranModel $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="jenis-pembayaran-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_pembayaran')->dropDownList(
        ArrayHelper::map($nama_pembayaran, 'nama_pembayaran', 'nama_pembayaran'),
        ['prompt' => '-- Pilih Nama Pembayaran --']
    ) ?>

    <?= $form->field($model, 'nominal')->input('number', [
        'placeholder' => 'Masukkan nominal',
        'required' => true,
    ]) ?>

    <?php
    // Tahun Ajaran Otomatis
    $currentYear = date('Y');
    $startYear = $currentYear - 2;
    $maxYear = $currentYear;
    $tahunOptions = ['' => 'Pilih Tahun Ajaran'];
    for ($year = $startYear; $year <= $maxYear; $year++) {
        $tahunOptions[$year] = "$year/" . ($year + 1);
    }
    ?>

    <?= $form->field($model, 'tahun_akademik')->dropDownList($tahunOptions, [
        'class' => 'form-control'
    ])->label('Tahun Ajaran') ?>

    <?= $form->field($model, 'semester')->dropDownList([
        '' => 'Pilih Semester',
        'Genap' => 'Genap',
        'Ganjil' => 'Ganjil',
    ], ['class' => 'form-control']) ?>

    <?= $form->field($model, 'keterangan')->textarea([
        'placeholder' => 'Dibayar sekali ...',
        'required' => true
    ]) ?>

    <?= $form->field($model, 'kepada')->radioList([
        'siswa' => 'Siswa',
        'calon_siswa' => 'Calon Siswa'
    ], ['class' => 'form-check'])->label('Kepada') ?>

   <!-- Jurusan Select2 -->
    <div id="jurusan_wrapper">
        <?= $form->field($model, 'jurusan_id[]')->widget(Select2::class, [
            'data' => ArrayHelper::map(JurusanModel::find()->all(), 'id', 'nama'),
            'options' => [
                'placeholder' => 'Pilih Jurusan',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label('Jurusan (Opsional)') ?>
    </div>

    <!-- Kelas Select2 -->
    <div id="kelas_wrapper" style="display: none;">
        <?= $form->field($model, 'kelas[]')->widget(Select2::class, [
            'data' => [
                '1' => 'X',
                '2' => 'XI',
                '3' => 'XII',
            ],
            'options' => [
                'placeholder' => 'Pilih Kelas',
                'multiple' => true,
            ],
            'pluginOptions' => [
                'allowClear' => true,
            ],
        ])->label('Kelas (Opsional)') ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Simpan', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <?php
    $js = <<<JS
    $('input[name="JenisPembayaranModel[kepada]"]').on('change', function() {
        var val = $(this).val();
        if (val === 'siswa') {
            $('#kelas_wrapper').show();
        } else {
            $('#kelas_wrapper').hide();
        }
    });
    JS;
    $this->registerJs($js);
    ?>


</div>
