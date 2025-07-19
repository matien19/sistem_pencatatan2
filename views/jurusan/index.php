<?php

use app\models\JurusanModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchJurusanModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Jurusan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="jurusan-model-index">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
            <?php Pjax::begin(); ?>
            <?= Html::a('Tambah data', ['create'], ['class' => 'btn btn-success']) ?>

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'nama',
                    [
                        'class' => ActionColumn::className(),
                        'urlCreator' => function ($action, JurusanModel $model, $key, $index, $column) {
                            return Url::toRoute([$action, 'id' => $model->id]);
                        }
                    ],
                ],
            ]); ?>

            <?php Pjax::end(); ?>
        </div>
    </div>

</div>
