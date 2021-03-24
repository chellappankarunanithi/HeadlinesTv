<?php
namespace frontend\controllers;
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

    //Service
     

     


      public function actionCategorylistyoutube(){

       echo "gh";
        die;
        $list = array();
        $postd=(Yii::$app ->request ->rawBody);
        $requestInput = json_decode($postd,true);   
        $list['status'] = 'error';
        $list['message'] = 'Nill';  
        if($requestInput['authkey']=="youtubeapi"){
            $bunch_ids=$requestInput['category_id'];
            $bunchinfo=CategoryManagement::find()->where(['IN','auto_id',$bunch_ids])->asArray()->all();
            $result_array=array();
            if($bunchinfo){
            $bunchinfor_index=ArrayHelper::index($bunchinfo,'bunch_autoid');            
            foreach ($bunch_ids as $bunch_one) {
                if(isset($bunchinfor_index[$bunch_one])){
                    $arr=array();
                    $arr['bunch_id']=$bunch_one;
                    $arr['delivery_by']=$bunchinfor_index[$bunch_one]['service_vehicle_deliveredby_id'];
                    $arr['reinspection']=$bunchinfor_index[$bunch_one]['reinspection_done_by_id'];
                    $result_array[]=$arr;
                }
            }
            }
            $list['status']='success';
            $list['message'] = 'deliveredb_reinspection_done';  
            $list['results']=$result_array;
        }
        
        $response['Output'][]=$list;
        return json_encode($response);
 }

    //Servie

    /**
     * Displays a single CategoryManagement model.
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
     * Creates a new CategoryManagement model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CategoryManagement();

        if ($model->load(Yii::$app->request->post())) {
           // echo "<pre>";
              
             // print_r($_POST);print_r($_FILES);die;

            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_image = $image_name;
            }

            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', 'Logo Saved successfully.');
                   return $this->redirect(['view', 'id' => $model->auto_id]);                } 
                   else {
                    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
                     return $this->render('create', [
                'model' => $model,
            ]);
                }
          
        } 

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['index']);
        } else {
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }

        if ($model->load(Yii::$app->request->post())) {
            
            if ($_FILES['CategoryManagement']['error']['category_image'] == 0) {
                 //echo"sds";die;               
                    $rand = rand(0, 99999); // random number generation for unique image save
                  //  $model->scenario = 'imageUploaded';
                    $model->file = UploadedFile::getInstance($model, 'category_image');
                    $image_name = 'images/youtube/' . $model->file->basename . $rand . "." . $model->file->extension;
                    $model->file->saveAs($image_name);
                    $model->category_image = $image_name;
                    $model->save();
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
