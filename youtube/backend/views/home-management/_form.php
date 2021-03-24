<?php
   use yii\helpers\Html;
   use yii\widgets\ActiveForm;
   
   /* @var $this yii\web\View */
   /* @var $model backend\models\HomeManagement */
   /* @var $form yii\widgets\ActiveForm */
   ?>
<div class="home-management-form">
   <div class="panel">
      <div class="panel-body   ">
         <?php $form = ActiveForm::begin(); ?>
         <div class="row">
            <div class="col-sm-6">
               <?= $form->field($model, 'youtubelink')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
               <?= $form->field($model, 'youtube_id')->textInput(['maxlength' => true]) ?>
            </div>
         </div>
         <div class="form-group pull-right">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
         </div>
         <?php ActiveForm::end(); ?>
      </div>
   </div>
</div>