<?php

namespace backend\controllers;

use Yii;
use backend\models\FlashScreen;
use backend\models\FlashScreenSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FlashScreenController implements the CRUD actions for FlashScreen model.
 */
class FlashScreenController extends Controller
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
     * Lists all FlashScreen models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlashScreenSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FlashScreen model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FlashScreen model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FlashScreen();

        if ($model->load(Yii::$app->request->post())) {
            if ($_FILES['FlashScreen']['error']['bg_screen'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'bg_screen');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->bg_screen = $image_name;
            }

            if ($_FILES['FlashScreen']['error']['title_screen'] == 0) {
                    $rand = rand(0, 99999);
                    $model->file = UploadedFile::getInstance($model, 'title_screen');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->title_screen = $image_name;
            }

            if ($model->save()) {
                //Yii::$app->getSession()->setFlash('success', 'Category Saved successfully.');
                   return $this->redirect(['index']); } 
                   else {
                //    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
                     return $this->render('create', [
                'model' => $model,
            ]);
                }
          
        } 
        else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FlashScreen model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        
        $Categoryid=$id;
        if ($model->load(Yii::$app->request->post())) {

              $category_name=$_POST['FlashScreen']['flash_name'];
              

           // echo "<pre>";       print_r($_FILES);die;
            if ($_FILES['FlashScreen']['error']['bg_screen'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'bg_screen');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $category_image = $image_name;
            }else{
                $category_image="";
              }

            if ($_FILES['FlashScreen']['error']['title_screen'] == 0) {
                    $rand = rand(0, 99999);
                    $model->file = UploadedFile::getInstance($model, 'title_screen');
                    $image_name1 = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name1);
                     $category_image1 = $image_name1;
            }
            else{
                $category_image1="";
              }
             
             //print_r($category_image);die;

              if($category_image!='' && $category_image1!=''){
             $command = Yii::$app->db->createCommand("UPDATE flash_screen SET flash_name='$category_name',bg_screen='$category_image',title_screen='$category_image1' WHERE flash_id=".$Categoryid);
              $command->execute();
              }
              else if($category_image!=''){
                $command = Yii::$app->db->createCommand("UPDATE flash_screen SET flash_name='$category_name',bg_screen='$category_image' WHERE flash_id=".$Categoryid);
                $command->execute();

              }
              else if($category_image1!=""){
               
                 $command = Yii::$app->db->createCommand("UPDATE flash_screen SET flash_name='$category_name',title_screen='$category_image1' WHERE flash_id=".$Categoryid);
                 $command->execute();
              }
              else{

                  $command = Yii::$app->db->createCommand("UPDATE flash_screen SET flash_name='$category_name' WHERE flash_id=".$Categoryid);
              $command->execute();
              }
              
            
              return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FlashScreen model.
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
     * Finds the FlashScreen model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FlashScreen the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FlashScreen::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
