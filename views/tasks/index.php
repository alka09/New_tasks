<?php

use app\models\Tasks;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Tasks', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'title:ntext',
            'file',
            ['attribute' => 'created_at', 'format' => ['date', 'php:d-m-Y H:i:s']],
            ['attribute' => 'updated_at', 'format' => ['date', 'php:d-m-Y H:i:s']],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
