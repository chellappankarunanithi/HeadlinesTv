<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Userdetails */

$this->title = 'Update User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="userdetails-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
