<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\VideoManagement */
$this->params['breadcrumbs'][] = ['label' => 'Video Managements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="video-management-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            
            'video_name',
            'youtube_url:url',
            'you_desc',
            'youtube_id',
            'video_type',
            'category_name',
          [
                'attribute' =>   'video_image',
                'value'=>$model->video_image,           
               'format' => ['image',['width'=>'80']],
            ],
            
        ],
    ]) 
    ?>

</div>
