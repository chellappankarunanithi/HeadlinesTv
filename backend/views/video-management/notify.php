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
       
      
          <div class="col-sm-12">
            <div class="col-sm-6">
              <label>Video Name</label>
               <textarea name="notitydata" class="form-control" rows="4"><?php echo $model['video_name'];?></textarea>
            </div>
            <div class="col-sm-6">
              <label>Notification Message</label>
               <input type="textarea" name="notitymessage" value="New Video Uploaded" class="form-control">
            </div>
          </div>
        </div>
        <br>
            <div class="panel-footer text-right">
               <?= Html::submitButton($model->isNewRecord ? 'Send' : 'Send', ['class' => $model->isNewRecord ? 'btn btn-create createBtn btn-success' : 'btn btn-primary','required'=>true]) ?>
            </div>
            <?php ActiveForm::end(); ?>
            <nav></nav>
         </div>
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