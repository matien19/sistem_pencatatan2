<?php

use app\models\TagihanModel;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/** @var yii\web\View $this */
/** @var app\models\SearchTagihanModel $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Data Tagihan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tagihan-model-index">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="card-body">
           <?= GridView::widget([
               'dataProvider' => $dataProvider,
            //    'filterModel' => $searchModel,
               'columns' => [
                //    'id',
                   'siswa_id',
                   'jenis_pembayaran_id',
                   'total_tagihan',
                   'status',
                   'tanggal_jatuh_tempo',
                   ['class' => ActionColumn::className()],

               ],
           ]); ?>
        </div>
    </div>
</div>
   