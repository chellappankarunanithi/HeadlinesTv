<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HomeManagement */

$this->title = 'Home Management ';
$this->params['breadcrumbs'][] = ['label' => 'Home Managements', 'url' => ['index']];

$this->params['breadcrumbs'][] = 'Update';
?>
<div class="home-management-update">

     <div class="box box-primary">
	 <div class=" box-header with-border box-header-bg">
    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
	
	</div>
	</div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
