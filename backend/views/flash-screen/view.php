<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FlashScreen */

$this->title = $model->flash_id;
$this->params['breadcrumbs'][] = ['label' => 'Splash Screens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flash-screen-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->flash_id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->flash_id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'flash_id',
            'flash_name',
            'bg_screen',
            'title_screen',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
