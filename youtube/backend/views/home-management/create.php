<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\HomeManagement */

$this->title = 'Create Home Management';
$this->params['breadcrumbs'][] = ['label' => 'Home Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-management-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
