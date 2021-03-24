<?php

namespace backend\controllers;

use Yii;
use backend\models\VideoManagement;
use backend\models\VideoManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

use backend\models\CategoryManagement; 

/**
 * VideoManagementController implements the CRUD actions for VideoManagement model.
 */
class VideoManagementController extends Controller
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

    /**
     * Lists all VideoManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VideoManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VideoManagement model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }
public function actionNotity1($id)
{
if($_POST){

$model = $this->findModel($id);
$model2=ArrayHelper::toArray($model);
$requestInput = $_POST;

$notitydata=$requestInput['notitydata'];
$notify=$requestInput['notitymessage'];
if(!empty($model2)){
$title=$model2['video_name'];
$youtube_id=$model2['youtube_id'];
$auto_id=$model2['auto_id'];
$image=$model2['medium'];
$msg_1=array('image'=>$image,'title'=>$notitydata,'msg' => $notify,'video_id'=>$youtube_id,'cat_id'=>$auto_id);
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('to' =>"/topics/all", 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAAu7-lGI:APA91bFPHee1kUs8fnk7BBTutkuz7ZRlJsM1zpccDZWTRlo38A_q3UvHPNhWDMbIbq0LUBrbxbRjx51kAq5nI_8cH8Y12agTRyp0sOTKzDOVA_qdHpk0RCGuVSFODep6LkEs7Gz0lt_b";
//building headers for the request
$headers = array('Authorization: key=' . $apikey, 'Content-Type: application/json');
        $ch = curl_init();
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //finally executing the curl request
        $result = curl_exec($ch);
       // print_r(json_decode($result));die;
        $conditions=json_decode($result);
    //    print_r($conditions->message_id);die;
         if(isset($conditions->message_id)){
        VideoManagement::updateAll(['last_notify_date'=>date("Y-m-d H:i:s")],['video_id'=>$id]);
        Yii::$app->getSession()->setFlash('success', 'Notifications send successfully.');
         }
        //if($result[''])
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
    curl_close($ch);

        return $this->redirect(['index']);
    }else{

        Yii::$app->getSession()->setFlash('danger', 'Notifications not send.');
       
       return $this->redirect(['index']);
    }

        }else{

        }
        return $this->renderAjax('notify', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new VideoManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      
        $model = new VideoManagement();
        $catgorylist=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES){

            if ($_FILES['VideoManagement']['error']['video_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'video_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->video_image = $image_name;
            }
            }

            $cat_id=$_POST['VideoManagement']['auto_id'];

            $video_type=$_POST['video_type'];

            if($video_type=="YES"){
            $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='No' WHERE auto_id=".$cat_id);
            $command->execute();
           }
           if($_POST['video_type']!=''){
            $model->video_type=$_POST['video_type'];
           }
           // echo "<pre>";   print_r($_POST);die;
$youtube_id=$_POST['VideoManagement']['youtube_id'];
if($youtube_id!=""){
 $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id=".$youtube_id.",&key=AIzaSyB6kgcOTBIk6DU-CkGc3ZhD4WizC7RIUIw";
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_URL,$url);
 $result=curl_exec($ch);
curl_close($ch);
//echo "<pre>";print_r($result);die;
$result=json_decode($result);
$result=ArrayHelper::toArray($result);
$items_column=ArrayHelper::getColumn($result['items'],'snippet');
$snipt=$items_column[0];
 if($snipt!=""){
 $viewcount=$result['items'][0]['statistics']['viewCount'];
 $description=$snipt['description'];
 $date=$snipt['publishedAt'];
 $date= date_format(date_create($date),'Y-m-d H:i:s');
 $descdefault=$snipt['thumbnails']['default']['url'];
 $descdmedium=$snipt['thumbnails']['medium']['url'];
 $deschigh=$snipt['thumbnails']['high']['url'];
 $descstandard=$snipt['thumbnails']['standard']['url'];
 $model->viewcount=$viewcount;
 $model->you_desc=$description;
 $model->publish_date=$date;
 $model->defaultt=$descdefault;
 $model->medium=$descdmedium;
 $model->high=$deschigh;
 $model->standard=$descstandard;
 }
 }
$model->save();
return $this->redirect(['index']);
} else {
            return $this->render('create', [
                'model' => $model,
                'catgorylist'=>$catgorylist,
            ]);
        }
    }

    /**
     * Updates an existing VideoManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $video_id=$id;
        $model = $this->findModel($id);

         $catgorylist=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');

            if ($model->load(Yii::$app->request->post())) {

                if($_FILES['VideoManagement']['name']['video_image'] !='' ){

                if ($_FILES['VideoManagement']['error']['video_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'video_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->video_image = $image_name;
            }
            }

            $video_typenew=$_POST['video_type'];
            $cat_id=$_POST['VideoManagement']['auto_id'];

            $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='No' WHERE auto_id=".$cat_id);
            $command->execute();
            
             $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='$video_typenew' WHERE video_id=".$video_id);
            $command->execute();
            $youtube_url=$_POST['VideoManagement']['youtube_url'];
           if($_FILES['VideoManagement']['name']['video_image'] !=''){
            $video_image=$image_name;
            }
            else{
            $video_image="";
            }
            $video_name=$_POST['VideoManagement']['video_name'];
            $youtube_id=$_POST['VideoManagement']['youtube_id'];
            $you_desc=$_POST['VideoManagement']['you_desc'];
            $auto_id=$_POST['VideoManagement']['auto_id'];
            $active_status=$_POST['VideoManagement']['active_status'];
            $video_name=addslashes($video_name);

            $youtube_id=$_POST['VideoManagement']['youtube_id'];
     $viewcount="";       
     $description="";       
     $descdefault="";       
     $descdmedium="";       
     $deschigh="";    
     $descstandard="";   
if($youtube_id!=""){
 $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id=".$youtube_id.",&key=AIzaSyB6kgcOTBIk6DU-CkGc3ZhD4WizC7RIUIw";
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_URL,$url);
 $result=curl_exec($ch);
curl_close($ch);
//echo "<pre>";print_r($result);die;
$result=json_decode($result);
$result=ArrayHelper::toArray($result);
$items_column=ArrayHelper::getColumn($result['items'],'snippet');
$snipt=$items_column[0];
//echo "<pre>";  print_r($result['items'][0]['statistics']);die;
 if($snipt!=""){
 $viewcount=$result['items'][0]['statistics']['viewCount'];
 $description=$snipt['description'];
 $date=$snipt['publishedAt'];
 $date= date_format(date_create($date),'Y-m-d H:i:s');
 $descdefault=$snipt['thumbnails']['default']['url'];
 $descdmedium=$snipt['thumbnails']['medium']['url'];
 $deschigh=$snipt['thumbnails']['high']['url'];
 $descstandard=$snipt['thumbnails']['standard']['url'];

 }
 }


 //print_r($viewcount);die;
            if($video_image!=''){
           /*  $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='$video_typenew', video_name='$video_name', youtube_id='$youtube_id', youtube_url='$youtube_url', you_desc='$description', auto_id='$auto_id', video_image='$video_image',viewcount='$viewcount',defaultt='$descdefault',medium='$descdmedium',high='$deschigh',standard='$descstandard',publish_date='$date',active_status='$active_status' WHERE video_id=".$video_id);

              $command->execute();*/
              $valid_sub_number=VideoManagement::updateAll(['video_type' => $video_typenew,'video_name' => $video_name,'youtube_id'=> $youtube_id,'youtube_url' => $youtube_url,'you_desc'=> $description,'auto_id' => $auto_id,'video_image'=> $video_image,'viewcount' => $viewcount,'defaultt'=> $descdefault,'medium'=> $descdmedium,'high' => $deschigh,'standard'=> $descstandard,'publish_date' => $date,'active_status'=> $active_status], ['video_id' => $video_id]);

              }
              else{
               /*$command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='$video_typenew', video_name='$video_name', youtube_id='$youtube_id', youtube_url='$youtube_url', you_desc='$description', auto_id='$auto_id',viewcount='$viewcount',defaultt='$descdefault',medium='$descdmedium',publish_date='$date',high='$deschigh',standard='$descstandard', active_status='$active_status' WHERE video_id=".$video_id);
              $command->execute();*/
              $valid_sub_number=VideoManagement::updateAll(['video_type' => $video_typenew,'video_name' => $video_name,'youtube_id'=> $youtube_id,'youtube_url' => $youtube_url,'you_desc'=> $description,'auto_id' => $auto_id,'viewcount' => $viewcount,'defaultt'=> $descdefault,'medium'=> $descdmedium,'high' => $deschigh,'standard'=> $descstandard,'publish_date' => $date,'active_status'=> $active_status], ['video_id' => $video_id]);
              }

            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                 'catgorylist'=>$catgorylist,
            ]);
        }
    }

    /**
     * Deletes an existing VideoManagement model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
public function actionNotity($id)
{    
$model = $this->findModel($id);
$model2=ArrayHelper::toArray($model);
$postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);
echo "<pre>"; print_r($requestInput);die;
if(!empty($model2)){
$title=$model2['video_name'];
$youtube_id=$model2['youtube_id'];
$auto_id=$model2['auto_id'];
$image=$model2['medium'];
$msg_1=array('image'=>$image,'title'=>$title,'msg' => "New Video uploaded.",'video_id'=>$youtube_id,'cat_id'=>$auto_id);
$msg1 =array('message'=>json_encode($msg_1));
$fields = array('to' =>"/topics/all", 'data' => $msg1);
$url = 'https://fcm.googleapis.com/fcm/send';
$apikey="AAAAAu7-lGI:APA91bFPHee1kUs8fnk7BBTutkuz7ZRlJsM1zpccDZWTRlo38A_q3UvHPNhWDMbIbq0LUBrbxbRjx51kAq5nI_8cH8Y12agTRyp0sOTKzDOVA_qdHpk0RCGuVSFODep6LkEs7Gz0lt_b";
//building headers for the request
$headers = array('Authorization: key=' . $apikey, 'Content-Type: application/json');
        $ch = curl_init();
        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, $url);
        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);
        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        //finally executing the curl request
        $result = curl_exec($ch);
       // print_r(json_decode($result));die;
        $conditions=json_decode($result);
    //    print_r($conditions->message_id);die;
         if(isset($conditions->message_id)){
        VideoManagement::updateAll(['last_notify_date'=>date("Y-m-d H:i:s")],['video_id'=>$id]);
        Yii::$app->getSession()->setFlash('success', 'Notifications send successfully.');
         }
        //if($result[''])
        if ($result === FALSE) {
        die('Curl failed: ' . curl_error($ch));
        }
    curl_close($ch);

        return $this->redirect(['index']);
    }else{

        Yii::$app->getSession()->setFlash('danger', 'Notifications not send.');
       
       return $this->redirect(['index']);
    }
    }

    public function actionRefresh($id)
    {
     
$bunchinfo_cat=VideoManagement::find()
            ->select(['youtube_id'=>'youtube_id'])
             ->where(['video_id'=>$id])
            ->asArray()
            ->one();
$youtube_id=$bunchinfo_cat['youtube_id'];       
if($youtube_id!=""){
    $viewcount="";       
     $description="";       
     $descdefault="";       
     $descdmedium="";       
     $deschigh="";    
     $descstandard=""; 
 $url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id=".$youtube_id.",&key=AIzaSyB6kgcOTBIk6DU-CkGc3ZhD4WizC7RIUIw";
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 curl_setopt($ch, CURLOPT_URL,$url);
 $result=curl_exec($ch);
curl_close($ch);
$result=json_decode($result);

$result=ArrayHelper::toArray($result);
$items_column=ArrayHelper::getColumn($result['items'],'snippet');
$snipt=$items_column[0];
//echo "<pre>";  print_r($result['items'][0]['statistics']);die;
 if($snipt!=""){
 $viewcount=$result['items'][0]['statistics']['viewCount'];
 $description=$snipt['description'];
 $date=$snipt['publishedAt'];
 $date= date_format(date_create($date),'Y-m-d H:i:s');
 $descdefault=$snipt['thumbnails']['default']['url'];
 $descdmedium=$snipt['thumbnails']['medium']['url'];
 $deschigh=$snipt['thumbnails']['high']['url'];
 $descstandard=$snipt['thumbnails']['standard']['url'];
 }
 
$valid_sub_number=VideoManagement::updateAll(['viewcount' => $viewcount,'defaultt'=> $descdefault,'medium'=> $descdmedium,'high' => $deschigh,'standard'=> $descstandard,'publish_date' => $date], ['video_id' => $id]);


Yii::$app->getSession()->setFlash('success', ' Data Fetched successfully.');
return $this->redirect(['index']);
 }else{
Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
return $this->redirect(['index']);
 }
}

    /**
     * Finds the VideoManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VideoManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VideoManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
