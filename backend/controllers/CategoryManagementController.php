<?php

namespace backend\controllers;

use Yii;
use backend\models\CategoryManagement;
use backend\models\CategoryManagementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;

/**
 * CategoryManagementController implements the CRUD actions for CategoryManagement model.
 */
class CategoryManagementController extends Controller
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
     * Lists all CategoryManagement models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategoryManagementSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CategoryManagement model.
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
     * Creates a new CategoryManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryManagement();

        if ($model->load(Yii::$app->request->post())) {
            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_image = $image_name;
            }

            if ($_FILES['CategoryManagement']['error']['category_icon'] == 0) {
                    $rand = rand(0, 99999);
                    $model->file = UploadedFile::getInstance($model, 'category_icon');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_icon = $image_name;
            }

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Category Saved successfully.');
                   return $this->redirect(['index']); } 
                   else {
                   Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
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
     * Updates an existing CategoryManagement model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id); 

        $Categoryid=$id;
        if ($model->load(Yii::$app->request->post())) {

              $category_name=$_POST['CategoryManagement']['category_name'];
              $category_desc=$_POST['CategoryManagement']['category_desc'];
              $slug=$_POST['CategoryManagement']['slug'];
              $active_status=$_POST['CategoryManagement']['active_status'];
              $home_status=$_POST['CategoryManagement']['home_status'];

           // echo "<pre>";       print_r($_FILES);die;
            
            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $category_image = $image_name;
              }else{
                $category_image="";
              }
             
             //print_r($category_image);die;

              if ($_FILES['CategoryManagement']['error']['category_icon'] == 0) {
                    $rand = rand(0, 99999);
                    $model->file = UploadedFile::getInstance($model, 'category_icon');
                    $image_name1 = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name1);
                    $category_image1 = $image_name1;
            }else{
                $category_image1="";
              }

              if($category_image!='' && $category_image1!=''){
             $command = Yii::$app->db->createCommand("UPDATE category_management SET category_name='$category_name', category_desc='$category_desc', slug='$slug', active_status='$active_status',home_status='$home_status',category_image='$category_image',category_icon='$category_image1' WHERE auto_id=".$Categoryid);
              $command->execute();
              }
              else if($category_image!=''){
                $command = Yii::$app->db->createCommand("UPDATE category_management SET category_name='$category_name', category_desc='$category_desc', slug='$slug', active_status='$active_status',home_status='$home_status',category_image='$category_image' WHERE auto_id=".$Categoryid);
                $command->execute();

              }
              else if($category_image1!=""){
               
                 $command = Yii::$app->db->createCommand("UPDATE category_management SET category_name='$category_name', category_desc='$category_desc', slug='$slug', active_status='$active_status',home_status='$home_status',category_icon='$category_image1' WHERE auto_id=".$Categoryid);
                 $command->execute();
              }
              else{

                  $command = Yii::$app->db->createCommand("UPDATE category_management SET category_name='$category_name', category_desc='$category_desc', slug='$slug', active_status='$active_status',home_status='$home_status' WHERE auto_id=".$Categoryid);
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
     * Deletes an existing CategoryManagement model.
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
     * Finds the CategoryManagement model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CategoryManagement the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CategoryManagement::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
