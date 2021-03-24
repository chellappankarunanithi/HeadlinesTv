<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$session = Yii::$app->session;
   /* @var $this yii\web\View */
   /* @var $model backend\models\VideoManagement */
   /* @var $form yii\widgets\ActiveForm */
    session_start();
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
   ?>
<style>
   .btn-success{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php echo $color_code;?>;
}
.btn-success:hover {
   
    border-color:<?php echo $color_code;?>;
}
.checkbox input[type="checkbox"] {
   cursor: pointer;
   opacity: 0;
   z-index: 1;
   outline: none !important;
   }
   .checkbox-custom input[type="checkbox"]:checked + label::before {
   background-color: #5fbeaa;
   border-color: #5fbeaa;
   } 
   .checkbox label::before {
   -o-transition: 0.3s ease-in-out;
   -webkit-transition: 0.3s ease-in-out;
   background-color: #ffffff;
   /* border-radius: 3px; */
   border: 1px solid #cccccc;
   content: "";
   display: inline-block;
   height: 17px;
   left: 0!important;
   margin-left: -20px!important;
   position: absolute;
   transition: 0.3s ease-in-out;
   width: 17px;
   outline: none !important;
   }
   .checkbox input[type="checkbox"]:checked + label::after {
   content: "\f00c";
   font-family: 'FontAwesome';
   color: #fff;
   position: relative;
   right: 59px;
   bottom: 1px;
   }
   .checkbox label {
   display: inline-block;
   padding-left: 5px;
   position: relative;
   }
</style>
 <div class="panel">
 <div class="panel-body">
<div class="api-fetch-details-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
    <div class="col-sm-6"> 
               <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'category_id')->dropDownList($catgorylist,['prompt'=>'--Select Category--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select Category');?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'category_id')->dropDownList($catgorylist,['prompt'=>'--Select Category--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select Category');?>
               <?php } ?>
            </div>
            </div>

   <!--  <?= $form->field($model, 'json_data')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Fetch' : 'Fetch', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</div>
   </div>