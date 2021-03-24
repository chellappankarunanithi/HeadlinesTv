<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\Colorsystem */

$this->title = 'App Management';
$this->params['breadcrumbs'][] = ['label' => 'App Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="colorsystem-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
