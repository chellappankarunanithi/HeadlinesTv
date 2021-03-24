<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ApiFetchDetails */

$this->title = 'Update Api Fetch Details: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Api Fetch Details', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="api-fetch-details-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
