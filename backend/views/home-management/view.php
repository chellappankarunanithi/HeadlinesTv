<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\HomeManagement */

//$this->title = $model->home_id;
$this->params['breadcrumbs'][] = ['label' => 'Home Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="home-management-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'youtubelink',
            'youtube_id',
        ],
    ]) ?>

</div>
