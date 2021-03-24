<?php

namespace backend\controllers;

use Yii;
use backend\models\ApiFetchDetails;
use backend\models\VideoManagement;
use backend\models\ApiFetchDetailsSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use backend\models\CategoryManagement; 
use yii\filters\VerbFilter;

/**
 * ApiFetchDetailsController implements the CRUD actions for ApiFetchDetails model.
 */
class ApiFetchDetailsController extends Controller
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
     * Lists all ApiFetchDetails models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApiFetchDetailsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApiFetchDetails model.
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
     * Creates a new ApiFetchDetails model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
public function actionCreate()
{
$model = new ApiFetchDetails();
$catgorylist=ArrayHelper::map(CategoryManagement::find()->where(['active_status'=>1])->asArray()->all(), 'auto_id', 'category_name');

if ($model->load(Yii::$app->request->post())) {
$category=Yii::$app->request->post()['ApiFetchDetails']['category_id'];

$modelnew=$bunchinfo=ApiFetchDetails::find()
            ->select([
            'category_id'=>'category_id','id'=>'id'])
            ->where(['category_id'=>$category])
            
            ->asArray()
            ->one();
if(!empty($modelnew)){
$api_id=$modelnew['id'];
$cat_id=$modelnew['category_id'];
//print_r($cat_id);die;
$bunchinfo=VideoManagement::find()
            ->select([
            'youtube_id'=>'youtube_id',
            'auto_id'=>'auto_id'])
            ->where(['auto_id'=>$category])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->all();
if(!empty($bunchinfo)){
$bunchinfo_getcolumn=ArrayHelper::getColumn($bunchinfo,'youtube_id');
$bunchinfo_implode=implode(',', $bunchinfo_getcolumn);    
$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id=".$bunchinfo_implode.",&key=AIzaSyAkc7I-DENTOA5uTaQobcxRuRJo7xB2ZCw";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
//print_r($result);die;
}else{
$result="";
}
$model->category_id=$category;
$model->json_data=$result;

if(!empty($api_id)){
 $command = Yii::$app->db->createCommand("UPDATE api_fetch_details SET category_id='$category',json_data='$result' WHERE id=".$api_id);
 $command->execute();
 Yii::$app->getSession()->setFlash('success', 'Fetch Saved successfully.');
    return $this->redirect(['index']);
}
else{
    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
               return $this->render('create', [
                'model' => $model,
                'catgorylist'=>$catgorylist,
            ]);
       }
}else{
$bunchinfo=VideoManagement::find()
            ->select([
            'youtube_id'=>'youtube_id',
            'auto_id'=>'auto_id'])
            ->where(['auto_id'=>$category])
            ->orderBy(['video_id'=>SORT_DESC])
            ->asArray()
            ->all();
if(!empty($bunchinfo)){
$bunchinfo_getcolumn=ArrayHelper::getColumn($bunchinfo,'youtube_id');
$bunchinfo_implode=implode(',', $bunchinfo_getcolumn);    
$url = "https://www.googleapis.com/youtube/v3/videos?part=snippet,contentDetails,statistics&id=".$bunchinfo_implode.",&key=AIzaSyAkc7I-DENTOA5uTaQobcxRuRJo7xB2ZCw";
$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL,$url);
$result=curl_exec($ch);
curl_close($ch);
//print_r($result);die;
}else{
$result="";
}
$model->category_id=$category;
$model->json_data=$result;
if($model->save()){
    Yii::$app->getSession()->setFlash('success', 'Fetch Saved successfully.');
    return $this->redirect(['index']);
}else{
    Yii::$app->getSession()->setFlash('error', 'Something went wrong !');
                     return $this->render('create', [
                'model' => $model,
                'catgorylist'=>$catgorylist,
            ]);
       }

}
        } else {
            return $this->render('create', [
                'model' => $model,
                'catgorylist'=>$catgorylist,
            ]);
        }
    }
    /**
     * Updates an existing ApiFetchDetails model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ApiFetchDetails model.
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
     * Finds the ApiFetchDetails model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ApiFetchDetails the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ApiFetchDetails::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
