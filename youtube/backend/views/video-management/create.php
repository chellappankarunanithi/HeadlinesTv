<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */

$this->title = 'Create Video Management';
$this->params['breadcrumbs'][] = ['label' => 'Video Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-management-create">

      <div class="box box-primary  ">
	  <div class=" ">
   
    	<div class=" box-header with-border box-header-bg">
	      <h3 class="box-title "><i class="fa fa-fw fa-plus-square"></i><?= Html::encode($this->title) ?></h3>
</div>
</div>
</div>
    <?= $this->render('_form', [
        'model' => $model,
        'catgorylist'=>$catgorylist,
    ]) ?>


</div>
