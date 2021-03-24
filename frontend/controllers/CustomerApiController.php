<?php
namespace frontend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\InvoiceAccessoriesGrouping;
use yii\helpers\ArrayHelper;
use backend\models\CategoryManagement;
use backend\models\VideoManagement;
use backend\models\HomeManagement;
use backend\models\Colorsystem;
use backend\models\FlashScreen;
use backend\models\CategoryManagementSearch;
use yii\web\UploadedFile;
use backend\models\WsDamageVehicleImage;
use yii\db\Expression;
class CustomerApiController extends Controller
{  
	/** 
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($action) {
    $this->enableCsrfValidation = false;
    return parent::beforeAction($action);
}
 /*public function beforeAction($action) {    
	$params = (Yii::$app->request->headers);
	if($authorization=$params['authorization']){		
		$this->enableCsrfValidation = false;
    	return parent::beforeAction($action);
	}else{
		$list['status'] = 'error';
		$list['message'] = 'Bad Request ';
		$response=$list;
		echo json_encode($response);
		die;
	}
} */
/*function authorization(){  
	$params = (Yii::$app->request->headers);
	$authorization=$params['authorization'];
	$authorization=str_replace('Bearer', '', $authorization);
	$authorization=trim($authorization);
	$user_data_role = RoleAdmin::find()
					->where(['authkey'=>$authorization])
					->one();
	if($user_data_role){ 
		return $user_data_role;
	}else{ 
		return false;
	}
}*/


public function actionCategorylistyoutube(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
             $bunch_ids=$requestInput['category_id'];
            if($bunch_ids!="1"){
            $bunch_ids1=$requestInput['slug'];
            if($bunch_ids!=''){
            $bunch_ids=$requestInput['category_id'];
            }
            else{
                $bunch_ids='';
            }
            if($bunch_ids1!=''){

                $bunch_ids1=$requestInput['slug'];

            }else{

                $bunch_ids1='';
            }
            $bunchinfo_cat=CategoryManagement::find()
             ->orWhere(['auto_id'=>$bunch_ids])
             ->orWhere(['slug'=>$bunch_ids1])
            ->asArray()
            ->one();
           //  echo "<pre>";
           //  print_r($bunchinfo_cat);die;
    /******** pagination start *********/   
        $page = 1;
        $start = 10;
        $limit = 10;
        $bunchinfo_cat2=$bunchinfo_cat['auto_id'];
         if(isset($requestInput['page'])){
          //  print_r("expression");die;
         if($requestInput['page']=="all") {
            $page = $requestInput['page'];
           
            $bunchinfo=VideoManagement::find()
            ->where(['IN','auto_id',$bunchinfo_cat2])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
          //  ->limit($start)
            ->all();
        }else{
            if(isset($requestInput['page'])){
            $page = $requestInput['page'];
            if (!is_numeric($page)) {
                $page = 1;
            }
            $start = $page * $limit;
            $bunchinfo=VideoManagement::find()
            ->where(['IN','auto_id',$bunchinfo_cat2])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit($start)
            ->all();
            }
        }
        }
           /********** pagination end  **********/
        //  echo "<pre>"; print_r($bunchinfo);die;
            $result_array=array();
            if(!empty($bunchinfo)){
              //print_r("rr");die;
            $bunchinfor_index=ArrayHelper::index($bunchinfo,'auto_id');
            foreach ($bunchinfo as $value) {
                    $base=Url::base(true);
            	    $arr=array();
                    $arr['youtube_url']=$value['youtube_url'];
                    $arr['video_name']=$value['video_name'];
                    if($value['video_image']!=''){
                    $arr['video_image']=$base."/backend/web/".$value['video_image'];
                   }else{
                    $arr['video_image']='';
                   }
                    $arr['favourite']=$value['video_type'];
                    $arr['you_desc']=$value['you_desc'];
                    $arr['you_id']=$value['youtube_id'];
                    $arr['category_name']=$bunchinfo_cat['category_name'];
                    //print_r($value['medium']);die;
                    if($value['high']!=""){

                    $arr['medium']=$value['high'];
                  }else{
                    $arr['medium']="";
                  }
                  if($value['publish_date']!=""){

                    $arr['publish_date']=date('d-M-Y h:i A',strtotime($value['publish_date']));
                  }else{
                    $arr['publish_date']="";
                  }
                    $arr['category_id']=$bunchinfo_cat['auto_id'];
                     $arr['slug']=$bunchinfo_cat['slug'];
                    $result_array=$arr;

                    //print_r($result_array);die;

                    if($value['video_type']=="YES"){

                    	$favourite=$arr;
                    }else{
						         $favourite=array();                    	
                    }
                    $list['results'][]=$result_array;
                    if(!empty($favourite)){
                    $list['favourite'][]=$favourite;
                  }else{
                   
                  }
                   }
            $list['status']='success';
            $list['message'] ='Total Video List';   
            }
            else{
            $list['status']='error';
            $list['message'] ='Total Video List'; 
            }
                          
        }else{
            $bunch_ids1=$requestInput['slug'];
            if($bunch_ids!=''){
            $bunch_ids=$requestInput['category_id'];
            }
            else{
                $bunch_ids='';
            }
            if($bunch_ids1!=''){

                $bunch_ids1=$requestInput['slug'];
            }else{
                $bunch_ids1='';
            }
            $bunchinfo_cat=CategoryManagement::find()
             ->orWhere(['auto_id'=>$bunch_ids])
             ->orWhere(['slug'=>$bunch_ids1])
            ->asArray()
            ->one();
            // echo "<pre>";
           //  print_r($bunchinfo_cat);die;
    /******** pagination start *********/   
        $page = 1;
        $start = 10;
        $limit = 10;
        $bunchinfo_cat2=$bunchinfo_cat['auto_id'];
         if(isset($requestInput['page'])){
         if ($requestInput['page']=="all") {
            $page = $requestInput['page'];
           
            $bunchinfo=VideoManagement::find()
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
        }else{
            if(isset($requestInput['page'])){
            $page = $requestInput['page'];
            $page = 1;
            $start = $page * $limit;
            $bunchinfo=VideoManagement::find()
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            }
            }
            }
           /********** pagination end  **********/
           // echo "<pre>"; print_r($bunchinfo_cat);die;
            $result_array=array();
            if($bunchinfo){
            $bunchinfor_index=ArrayHelper::index($bunchinfo,'auto_id');
            foreach ($bunchinfo as $value) {
              $catn=$value['auto_id'];
              $bunchinfo_catnew=CategoryManagement::find()
              ->where(['IN','auto_id',$catn])
              ->one();
               
                    $base=Url::base(true);
                    $arr=array();
                    $arr['youtube_url']=$value['youtube_url'];
                    $arr['video_name']=$value['video_name'];
                    if($value['video_image']!=''){
                    $arr['video_image']=$base."/backend/web/".$value['video_image'];
                   }else{
                    $arr['video_image']='';
                   }
                    $arr['favourite']=$value['video_type'];
                    $arr['you_desc']=$value['you_desc'];
                    $arr['you_id']=$value['youtube_id'];
                    $arr['category_name']=$bunchinfo_catnew['category_name'];

                   // print_r($value['medium']);die;
                     if($value['high']!=""){

                    $arr['medium']=$value['high'];
                  }else{
                    $arr['medium']="";
                  }
                  if($value['publish_date']!=""){

                   $arr['publish_date']=date('d-M-Y h:i A',strtotime($value['publish_date']));
                  }else{
                    $arr['publish_date']="";
                  }
                    $arr['category_id']=$bunchinfo_catnew['auto_id'];
                     $arr['slug']=$bunchinfo_cat['slug'];
                    $result_array=$arr;
                    
                    if($value['auto_id']=="1"){
                    if($value['video_type']=="YES"){

                        $favourite=$arr;
                    }else{
                        $favourite=array();                     
                    }
                    }
                    $list['results'][]=$result_array;
                    if(!empty($favourite)){
                    $list['favourite']=array($favourite);
                  }else{
                   
                  }
                }   
            }
            $list['status']='success';
            $list['message'] ='Total Video List';
        }
        }
       // $response=$list;
        return json_encode($list);
 }


 //Related Videos

 public function actionCategorylistrelatedvideo(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);


         //print_r($postd);die;
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
         
            $bunch_ids=$requestInput['category_id'];
            $video_Idn=isset($requestInput['youtube_id']);
            //$bunch_ids1=$requestInput['slug'];
            if($bunch_ids!=''){
            if($video_Idn!=''){
            $bunch_ids=$requestInput['category_id'];
            $video_Idn=$requestInput['youtube_id'];
            $bunchinfo1222=VideoManagement::find()
            ->where(['auto_id'=>$bunch_ids])
            ->andWhere(['not',['youtube_id'=>$video_Idn]])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            if(!empty($bunchinfo1222)){
             $bunchinfo122=$bunchinfo1222;
            }else{
            $bunchinfo122=VideoManagement::find()
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();

            }
              }
            else{
            $bunch_ids=$requestInput['category_id'];
            $bunchinfo122=VideoManagement::find()
            ->where(['auto_id'=>$bunch_ids])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            }
            }
            else{
            $bunch_ids='';
            $bunchinfo122=VideoManagement::find()
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            }       
            
            $result_array=array();
            if($bunchinfo122){
            $bunchinfor_index=ArrayHelper::index($bunchinfo122,'auto_id');
            foreach ($bunchinfo122 as $value) {
                   $bunchinfo_cat=CategoryManagement::find()
                   ->orWhere(['auto_id'=>$value['auto_id']])
                   ->one();
                    $base=Url::base(true);
                    $arr=array();
                    $arr['youtube_url']=$value['youtube_url'];
                    $arr['video_name']=$value['video_name'];
                    if($value['video_image']!=''){
                    $arr['video_image']=$base."/backend/web/".$value['video_image'];
                   }else{
                    $arr['video_image']='';
                   }
                    $arr['favourite']=$value['video_type'];

                 if($value['publish_date']!=""){

                  $arr['publish_date']=date('d-M-Y h:i A',strtotime($value['publish_date']));
                  }else{
                    $arr['publish_date']="";
                  }
                    $arr['medium']=$value['high'];
                    $arr['you_desc']=$value['you_desc'];
                    $arr['you_id']=$value['youtube_id'];
                    $arr['category_name']=$bunchinfo_cat['category_name'];
                    $arr['category_id']=$bunchinfo_cat['auto_id'];
                     $arr['slug']=$bunchinfo_cat['slug'];
                    $result_array=$arr;

                    if($value['video_type']=="YES"){

                        $favourite=$arr;
                    }else{
                        $favourite=array();                     
                    }
                    $list['results'][]=$result_array;
                   }   
            }
            $list['status']='success';
            $list['message'] ='Total Video List';              
        }
       // $response=$list;
        return json_encode($list);
 }

 public function actionCategorylistrelatedvideodetail(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);


         //print_r($postd);die;
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
         
            $bunch_ids=$requestInput['category_id'];
            $video_Idn=isset($requestInput['youtube_id']);

            //$bunch_ids1=$requestInput['slug'];
            if($bunch_ids!=''){
            if($video_Idn!=''){
            $bunch_ids=$requestInput['category_id'];

            $bunchinfo1222=VideoManagement::find()
            ->where(['auto_id'=>$bunch_ids])
            ->andWhere(['not',['youtube_id'=>$video_Idn]])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            if(!empty($bunchinfo1222)){
             $bunchinfo122=$bunchinfo1222;
            }else{
            $bunchinfo122=VideoManagement::find()
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();

            }
              }
            else{
            $bunch_ids=$requestInput['category_id'];
            $bunchinfo122=VideoManagement::find()
            ->where(['auto_id'=>$bunch_ids])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->limit(10)
            ->all();
            }
            }
            else{
            $bunch_ids='';
            $video_Idn=$requestInput['youtube_id'];

            $video=explode(',', $video_Idn);
            //print_r($video);die;
            $bunchinfo122=VideoManagement::find()
            ->where(['IN','youtube_id',$video])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->all();
            }       
            
            $result_array=array();
            if($bunchinfo122){
            $bunchinfor_index=ArrayHelper::index($bunchinfo122,'auto_id');
            foreach ($bunchinfo122 as $value) {
                   $bunchinfo_cat=CategoryManagement::find()
                   ->orWhere(['auto_id'=>$value['auto_id']])
                   ->one();
                    $base=Url::base(true);
                    $arr=array();
                    $arr['youtube_url']=$value['youtube_url'];
                    $arr['video_name']=$value['video_name'];
                    if($value['video_image']!=''){
                    $arr['video_image']=$base."/backend/web/".$value['video_image'];
                   }else{
                    $arr['video_image']='';
                   }
                    $arr['favourite']=$value['video_type'];

                 if($value['publish_date']!=""){

                  $arr['publish_date']=date('d-M-Y h:i A',strtotime($value['publish_date']));
                  }else{
                    $arr['publish_date']="";
                  }
                    $arr['medium']=$value['high'];
                    $arr['you_desc']=$value['you_desc'];
                    $arr['you_id']=$value['youtube_id'];
                    $arr['category_name']=$bunchinfo_cat['category_name'];
                    $arr['category_id']=$bunchinfo_cat['auto_id'];
                     $arr['slug']=$bunchinfo_cat['slug'];
                    $result_array=$arr;

                    if($value['video_type']=="YES"){

                        $favourite=$arr;
                    }else{
                        $favourite=array();                     
                    }
                    $list['results'][]=$result_array;
                   }   
            }
            $list['status']='success';
            $list['message'] ='Total Video List';              
        }
       // $response=$list;
        return json_encode($list);
 }
 //Related Videos End
 public function actionCategorylist(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
           // $bunchinfo=VideoManagement::find()->where(['IN','auto_id',$bunch_ids])->asArray()->all();
            $bunchinfo_cat=CategoryManagement::find()
            ->where(['active_status'=>"1"])
            ->asArray()
            ->all();
            $result_array=array();
            if($bunchinfo_cat){
            
            $bunchinfor_index=ArrayHelper::index($bunchinfo_cat,'auto_id'); 
            $base=Url::base(true);
            foreach ($bunchinfo_cat as $value) {
            	$arr=array();
            	 $arr['auto_id']=$value['auto_id'];
                 $arr['category_name']=$value['category_name'];
                 $arr['slug']=$value['slug'];

                 $arr['category_desc']=$value['category_desc'];
                 if($value['category_image']!=''){
                 $arr['category_image']=$base."/backend/web/".$value['category_image'];
                }else{
                	 $arr['category_image']='';
                }
                 $result_array[]=$arr;
                      }          
            }
            $list['status']='success';
            $list['message']='Total Category List';  
            $list['results']=$result_array;
        }
        $response=$list;
        return json_encode($response);
 }
 //Favorite List

 public function actionCategorylistfav(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  

        if($requestInput['authkey']=="youtubeapi"){

         $bunchinfo_cat=VideoManagement::find()->select(['video_id'=>'video_id',
            'youtube_url'=>'youtube_url','video_name'=>'video_name',
            'video_image'=>'video_image','you_desc'=>'you_desc','youtube_id'=>'youtube_id',
            'video_type'=>'video_type','auto_id'=>'auto_id','auto_id1'=>'COUNT(auto_id)','active_status'=>'active_status'
        ])
          ->where(['active_status'=>"1"])
          ->andWhere(['NOT IN','auto_id',['1']])
          ->orderBy(['COUNT(auto_id)'=>SORT_DESC])
          ->groupBy(['auto_id'=>'auto_id'])
          ->asArray()
          ->all();
          $index_bunch_map=ArrayHelper::map($bunchinfo_cat,'video_id','auto_id');
         // echo '<pre>';
         // echo $bunchinfo_cat->createCommand()->getRawSql();
          $bunchinfo_cat_index=VideoManagement::find()->select(['video_id'=>'video_id',
            'youtube_url'=>'youtube_url','video_name'=>'video_name',
            'video_image'=>'video_image','you_desc'=>'you_desc','youtube_id'=>'youtube_id',
            'video_type'=>'video_type','auto_id'=>'auto_id','auto_id1'=>'COUNT(auto_id)','active_status'=>'active_status'
          ])
          ->where(['active_status'=>"1"])
          ->andWhere(['IN','auto_id',$index_bunch_map])
          ->andwhere(['video_type'=>"YES"])
          ->groupBy(['auto_id'=>'auto_id'])
          ->asArray()
          ->all();


         $index_bunch=ArrayHelper::index($bunchinfo_cat_index,'auto_id');


         $bunchinfo_home=HomeManagement::find()
         ->asArray()
         ->one();

         $home=$bunchinfo_home['youtubelink'];
         $home1=$bunchinfo_home['youtube_id'];
         $base=Url::base(true);
         $result_array=array();
         $arrnew=array();
         $arrnew['youtubelink']= $home;
         $arrnew['youtube_id']= $home1;
          $list['homepage']=$arrnew;
          if($bunchinfo_cat){

          foreach ($bunchinfo_cat as $value) {
           $bunchinfo_catte=CategoryManagement::find()
           ->select(['category_name','slug','category_image'])
           ->where(['auto_id'=>$value['auto_id']])
           ->asArray()
           ->one();
            $categorynamemain=strtoupper($bunchinfo_catte['category_name']);
             $categoryslug=$bunchinfo_catte['slug'];

              $categoryslugimage=$bunchinfo_catte['category_image'];
          
          if(array_key_exists($value['auto_id'], $index_bunch))
          {  
            // if($value['video_type']=="YES"){

            	    $arr=array();
                    $arr['youtube_url']=$index_bunch[$value['auto_id']]['youtube_url'];
                    $arr['favourite']=$index_bunch[$value['auto_id']]['video_type'];
                    $arr['you_desc']=$index_bunch[$value['auto_id']]['you_desc'];
                    $arr['video_name']=$index_bunch[$value['auto_id']]['video_name'];
                    $arr['you_id']=$index_bunch[$value['auto_id']]['youtube_id'];

                     if($value['video_image']!=''){
                     // $arr['category_image']=$base."/backend/web/".$value['category_image'];
                     $arr['video_image']=$base."/backend/web/".$index_bunch[$value['auto_id']]['video_image'];
                      }else{
                     $arr['video_image']='';
                     }
                      
                      if($categoryslugimage!=''){
                     $list1['category_image']=$base."/backend/web/".$categoryslugimage;
                 }else{
                    $list1['category_image']='';
                 }
                    $arr['category_name']=strtoupper($categoryslug);
                    $favourite=$arr;		
                    $list1['categoryname']=strtoupper($categoryslug);
               		$list1['categoryid']=$index_bunch[$value['auto_id']]['auto_id'];
                    $list1['favourite']=$favourite;
                    $list['categorylist'][]=$list1;
                    //$result_array[$categorynamemain]['favourite'][]=$favourite;
                   //}
               }
                    }    
                }
            $list['status']='success';
            $list['message'] ='Total Category List'; 
        }
        
       // $response=$list;
        return json_encode($list);
 }

 //Home category

 public function actionCategorylistfavhome(){
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  

        if($requestInput['authkey']=="youtubeapi"){
         $bunchinfo_cat=VideoManagement::find()
         ->where(['active_status'=>"1"])
         ->orderBy(['auto_id'=>SORT_ASC])
         ->asArray()->all();
          $bunchinfo_home=HomeManagement::find()
         ->asArray()->one();
         $home=$bunchinfo_home['youtubelink'];
         $home1=$bunchinfo_home['youtube_id'];
         $base=Url::base(true);
         $result_array=array();
         $arrnew=array();
         $color=Colorsystem::find()
         ->asArray()->one();
         $flashscreen=FlashScreen::find()
         ->asArray()->one();
         if($flashscreen['bg_screen']!=''){
                    
                     $list['bg_image']=$base."/backend/web/".$flashscreen['bg_screen'];
                      }else{
                     $list['bg_image']='';
                     }
                     if($flashscreen['title_screen']!=''){
                     
                     $list['title_image']=$base."/backend/web/".$flashscreen['title_screen'];
                      }else{
                     $list['title_image']='';
                     }  

         $list['color_code']=$color['color_code'];
         $list['apk_version']=$color['color_name'];
         if($color['force_update']!=""){

         $list['force_update']=$color['force_update'];
     }else{
        $list['force_update']="yes";
     }
         $arrnew['youtubelink']= $home;
         $arrnew['youtube_id']= $home1;
         $list['homepage']=$arrnew;
          
        if($bunchinfo_cat){
          foreach ($bunchinfo_cat as $value) {
           $bunchinfo_catte=CategoryManagement::find()
           ->select(['category_name','slug','category_image','category_icon'])
           ->where(['auto_id'=>$value['auto_id']])
           ->andWhere(['home_status'=>'1'])
           ->asArray()
           ->one();
            $categorynamemain=ucfirst($bunchinfo_catte['category_name']);
            $categoryslug=$bunchinfo_catte['slug'];
            $categoryslugimage=$bunchinfo_catte['category_image'];
            $categoryslugimage1=$bunchinfo_catte['category_icon'];
            if($categorynamemain!=""){
             if($value['video_type']=="YES"){
                    $arr=array();
                    $arr['youtube_url']=$value['youtube_url'];
                    $arr['favourite']=$value['video_type'];
                    $arr['you_desc']=$value['you_desc'];
                    $arr['video_name']=$value['video_name'];
                    $arr['you_id']=$value['youtube_id'];

                     if($value['video_image']!=''){
                     // $arr['category_image']=$base."/backend/web/".$value['category_image'];
                     $arr['video_image']=$base."/backend/web/".$value['video_image'];
                      }else{
                     $arr['video_image']='';
                     }    
                if($categoryslugimage!=''){
                $list1['category_image']=$base."/backend/web/".$categoryslugimage;
                 }else{
                    $list1['category_image']='';
                 }
                 if($categoryslugimage1!=''){
                $list1['category_icon']=$base."/backend/web/".$categoryslugimage1;
                 }else{
                    $list1['category_icon']='';
                 }
                    $arr['category_name']=ucfirst($categoryslug);
                    $favourite=$arr;        
                    $list1['categoryname']=ucfirst($categoryslug);
                    $list1['categoryid']=$value['auto_id'];
                    $list1['favourite']=$favourite;
                    $list['categorylist'][]=$list1;
                    //$result_array[$categorynamemain]['favourite'][]=$favourite;
                   }
                   }
                    }    
                }
            $list['status']='success';
            $list['message'] ='Total Home Category List'; 
        }
        
       // $response=$list;
        return json_encode($list);
 }

}
