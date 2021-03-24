<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FlashScreen;

/**
 * FlashScreenSearch represents the model behind the search form about `backend\models\FlashScreen`.
 */
class FlashScreenSearch extends FlashScreen
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['flash_id'], 'integer'],
            [['flash_name', 'bg_screen', 'title_screen', 'created_at', 'updated_at'], 'safe'],
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
        $query = FlashScreen::find();

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
            'flash_id' => $this->flash_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'flash_name', $this->flash_name])
            ->andFilterWhere(['like', 'bg_screen', $this->bg_screen])
            ->andFilterWhere(['like', 'title_screen', $this->title_screen]);

        return $dataProvider;
    }
}
