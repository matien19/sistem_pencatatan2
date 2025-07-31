<?php

use app\models\CalonSiswaModel;
use app\models\SiswaModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProviderSiswa */
/** @var yii\data\ActiveDataProvider $dataProviderCalonSiswa */

$this->title = 'Data Siswa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siswa-model-index">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="card-body">
     
      <!-- Nav Tabs -->
      <ul class="nav nav-tabs mb-3" id="siswaTabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" id="siswa-tab" data-toggle="tab" href="#siswa" role="tab">Siswa</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="calon-tab" data-toggle="tab" href="#calon" role="tab">Calon Siswa</a>
        </li>
      </ul>

      <!-- Tab Contents -->
      <div class="tab-content">
        <!-- Tab Siswa -->
        <div class="tab-pane fade show active" id="siswa" role="tabpanel">
          <p>
            <?= Html::a('Tambah Siswa', ['create'], ['class' => 'btn btn-success']) ?>
          </p>
          <?php Pjax::begin(['id' => 'pjax-siswa']); ?>
          <?= GridView::widget([
            'dataProvider' => $dataProviderSiswa,
            'columns' => [
              ['class' => 'yii\grid\SerialColumn'],
              'nama',
              'nisn',
              'no_hp',
              [
                'attribute' => 'kelas_id',
                'label' => 'Kelas & Jurusan',
                'value' => function ($model) {
                  return $model->kelas && $model->kelas->jurusan
                    ? $model->kelas->jurusan->nama . ' ' . $model->kelas->kelas . $model->kelas->nama
                    : '-';
                },
              ],
              [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, SiswaModel $model, $key, $index, $column) {
                  return Url::toRoute([$action, 'id' => $model->id]);
                }
              ],
            ],
          ]); ?>
          <?php Pjax::end(); ?>
        </div>

        <!-- Tab Calon Siswa -->
        <div class="tab-pane fade" id="calon" role="tabpanel">
          <p>
            <?= Html::a('Tambah Calon Siswa', ['calon-siswa/create'], ['class' => 'btn btn-success']) ?>
          </p>
          <?php Pjax::begin(['id' => 'pjax-calon']); ?>
          <?= GridView::widget([
                'dataProvider' => $dataProviderCalonSiswa,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    // 'id',
                    'nama',
                    'no_pendaftaran',
                    'no_hp',
                    // 'user_id',
                    [
                        'attribute' => 'jurusan_id',
                        'value' => function ($model) {
                            return $model->jurusan ? $model->jurusan->nama : null;
                        },
                    ],
                    //'created_at',
                    //'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, CalonSiswaModel $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

          <?php Pjax::end(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
