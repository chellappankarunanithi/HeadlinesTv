<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\ApiFetchDetails */

$this->title = 'Create Api Fetch Details';
$this->params['breadcrumbs'][] = ['label' => 'Api Fetch Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="api-fetch-details-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'catgorylist'=>$catgorylist,
    ]) ?>

</div>
