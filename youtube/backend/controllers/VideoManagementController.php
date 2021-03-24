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
            if($video_image!=''){
             $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='$video_typenew', video_name='$video_name', youtube_id='$youtube_id', youtube_url='$youtube_url', you_desc='$you_desc', auto_id='$auto_id', video_image='$video_image', active_status='$active_status' WHERE video_id=".$video_id);
              $command->execute();
              }
              else{
               $command = Yii::$app->db->createCommand("UPDATE video_management SET video_type='$video_typenew', video_name='$video_name', youtube_id='$youtube_id', youtube_url='$youtube_url', you_desc='$you_desc', auto_id='$auto_id', active_status='$active_status' WHERE video_id=".$video_id);
              $command->execute();
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
