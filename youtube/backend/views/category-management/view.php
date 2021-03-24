<?php
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\CategoryManagement */


$this->params['breadcrumbs'][] = ['label' => 'Category Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-management-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           
            'category_name',
            'category_desc:ntext',
        
             [
                'attribute' =>   'category_image',
                'value'=>$model->category_image,           
               'format' => ['image',['width'=>'80']],
            ],

        ],
    ]) ?>

</div>
