<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
 $session = Yii::$app->session;

/* @var $this yii\web\View */
/* @var $model backend\models\Colorsystem */
/* @var $form yii\widgets\ActiveForm */
 session_start();
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
   ?>

<style type="text/css">
   .btn-primary{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .btn-primary:hover, .btn-primary:active, .btn-primary.hover {
    background-color:<?php echo $color_code;?>;
}
.btn-primary:hover {
   
    border-color:<?php echo $color_code;?>;
}
</style>
<div id="page-content">
   <div class="">
      <div class="eq-height">
         <div class="panel">
            <div class="panel-body   ">
               <?php $form = ActiveForm::begin(['options' => ['enctype'=>'multipart/form-data']]); ?>
               <div class="row">
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Name</h3> -->
                     <label class="control-label">Color Code</label>
                    <?= $form->field($model, 'color_code')->textInput(['maxlength' => true])->label(false) ?>
                  </div>
                  <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Location</h3> -->
                     <label class="control-label">APK Version</label>
                     <?= $form->field($model, 'color_name')->textInput(['maxlength' => true,'onkeypress'=>'return isNumberKey(event)'])->label(false) ?>
                  </div>
                   <div class='col-sm-6 form-group' >
                     <!-- <h3 class="panel-title" style=" position: relative;right: 14px;">Branch Location</h3> -->
                     <label class="control-label">Force Update Status</label>
                     <?= $form->field($model, 'force_update')->textInput(['maxlength' => true])->label(false) ?>
                  </div>
                

                   

                  
              
               
               
             
			    </div>
            </div>
            <br>
            <br>
            <div class="panel-footer text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Add Category' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <nav></nav>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
   function isNumberKey(evt)
       {
          var charCode = (evt.which) ? evt.which : evt.keyCode;
          if (charCode != 46 && charCode > 31 
            && (charCode < 48 || charCode > 57))
             return false;

          return true;
       }

</script>