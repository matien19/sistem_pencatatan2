<?php

use app\models\KelasModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchKelasModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Kelas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kelas-model-index">
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

                    [
                        'label' => 'Nama Kelas',
                        'value' => function ($model) {
                            return $model->kelas . $model->nama;
                        },
                    ],
                    [
                        'attribute' => 'Jurusan',
                        'value' => function ($model) {
                            return $model->jurusan ? $model->jurusan->nama : null;
                        },
                    ],
                    'tahun_masuk',
                    //'created_at',
                    //'updated_at',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, KelasModel $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
                'pager' => [
                    'firstPageLabel' => 'Pertama',
                    'lastPageLabel' => 'Terakhir',
                    'prevPageLabel' => '<i class="fas fa-angle-left"></i>',
                    'nextPageLabel' => '<i class="fas fa-angle-right"></i>',
                    'maxButtonCount' => 5,
                    'options' => ['class' => 'pagination justify-content-center'],
                    'activePageCssClass' => 'active bg-success text-white',
                    'disabledPageCssClass' => 'disabled',
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>
</div>
