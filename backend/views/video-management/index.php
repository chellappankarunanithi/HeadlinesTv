<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
$session = Yii::$app->session;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\VideoManagementSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Managements';
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
<div class="video-management-index">



      <div class="box box-primary  ">
    <div class=" ">
   
      <div class=" box-header with-border box-header-bg">
          <h3 class="box-title "><?= Html::encode($this->title) ?></h3>
          <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
          <?= Html::a('Add Video', ['create'], ['class' => 'btn btn-success pull-right']) ?>
  </div>
  </div>
  
  <div class="table-responsive">
  
  <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            
            'video_name',
            //'auto_id',
            'youtube_id',
            'category_name',
            'video_type',

          //   ['attribute'=>'last_notify_date',
          //   'value'=>function($models, $keys){
            
          //     if($models->last_notify_date!=""){
          //     return $models->last_notify_date;
          //    }else{
          //       return  "";
          //    }
          //   },
          // ],

          ['attribute'=>'last_notify_date',
          'format' => 'html',
          'contentOptions'=>['style'=>'width:173px;'],
               'value' => function($model, $key, $index){
                   $datee1 = ucwords(date("d-m-Y - h:i:s  A ",strtotime($model->last_notify_date)));
                  if(strpos($datee1, '0000')){
                      $datee1 =  "-";
                  }elseif (strpos($datee1, '1970')) {
                      $datee1 =  "-";
                  } 
                  return $datee1;
           },
            ],
            
              ['attribute'=>'medium',
             'format' => ['image',['width'=>'80']],
            'value'=>function($models, $keys){
            
              if($models->medium!=""){
              return $models->medium;
             }else{
                return  "";
             }
            },
          ],
           // ['class' => 'yii\grid\ActionColumn'],

          ['class' => 'yii\grid\ActionColumn',
               'header'=> 'Action',
                 'headerOptions' => ['style' => 'width:150px;color:#337ab7;'],
               'template'=>'{view}{update}{delete}{notity1}{refresh}',
                            'buttons'=>[
                              'view' => function ($url, $model, $key) {
                               
                                   // return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, $options);
                                   return Html::button('<i class="glyphicon glyphicon-eye-open"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'View' ]);
                                }, 
                             'update' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-warning btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Update'),
                                            'aria-label' => Yii::t('yii', 'Update'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-edit"></span>', $url, $options);
                                    },
                              
                                'delete' => function ($url, $model, $key) {
                                   
                                    
                                        return Html::button('<i class="fa fa-trash"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-danger btn-xs delete gridbtncustom modalDelete', 'data-toggle'=>'tooltip', 'title' =>'Delete' ]);
                                  },
                                  'notity1' => function ($url, $model, $key) {
                                   
                                    
                                        return Html::button('<i class="fa fa-plus"></i>', ['value' => $url, 'style'=>'margin-right:4px;','class' => 'btn btn-primary btn-xs view view gridbtncustom modalView', 'data-toggle'=>'tooltip', 'title' =>'Notify' ]);
                                  },
                                  'refresh' => function ($url, $model, $key) {
                                        $options = array_merge([
                                            'class' => 'btn btn-success btn-xs update gridbtncustom',
                                            'data-toggle'=>'tooltip',
                                            'title' => Yii::t('yii', 'Refresh'),
                                            'aria-label' => Yii::t('yii', 'Refresh'),
                                            'data-pjax' => '0',
                                        ]);
                                        return Html::a('<span class="fa fa-refresh"></span>', $url, $options);
                                    },

                          ] ],
        ],
    ]); ?></div>
<?php Pjax::end(); ?></div></div>

<script type="text/javascript">
     $('body').on("click",".modalView",function(){
            
             var url = $(this).attr('value');
             $('#operationalheader').html('<span> <i class="fa fa-fw fa-th-large"></i>Notification</span>');
             $('#operationalmodal').modal('show').find('#modalContenttwo').load(url);
             return false;
         });
		 $(document).ready(function(){
			$('#w1').removeClass('grid-view') 
		 });
</script>

