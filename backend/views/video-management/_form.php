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
<div class="video-management-form">
   <?php $form = ActiveForm::begin(); ?>
   <div class="panel">
      <div class="panel-body">
         <div class="row">
            <div class="col-sm-6">	
               <?= $form->field($model, 'video_name')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">	
               <?= $form->field($model, 'youtube_url')->textInput(['maxlength' => true]) ?>
            </div>
		 </div>
		 <div class="row">
            <div class="col-sm-6">
               <?= $form->field($model, 'you_desc')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-sm-6">
               <?= $form->field($model, 'youtube_id')->textInput(['maxlength' => true]) ?>
            </div>
		 </div>
		 <div class="row">
            <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">User Name</h3> -->
                     <label class="control-label">Video Image</label>
                     <?= $form->field($model, 'video_image')->fileInput(['id'=> 'video_image','maxlength' => true,'class'=>'form-control upper','placeholder'=>'Video Image'])->label(false) ?>
                  </div>
            <div class="col-sm-2"> 
               <?php if($model->isNewRecord){ ?>
               <?php 
                  echo $form->field($model, 'auto_id')->dropDownList($catgorylist,['prompt'=>'--Select Category--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select Category');?>
               <?php }else{ ?>
               <?php 
                  echo $form->field($model, 'auto_id')->dropDownList($catgorylist,['prompt'=>'--Select Category--','data-live-search'=>'true','class'=>'form-control selectpicker tabind','data-style'=>'btn-default btn-custom'])->label('Select Category');?>
               <?php } ?>
            </div>
			</div>
			<div class="row">
            <div class="col-sm-2"  >
               <?=$form->field($model, 'video_type')->radioList(['No' => 'No','YES' => 'Yes'],['id'=>'new','name'=>'video_type'])->label('Favourite Type'); ?> 
            </div>
			
			
			 <?php 
                  if($model->isNewRecord){
                  $model->active_status = 1;
                  }?>
			
            <div class='col-sm-2 form-group'>
			  
               <?= $form->field($model, 'active_status', [
                  'template' => "<div class='checkbox checkbox-custom' style='margin-top:30px; margin-left:20px;'>{input}<label>Active</label></div>{error}",
                  ])->checkbox([],false)->label('Status'); ?>  
            </div>
         </div>
         <!--   <? // = $form->field($model, 'active_status')->textInput() ?> -->
         <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? 'Save' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success pull-right' : 'btn btn-primary pull-right']) ?>
         </div>
      </div>
   </div>
   <?php ActiveForm::end(); ?>
</div>