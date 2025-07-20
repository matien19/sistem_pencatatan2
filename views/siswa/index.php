<?php

use app\models\SiswaModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchSiswaModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Siswa';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="siswa-model-index">

    <div class="card">
      <div class="card-header">
          <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
      </div>
      <div class="card-body">
        <p>
          <?= Html::a('Tambah Data', ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?php Pjax::begin(); ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?= GridView::widget([
          'dataProvider' => $dataProvider,
          // 'filterModel' => $searchModel,
          'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'nama',
            'nisn',
            'no_hp',
            // 'user_id',
            [
              'attribute' => 'kelas_id',
              'label' => 'Kelas & Jurusan',
              'value' => function ($model) {
              // Pastikan relasi 'kelas' dan 'jurusan' sudah didefinisikan di SiswaModel
              return $model->kelas && $model->kelas->jurusan
                ? $model->kelas->jurusan->nama . ' ' . $model->kelas->kelas . $model->kelas->nama
                : null;
              },
            ],
            //'created_at',
            //'updated_at',
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
    </div>

</div>
