<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\CategoryManagement;

/**
 * CategoryManagementSearch represents the model behind the search form about `backend\models\CategoryManagement`.
 */
class CategoryManagementSearch extends CategoryManagement
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auto_id', 'category_image'], 'integer'],
            [['category_name','slug', 'category_desc','active_status','home_status'], 'safe'],
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
        $query = CategoryManagement::find();

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
            'auto_id' => $this->auto_id,
            'category_image' => $this->category_image,
        ]);

        $query
        ->andFilterWhere(['like', 'category_name', $this->category_name])
         ->andFilterWhere(['like', 'slug', $this->slug])
        ->andFilterWhere(['like', 'active_status', $this->active_status])
        ->andFilterWhere(['like', 'home_status', $this->home_status])
        ->andFilterWhere(['like', 'category_desc', $this->category_desc]);

        return $dataProvider;
    }
}
