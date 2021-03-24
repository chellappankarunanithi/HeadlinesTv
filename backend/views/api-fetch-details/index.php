<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Fetch API Data';
$this->params['breadcrumbs'][] = $this->title;
  session_start();
   if(isset($_SESSION['color_code'])){

   $color_code=$_SESSION['color_code'];
 }else{
  $color_code="#ed1c24";
 }
?>
<style type="text/css">
   .btn-success{
    background-color:<?php echo $color_code;?>;
   color: #fff;
   border-color: <?php echo $color_code;?>;
  }
  .btn-success:hover, .btn-success:active, .btn-success.hover {
    background-color:<?php echo $color_code;?>;
}
.btn-success:hover {
   
    border-color:<?php echo $color_code;?>;
}
</style>
<div class="api-fetch-details-index">

    <div class="box box-primary  ">
    <div class=" ">
   
      <div class=" box-header with-border box-header-bg">
          <h3 class="box-title "><?= Html::encode($this->title) ?></h3>
          <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
          <?= Html::a('Fetch Data', ['create'], ['class' => 'btn btn-success pull-right']) ?>
  </div>
  </div>
  <div class="table-responsive">
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'category_name',
            [
                'attribute' => 'json_data',
                  'headerOptions' =>['style'=>'color:#ff0000;'],
                  'format' => 'html',
                        
               'headerOptions' => ['class' => 'actionPartnername'],
                'value' => function($model, $key, $index)
           {
               if($model->json_data!='')
               {
                   return  "<pre style='white-space:normal;width:300px;height:200px;'> ".$model->json_data ."</pre>";
               }else{
                return '-';
               }
                
           },
           ],
            'updated_at',

           
        ],
    ]); ?></div>
<?php Pjax::end(); ?></div></div>
