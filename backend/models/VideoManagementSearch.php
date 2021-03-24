<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VideoManagement;

/**
 * VideoManagementSearch represents the model behind the search form about `backend\models\VideoManagement`.
 */
class VideoManagementSearch extends VideoManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['video_id', 'auto_id', 'active_status'], 'integer'],
            [['video_name','youtube_url', 'you_desc', 'category_name','video_type','youtube_id','active_status','publish_date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VideoManagement::find()
        ->orderBy(['video_id' => SORT_DESC])
        ->joinWith(['lead']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'video_id' => $this->video_id,
            'auto_id' => $this->auto_id,
            'active_status' => $this->active_status,
        ]);

        $query->andFilterWhere(['like', 'youtube_url', $this->youtube_url])
        ->andFilterWhere(['like', 'active_status', $this->active_status])
        ->andFilterWhere(['like', 'video_type', $this->video_type])
        ->andFilterWhere(['like', 'category_management.category_name', $this->category_name])
        ->andFilterWhere(['like', 'video_name', $this->video_name])
        ->andFilterWhere(['like', 'youtube_id', $this->youtube_id])
        ->andFilterWhere(['like', 'you_desc', $this->you_desc]);

        return $dataProvider;
    }
}
