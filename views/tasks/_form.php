<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(['id' => 'blog-form', 'options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'user_id')->hiddenInput() ?>

    <?= $form->field($model, 'title')->textarea(['rows' => 6]) ?>

<!--    --><?//= $form->field($model, 'file')->textInput(['maxlength' => true]) ?>

    <?php
    if(isset($model->image) && file_exists(Yii::getAlias('@webroot', $model->image)))
    {
        echo Html::img($model->image, ['class'=>'img-responsive']);
        echo $form->field($model,'del_img')->checkBox(['class'=>'span-1']);
    }
    ?>
    <?= $form->field($model, 'file')->fileInput() ?>

    <?= $form->field($model, 'created_at')->hiddenInput() ?>

    <?= $form->field($model, 'updated_at')->hiddenInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <?php //Если картинка для данного товара загружена, предложить её удалить, отметив чекбокс
    if(isset($model->image) && file_exists($_SERVER['DOCUMENT_ROOT'].
            \Yii::$app->urlManager->baseUrl.
            '/images/'.substr($model->create_time, 0, 4).'/'.$model->image))
    {
        echo $form->checkBox($model,'del_img',array('class'=>'span-1'));
        echo $form->labelEx($model,'del_img',array('class'=>'span-2'));
    }
    ?>
    <br />

</div>
